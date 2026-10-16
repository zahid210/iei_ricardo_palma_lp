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

Además, el `index.php` **no** es el del repo: en el hosting la app vive en
`/ricardo_palma_core` (no en la carpeta padre), así que lleva rutas distintas.
Para no perderlo, su versión "buena" se guarda en `deploy/public_html/index.php`
y el despliegue la copia siempre:

- `deploy/public_html/index.php` → `public_html/index.php`

> Si algún día cambias el `index.php` **del servidor**, actualiza también su copia
> en `deploy/public_html/index.php` y haz push, para que no se pierda.
>
> El **`.htaccess`**, en cambio, **sí** se despliega directamente desde el repo:
> edita `public/.htaccess` con total tranquilidad (se sube a `/public_html/.htaccess`).

### ¿Dónde edito cada cosa?

| Quiero cambiar…                         | Edita en el repo…                     |
|-----------------------------------------|---------------------------------------|
| Cabeceras de seguridad / caché en Apache | `public/.htaccess` (se despliega solo) |
| Arranque de producción (`index.php`)     | `deploy/public_html/index.php`         |
| Código, vistas, rutas, CSS/JS fuente     | su sitio normal bajo `app/`, `resources/`, … |

## Qué NO se toca nunca (exclusiones)

`.env*`, `vendor/`, `node_modules/`, `storage/`, `bootstrap/cache/`,
`public/build/` (compilado en el servidor), `public/index.php` (se toma de
`deploy/`), `tests/`, `phpunit.xml`, `.git*` y `.phpunit.result.cache`.

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

## Caché (rendimiento)

- **Assets** (`build/`, imágenes, fuentes): caché agresiva definida en
  `public/.htaccess` (Vite: 1 año _immutable_; imágenes: 30 días).
- **Páginas HTML** (`/`, `/nosotros`, `/docentes`, `/noticias`): se cachean en el
  servidor 1 hora (`app/Http/Middleware/CacheResponse.php`), pero **la caché se
  invalida sola en cada despliegue** y al navegador se le pide que revalide
  siempre (`max-age=0`). Resultado: los cambios se ven **al instante** y el sitio
  sigue rápido (el servidor evita BD + Blade).
- **Galería**: los datos se cachean 12 h y se refrescan al sincronizar
  (`SincronizarGaleria`).
- `CACHE_STORE=database` (el `.env`). La tabla `cache` ya existe; no hay que
  hacer nada. Alternativa opcional: `file` (algo más rápido).
- ⚠️ **Nunca cachees objetos Eloquent** (modelos o Collections). Laravel 13 ya no
  deserializa clases desde la caché por defecto
  (`config/cache.php`: `'serializable_classes' => false`, por seguridad). Un objeto
  cacheado vuelve como `__PHP_Incomplete_Class` y **rompe la página con error 500**.
  **Cachea siempre arrays o escalares** (p. ej. `->toArray()`) y reconstruye los
  modelos con `Galeria::hydrate($array)` si los necesitas. Ojo: el driver de caché
  de los tests (`array`) **no serializa**, así que este fallo no se ve en tests a
  menos que fuerces el driver `database`/`file` (ver `tests/Feature/GaleriaCacheTest.php`).
- En este hosting **no hay shell**, así que no se puede ejecutar
  `php artisan optimize` / `config:cache`; tampoco hace falta (Laravel funciona
  sin cachear config/rutas, y así los cambios aplican al instante).

## Qué pasa con `vendor/` y `public/build/`

No se suben. Se generan/compilan **en el servidor** y ya están ahí. Si algún día
cambian dependencias (`composer.json`) o el front-end (`package.json`, Vite),
hay que actualizarlos en el servidor por separado (no hay shell/SSH).
