# Despliegue automático a cPanel (GitHub → cPanel)

Este proyecto se despliega **automáticamente** en el hosting al hacer `push` a la
rama `main`. No hace falta volver a subir `.zip`.

## Cómo funciona

```
git push origin main
      │
      ▼
GitHub Actions  (.github/workflows/deploy.yml)
      │
      ├─ detecta qué archivos cambiaron (git diff)
      │
      └─ sube por FTPS a cPanel:
             • código de la app   →  /ricardo_palma_core
             • assets públicos    →  /public_html
```

## Estructura del servidor (importante)

El sitio está **partido en dos** (por seguridad, para evitar _fuzzing_):

| Carpeta del servidor   | Contenido                                             |
|------------------------|-------------------------------------------------------|
| `/ricardo_palma_core`  | La aplicación Laravel (código, `config`, `app`, …)    |
| `/public_html`         | El _document root_: `index.php`, `.htaccess`, `images/`, `build/`, `robots.txt`, `sitemap.xml` |

Además, `public_html` tiene **2 archivos personalizados** que **no** son los del
repo (llevan ajustes de SEO y de seguridad). Para no perderlos, sus versiones
"buenas" se guardan en `deploy/public_html/` y el despliegue las copia siempre:

- `deploy/public_html/index.php` → `public_html/index.php`
- `deploy/public_html/.htaccess` → `public_html/.htaccess`

> Si algún día cambias el `index.php` o el `.htaccess` del servidor, actualiza
> también su copia en `deploy/public_html/` y haz push, para que no se pierda.

## Qué NO se toca nunca (exclusiones)

`.env*`, `vendor/`, `node_modules/`, `storage/`, `bootstrap/cache/`,
`public/build/` (compilado en el servidor), `.git*`, `.phpunit.result.cache`,
y los 2 archivos personalizados de arriba (se toman de `deploy/`).

## Configuración (una sola vez)

En GitHub → **Settings → Secrets and variables → Actions → New repository secret**,
crear 3 secretos:

| Secret     | Valor                                                        |
|------------|--------------------------------------------------------------|
| `FTP_HOST` | `ftp.iericardopalmapasco.edu.pe`                             |
| `FTP_USER` | `deploy@iericardopalmapasco.edu.pe` (cuenta FTP de despliegue) |
| `FTP_PASS` | la contraseña de esa cuenta FTP                              |

> Usa la cuenta FTP **dedicada** de despliegue (no la principal de cPanel), así
> se puede revocar sin afectar tu acceso.

## Primer despliegue (sincronización completa)

1. Carga los 3 Secrets (arriba).
2. Ve a **Actions → "Desplegar a cPanel" → Run workflow** (rama `main`).
3. Eso hace una **sincronización completa** (sube todo lo rastreado).

A partir de ahí, cada `push` a `main` despliega solo lo que cambió.

## Uso diario

```bash
git add -A
git commit -m "cambios"
git push origin main
```

Listo: en ~1 minuto los cambios están en el sitio.

## Qué pasa con `vendor/` y `public/build/`

No se suben. Se generan/compilan **en el servidor** y ya están ahí. Si algún día
cambian dependencias (`composer.json`) o el front-end (`package.json`, Vite),
hay que actualizarlos en el servidor por separado (no hay shell/SSH).
