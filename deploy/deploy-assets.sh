#!/usr/bin/env bash
# ---------------------------------------------------------------------------
#  Sube los artefactos COMPILADOS que no vienen del repositorio.
#
#  El front-end se compila en GitHub Actions (`npm ci && npm run build`) y se
#  sube aquí, de modo que un push con cambios de CSS/JS/Tailwind se refleje
#  solo en el sitio, sin subir nada a mano.
#
#  IMPORTANTE (hosting partido):
#    - El navegador pide los assets a  /public_html/build/assets/*
#    - @vite lee el manifest de      /ricardo_palma_core/public/build/manifest.json
#  Por eso hay que subir la MISMA carpeta build/ a los DOS sitios.
#
#  No usamos --delete a propósito: Vite genera nombres con hash, así que los
#  assets antiguos pueden quedarse sin romper nada (y evita 404 si hay HTML
#  cacheado apuntando a un asset anterior).
#
#  Requiere: FTP_HOST, FTP_USER, FTP_PASS (mismos Secrets que deploy.sh).
# ---------------------------------------------------------------------------
set -euo pipefail

: "${FTP_HOST:?Falta FTP_HOST (secret)}"
: "${FTP_USER:?Falta FTP_USER (secret)}"
: "${FTP_PASS:?Falta FTP_PASS (secret)}"

PUB_DIR="/public_html"
APP_DIR="/ricardo_palma_core"
LOCAL_BUILD="public/build"

if [ ! -f "$LOCAL_BUILD/manifest.json" ]; then
  echo "ERROR: no existe $LOCAL_BUILD/manifest.json." >&2
  echo "       Ejecuta 'npm ci && npm run build' antes de este script." >&2
  exit 1
fi

LFTP_SCRIPT="$(mktemp)"
trap 'rm -f "$LFTP_SCRIPT"' EXIT

{
  echo "set ftp:ssl-force true"
  echo "set ftp:ssl-protect-data true"
  echo "set ssl:verify-certificate no"
  echo "set net:timeout 60"
  echo "set net:max-retries 3"
  echo "set net:reconnect-interval-base 5"
  echo "set cmd:fail-exit yes"
  echo "set xfer:clobber on"
  echo "set mirror:parallel-transfer-count 4"
  echo "open -u $FTP_USER,$FTP_PASS ftp://$FTP_HOST"
  echo "mirror -R \"$LOCAL_BUILD\" \"$PUB_DIR/build\""
  echo "mirror -R \"$LOCAL_BUILD\" \"$APP_DIR/public/build\""
  echo "quit"
} > "$LFTP_SCRIPT"

echo ">> Subiendo $LOCAL_BUILD -> $PUB_DIR/build (assets que sirve el navegador)"
lftp -f "$LFTP_SCRIPT"
echo ">> OK: assets compilados desplegados en las dos ubicaciones."
