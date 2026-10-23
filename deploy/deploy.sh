#!/usr/bin/env bash
# ---------------------------------------------------------------------------
#  Despliegue del repositorio a cPanel por FTPS.
#
#    Codigo de la app  ->  /ricardo_palma_core
#    Assets publicos   ->  /public_html
#
#  Variables de entorno (vienen de los GitHub Secrets):
#    FTP_HOST, FTP_USER, FTP_PASS
#
#  Modo de despliegue (variable MODE):
#    full  -> sube TODOS los archivos rastreados por git (primera vez)
#    diff  -> sube solo lo que cambio entre BEFORE..SHA (y borra lo eliminado)
#
#  Reglas de seguridad (NUNCA se tocan):
#    .env*, vendor/, node_modules/, storage/, bootstrap/cache/,
#    public/build/, .git*, tests/, y public/index.php (el index.php de
#    produccion se toma de deploy/public_html/index.php porque en el hosting
#    la app vive en /ricardo_palma_core).
#
#  public/.htaccess SI se despliega (a /public_html/.htaccess).
# ---------------------------------------------------------------------------
set -euo pipefail

: "${FTP_HOST:?Falta FTP_HOST (secret)}"
: "${FTP_USER:?Falta FTP_USER (secret)}"
: "${FTP_PASS:?Falta FTP_PASS (secret)}"

APP_DIR="/ricardo_palma_core"
PUB_DIR="/public_html"
MODE="${MODE:-diff}"
BEFORE="${BEFORE:-}"
SHA="${SHA:-$(git rev-parse HEAD 2>/dev/null || echo '')}"

# ---------- base del diff: ultimo SHA desplegado con exito ----------
# BEFORE (github.event.before) es el push anterior. Si ese push fallo (p. ej.
# el build de CSS), sus cambios NUNCA llegaron al servidor y el siguiente push
# solo subiria los suyos, dejando un hueco. Para evitarlo, usamos el SHA que
# deploy.sh escribio en deploy-version.txt tras el ultimo despliegue correcto.
# Si no existe, no es un commit valido o no es ancestro de SHA, se usa BEFORE.
REMOTE_SHA=""
if command -v lftp >/dev/null 2>&1 && [ -n "$SHA" ]; then
  REMOTE_SHA="$(lftp -c "set ssl:verify-certificate no; set net:timeout 20; open -u $FTP_USER,$FTP_PASS ftp://$FTP_HOST; cat $APP_DIR/deploy-version.txt" 2>/dev/null | tr -d '[:space:]' || true)"
fi

if printf '%s' "$REMOTE_SHA" | grep -qE '^[0-9a-f]{40}$' \
   && git cat-file -e "${REMOTE_SHA}^{commit}" 2>/dev/null \
   && git merge-base --is-ancestor "$REMOTE_SHA" "$SHA" 2>/dev/null; then
  if [ "$REMOTE_SHA" != "$BEFORE" ]; then
    echo ">> Base del diff: $REMOTE_SHA (ultimo despliegue correcto)"
  fi
  BEFORE="$REMOTE_SHA"
fi

# ---------- mapeo repo -> servidor ----------
# Imprime la ruta remota, o devuelve 1 si el archivo NO debe desplegarse.
remote_path() {
  case "$1" in
    .github/*|deploy/*|.githooks/*)      return 1 ;;
    public/index.php)                    return 1 ;;   # lo aporta deploy/public_html/index.php
    public/build/*)                      return 1 ;;   # lo sube deploy-assets.sh (compilado en CI)
    .env|.env.*|vendor/*|node_modules/*) return 1 ;;
    storage/*|bootstrap/cache/*)         return 1 ;;   # datos/estado del servidor
    tests/*)                             return 1 ;;   # no se suben los tests al servidor
    .phpunit.result.cache|phpunit.xml)   return 1 ;;
    public/*) printf '%s/%s\n' "$PUB_DIR" "${1#public/}" ;;
    *)        printf '%s/%s\n' "$APP_DIR" "$1" ;;
  esac
}

# ---------- construir el script de lftp ----------
LFTP_SCRIPT="$(mktemp)"
VERSION_FILE="$(mktemp)"
FLAG_DIR="$(mktemp -d)"
trap 'rm -f "$LFTP_SCRIPT" "$VERSION_FILE"; rm -rf "$FLAG_DIR"' EXIT

{
  echo "set ftp:ssl-force true"
  echo "set ftp:ssl-protect-data true"
  echo "set ssl:verify-certificate no"
  echo "set net:timeout 40"
  echo "set net:max-retries 3"
  echo "set net:reconnect-interval-base 5"
  echo "set cmd:fail-exit yes"
  echo "set xfer:clobber on"
  echo "open -u $FTP_USER,$FTP_PASS ftp://$FTP_HOST"
} > "$LFTP_SCRIPT"

queue_put() {   # $1 = ruta local, $2 = ruta remota
  printf 'mkdir -p -f "%s"\n' "$(dirname "$2")" >> "$LFTP_SCRIPT"
  printf 'put "%s" -o "%s"\n' "$1" "$2" >> "$LFTP_SCRIPT"
}
queue_rm() {    # $1 = ruta remota
  printf 'rm -f "%s"\n' "$1" >> "$LFTP_SCRIPT"
}

PUTS=0; DELS=0
NEED_COMPOSER=0
NEED_MIGRATE=0
upload_one() {
  local f="$1" r=""
  if r="$(remote_path "$f")" && [ -f "$f" ]; then
    queue_put "$f" "$r"; PUTS=$((PUTS+1))
  fi
}
delete_one() {
  local f="$1" r=""
  if r="$(remote_path "$f")"; then
    queue_rm "$r"; DELS=$((DELS+1))
  fi
}

# ---------- decidir que subir ----------
if [ "$MODE" = "full" ] || [ -z "$BEFORE" ] \
   || [ "$BEFORE" = "0000000000000000000000000000000000000000" ] \
   || ! git cat-file -e "${BEFORE}^{commit}" 2>/dev/null; then
  echo ">> Modo COMPLETO: subiendo todos los archivos rastreados"
  while IFS= read -r f; do upload_one "$f"; done < <(git ls-files)
  NEED_MIGRATE=1
else
  echo ">> Modo INCREMENTAL: $BEFORE..$SHA"
  while IFS=$'\t' read -r st p1 p2; do
    case "$st" in
      A|M|T) upload_one "$p1" ;;
      D)     delete_one "$p1" ;;
      R*|C*) delete_one "$p1"; [ -n "${p2:-}" ] && upload_one "$p2" ;;
    esac
  done < <(git diff --name-status -M "$BEFORE" "$SHA")

  CHANGED_NAMES="$(git diff --name-only -M "$BEFORE" "$SHA" 2>/dev/null || true)"
  if printf '%s\n' "$CHANGED_NAMES" | grep -qxE 'composer\.(json|lock)'; then
    NEED_COMPOSER=1
  fi
  if printf '%s\n' "$CHANGED_NAMES" | grep -qE '^database/migrations/'; then
    NEED_MIGRATE=1
  fi
fi

# ---------- archivos personalizados del servidor (siempre al dia) ----------
# El unico archivo que no puede venir tal cual del repo es public/index.php
# (en produccion la app vive en /ricardo_palma_core, no en el directorio padre).
queue_put "deploy/public_html/index.php" "$PUB_DIR/index.php"; PUTS=$((PUTS+1))

# Marcador de version (SHA del commit): se sube SIEMPRE, en cada despliegue.
# El middleware CacheResponse lo lee para invalidar la cache de respuestas HTML
# automaticamente. NO se usa public_path('index.php'): en este hosting el public/
# de la app (/ricardo_palma_core/public) NO es el document root (/public_html),
# asi que ese archivo no existe y su filemtime era siempre 0 (cache que nunca se
# invalidaba).
printf '%s' "${SHA:-sin-sha}" > "$VERSION_FILE"
queue_put "$VERSION_FILE" "$APP_DIR/deploy-version.txt"; PUTS=$((PUTS+1))

# ---------- marcadores para el cron del servidor --------------
# deploy-cron.sh (ejecutado por un Cron Job de cPanel) lee estos archivos y
# ejecuta la tarea correspondiente. Se suben AL FINAL, cuando el código ya
# está completo. Cada marcador se borra solo si la tarea termina bien.
: > "$FLAG_DIR/clear"
queue_put "$FLAG_DIR/clear" "$APP_DIR/.deploy/clear"; PUTS=$((PUTS+1))

if [ "$NEED_MIGRATE" = 1 ]; then
  : > "$FLAG_DIR/migrate"
  queue_put "$FLAG_DIR/migrate" "$APP_DIR/.deploy/migrate"; PUTS=$((PUTS+1))
  echo ">> Marcador: hay migraciones pendientes"
fi

if [ "$NEED_COMPOSER" = 1 ]; then
  : > "$FLAG_DIR/composer"
  queue_put "$FLAG_DIR/composer" "$APP_DIR/.deploy/composer"; PUTS=$((PUTS+1))
  echo ">> Marcador: composer install pendiente"
fi

echo ">> Archivos a subir: $PUTS | a borrar: $DELS"
echo "quit" >> "$LFTP_SCRIPT"

lftp -f "$LFTP_SCRIPT"
echo ">> Despliegue completado correctamente."
