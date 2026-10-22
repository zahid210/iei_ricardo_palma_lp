#!/bin/bash
# ---------------------------------------------------------------------------
#  Tareas de despliegue que necesitan ejecutar PHP en el servidor y que, por
#  tanto, no se pueden hacer por FTPS.
#
#  Lo ejecuta un CRON JOB de cPanel (no hace falta shell SSH):
#
#      */5 * * * * /bin/bash /home/iericard/ricardo_palma_core/deploy-cron.sh
#
#  deploy.sh deja "marcadores" en .deploy/ tras cada push:
#     .deploy/composer -> composer install --no-dev  (solo si cambió el lock)
#     .deploy/migrate  -> php artisan migrate --force (solo si hay migraciones)
#     .deploy/clear    -> limpiar vistas/rutas compiladas (cada despliegue)
#
#  Cada tarea se borra SOLO si termina bien; si falla, se reintenta en la
#  siguiente pasada y queda registrada en storage/logs/deploy-cron.log.
# ---------------------------------------------------------------------------
set -u

APP="/home/iericard/ricardo_palma_core"
PHP="/opt/cpanel/ea-php84/root/usr/bin/php"
COMPOSER="/home/iericard/composer.phar"
LOG="$APP/storage/logs/deploy-cron.log"

export HOME="/home/iericard"
export PATH="/usr/local/bin:/usr/bin:/bin"

mkdir -p "$APP/storage/logs" "$APP/storage/framework" 2>/dev/null

log() { echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*" >> "$LOG"; }

# Rotación simple: si el log pasa de 1 MB, se guarda como .1
if [ -f "$LOG" ] && [ "$(stat -c%s "$LOG" 2>/dev/null || echo 0)" -gt 1048576 ]; then
  mv -f "$LOG" "$LOG.1" 2>/dev/null || true
fi

cd "$APP" || { log "ERROR: no existe $APP"; exit 1; }

# Evita dos ejecuciones solapadas (por si una tarea tarda más de 5 minutos).
LOCK="$APP/storage/framework/deploy-cron.lock"
if command -v flock >/dev/null 2>&1; then
  exec 9>"$LOCK"
  flock -n 9 || exit 0
fi

# --- Composer (solo cuando cambió composer.json/lock) ----------------------
if [ -f .deploy/composer ]; then
  log "== composer install --no-dev =="
  if [ -x "$PHP" ] && [ -f "$COMPOSER" ]; then
    if "$PHP" "$COMPOSER" install --no-dev --optimize-autoloader \
         --no-scripts --no-interaction --no-progress >>"$LOG" 2>&1; then
      # Regenerar el manifiesto de paquetes de Laravel (nuevos providers).
      "$PHP" artisan package:discover --no-ansi >>"$LOG" 2>&1 \
        || log "AVISO: package:discover falló"
      rm -f .deploy/composer
      log "composer OK"
    else
      log "ERROR: composer falló (se reintentará en la próxima pasada)"
    fi
  else
    log "ERROR: falta $PHP o $COMPOSER"
  fi
fi

# --- Migraciones -----------------------------------------------------------
if [ -f .deploy/migrate ]; then
  log "== artisan migrate --force =="
  if "$PHP" artisan migrate --force --no-ansi >>"$LOG" 2>&1; then
    rm -f .deploy/migrate
    log "migrate OK"
  else
    log "ERROR: migrate falló (se reintentará en la próxima pasada)"
  fi
fi

# --- Limpieza de vistas/rutas compiladas -----------------------------------
if [ -f .deploy/clear ]; then
  log "== limpiar vistas/rutas compiladas =="
  "$PHP" artisan view:clear >>"$LOG" 2>&1 || true
  "$PHP" artisan route:clear >>"$LOG" 2>&1 || true
  rm -f .deploy/clear
  log "clear OK"
fi

exit 0
