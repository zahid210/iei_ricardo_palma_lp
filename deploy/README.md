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
      ├─ compila el front-end   (npm ci && npm run build)
      │
      ├─ sube los assets compilados (deploy/deploy-assets.sh):
      │     • build/  →  /public_html/build
      │     • build/  →  /ricardo_palma_core/public/build
      │
      ├─ detecta qué archivos cambiaron (git diff)
      │
      └─ sube por FTPS a cPanel (deploy/deploy.sh):
             • código de la app   →  /ricardo_palma_core
             • assets públicos    →  /public_html
```

El **front-end se compila en cada push**. Tailwind escanea las vistas Blade, así
que cualquier clase nueva que se escriba en una vista se incluye sola en el CSS;
no hay que compilar ni subir nada a mano.

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
`public/index.php` (se toma de `deploy/`), `tests/`, `phpunit.xml`, `.git*` y
`.phpunit.result.cache`.

> `public/build/` **tampoco** se sube con el descriptor normal (está en
> `.gitignore`), pero **sí se despliega aparte**: GitHub Actions lo compila y lo
> sube con `deploy/deploy-assets.sh` a las dos ubicaciones. Ver más abajo.

## Configuración (una sola vez)

En GitHub → **Settings → Secrets and variables → Actions → New repository secret**,
crear 3 secretos:

| Secret     | Valor                                                        |
|------------|--------------------------------------------------------------|
| `FTP_HOST` | `ftp.tu-dominio.com`                                         |
| `FTP_USER` | `deploy@tu-dominio.com` (cuenta FTP de despliegue)           |
| `FTP_PASS` | la contraseña de esa cuenta FTP                              |

> Los valores reales **no** se guardan en el repo (es público): solo viven en los
> Secrets de GitHub y en cPanel.

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
- **Páginas HTML** (`/`, `/nosotros`, `/docentes`): se cachean en el
  servidor 1 hora (`app/Http/Middleware/CacheResponse.php`), pero **la caché se
  invalida sola en cada despliegue** y al navegador se le pide que revalide
  siempre (`max-age=0`). Resultado: los cambios se ven **al instante** y el sitio
  sigue rápido (el servidor evita BD + Blade).
  - `/noticias` se cachea solo **15 minutos** (`cache.response:900`), para que el
    feed de Facebook que lleva dentro se refresque seguido.
  - **Cómo funciona la invalidación:** `deploy/deploy.sh` escribe el **SHA del
    commit** en `deploy-version.txt` (raíz de la app) y lo sube **siempre**. El
    middleware lee ese archivo y lo mete en la clave de caché, así que cada push
    invalida la caché anterior. **No** se usa `public_path('index.php')`: en este
    hosting partido ese archivo **no existe** (ver más abajo), así que su
    `filemtime` era siempre `0` y la caché **nunca** se invalidaba.
- `CACHE_STORE=database` (el `.env`). La tabla `cache` ya existe; no hay que
  hacer nada. Alternativa opcional: `file` (algo más rápido).
- **Galería**: los datos se cachean 12 h y se refrescan al sincronizar
  (`SincronizarGaleria`).
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

## Feed de Facebook en `/noticias`

El **"Page Plugin" oficial de Facebook** (el iframe `fb-page`) dejó de cargar el
timeline **a nivel global**: muestra la cabecera de la página pero deja el área
de publicaciones en blanco/cargando, en todos los navegadores y también en la
propia herramienta de desarrolladores de Facebook. No es un fallo del enlace ni
de nuestro código, y **no se puede arreglar desde nuestro lado**.

Por eso el feed se trae ahora **desde nuestro servidor** con la Graph API
(`app/Services/FacebookFeed.php`) y se pinta con nuestro propio diseño
(`resources/views/noticias.blade.php`). Así la sección se ve **siempre** y se
mantiene **actualizada sola** (se cachea 15 min).

### Activación (una sola vez): token de Facebook

Requiere un **Page Access Token** en el `.env` **del servidor** (no en el repo,
que es público):

```
FACEBOOK_PAGE_ID=279471448578826
FACEBOOK_PAGE_TOKEN=...
FACEBOOK_GRAPH_VERSION=v21.0
```

Cómo obtenerlo:

1. Entra con la cuenta que **administra la página** en
   <https://developers.facebook.com/tools/explorer/>.
2. Permisos: añade `pages_show_list` y `pages_read_engagement`.
3. Pulsa **Generate Access Token** y autoriza.
4. En el desplegable **User or Page → Get Page Access Token**, elige la página
   de la institución y copia el token.
5. Para que **no caduque**, pégalo en
   <https://developers.facebook.com/tools/debug/accesstoken/> y pulsa
   **Extend Access Token** (obtienes uno de larga duración); vuelve a pedir el
   Page Token con ese.
6. Añade `FACEBOOK_PAGE_TOKEN` al `.env` del servidor (cPanel) y guarda.

**Sin token** la sección no se rompe: muestra un aviso con un botón
"Ver publicaciones en Facebook". En cuanto el token exista, el feed aparece solo
(no hay que tocar código ni desplegar).

> El token **no** se guarda en el repositorio. Si algún día se revoca o caduca,
> basta con generar otro y actualizar el `.env`.

## Front-end automático (`public/build/`)

**Ya no es manual.** En cada push, GitHub Actions:

1. instala las dependencias de Node (`npm ci`);
2. compila Vite/Tailwind (`npm run build`);
3. sube `public/build/` a **los dos** sitios con `deploy/deploy-assets.sh`:
   - `/public_html/build` → lo que descarga el navegador;
   - `/ricardo_palma_core/public/build` → el manifest que lee `@vite`.

Se compila **en cada push** (no solo cuando cambian `resources/`), porque
Tailwind genera el CSS a partir de las clases que encuentra en las vistas Blade.
Así, si un colaborador añade una clase nueva en una vista, aparece sin hacer
nada más.

> No se usa `--delete`: los assets de Vite llevan un hash en el nombre, así que
> los antiguos pueden quedarse sin romper nada (y se evitan 404 con HTML
> cacheado).

## Qué pasa con `vendor/`

No se sube automáticamente. Cambia muy rara vez (solo al añadir/quitar paquetes
en `composer.json`/`composer.lock`) y una subida FTPS parcial podría dejar el
`vendor/` a medias y romper el sitio. Cuando haga falta, se actualiza una vez a
mano (ver la sección de ReDoS más abajo); el resto de cambios (código, vistas,
CSS/JS, assets) ya van solos con `push`.

### ⚠️ El `public/` de la app NO es el document root (ojo con Vite)

En producción `public_path()` resuelve a `/ricardo_palma_core/public`, pero el
document root real es `/public_html`. Son **dos carpetas distintas**:

| Carpeta | Para qué sirve |
|---|---|
| `/public_html/` | document root: sirve `index.php`, `.htaccess`, `build/assets/`, `images/`, `storage/` |
| `/ricardo_palma_core/public/` | **solo** `build/manifest.json` (+ `assets/`), que es lo que lee Vite |

Consecuencias prácticas:

- `@vite` lee el manifest de `public_path('build/manifest.json')` =
  `/ricardo_palma_core/public/build/manifest.json`, pero el navegador pide los
  assets a `/public_html/build/assets/*`. **La misma carpeta `build/` tiene que
  estar en los dos sitios**, o el manifest y los assets quedarán
  desincronizados. De eso se encarga `deploy/deploy-assets.sh` en cada push.
- Cualquier código que use `public_path()` (crear archivos, `storage:link`…)
  apunta a `/ricardo_palma_core/public`, **no** al sitio público. No lo uses para
  servir/generar archivos del docroot.
- Por eso la invalidación de caché **no** usa `public_path('index.php')` (ahí no
  existe) sino el marcador `deploy-version.txt`.

Mejora opcional (a valorar, no hecha para no arriesgar un sitio que hoy funciona):
llamar a `$app->usePublicPath('/home/USUARIO_CPANEL/public_html')` en
`bootstrap/app.php` unificaría todo (un solo `build/`, `public_path()` = docroot).

## Seguridad

Refuerzos aplicados (se despliegan solos, no requieren nada manual):

- **`public/.htaccess`** (se despliega) bloquea:
  - la ejecución de cualquier `.php` que no sea el front controller `index.php`;
  - los archivos ocultos (`.env`, `.git`, `.htaccess`…) **salvo** `/.well-known/`
    (lo necesita el certificado SSL/ACME);
  - extensiones que nunca deben descargarse (`.sql`, `.log`, `.bak`, `.ini`,
    `.yml`, `.sh`, `.lock`, `.md`, `.map`, …).
- Cabeceras de seguridad: HSTS, `X-Content-Type-Options`, `X-Frame-Options`,
  `Referrer-Policy`, `Permissions-Policy`, `Cross-Origin-Opener-Policy`,
  `Cross-Origin-Resource-Policy`, `X-Permitted-Cross-Domain-Policies` y una
  **Content-Security-Policy** con lista blanca (assets propios de Vite,
  `maps.googleapis.com` para el mapa estático y `*.fbcdn.net` para las imágenes
  del feed de Facebook de `/noticias`).
- **`public/robots.txt`** ya no anuncia rutas internas (`/admin`, `/login`…): no
  existen y solo eran una pista para atacantes.
- El repo está **genericizado**: no contiene hosts, usuarios ni rutas reales
  (esos valores viven en los Secrets de GitHub y en cPanel).

### Mitigación ReDoS — CVE-2026-108082

`symfony/http-foundation < 8.1.7` sufre backtracking catastrófico en
`HeaderUtils::split()`, alcanzable **por cualquier visitante anónimo** con una
cabecera `Cache-Control` maliciosa: PHP la parsea en cada petición al construir la
`HeaderBag` desde `$_SERVER`. Como el hosting no tiene shell (no se puede tocar
`vendor/`), `bootstrap/app.php` **descarta la cabecera `Cache-Control` de entrada**
antes de crear la `Request`. El refresco manual de caché pasó a la cabecera
`X-Cache-Refresh: 1`.

El arreglo definitivo es actualizar la dependencia y subir el `vendor/`:

```
composer update guzzlehttp/guzzle guzzlehttp/psr7 guzzlehttp/promises \
    league/commonmark league/flysystem symfony/http-foundation --with-all-dependencies
```

Luego hay que **subir por FTPS el `vendor/` resultante a `/ricardo_palma_core/`**
(el despliegue normal NO toca `vendor/`). Haz copia de seguridad previa y verifica
el sitio después. En cuanto `vendor/` esté al día, el bloque de mitigación de
`bootstrap/app.php` puede retirarse.
