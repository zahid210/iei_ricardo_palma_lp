<?php

// ---------------------------------------------------------------------------
//  ATENCION: este index.php es el de DESARROLLO LOCAL (php artisan serve).
//
//  La version que se publica en el servidor NO es esta: la app vive en
//  /ricardo_palma_core y el document root en /public_html, asi que en
//  produccion se usa una copia con rutas distintas que esta en:
//
//        deploy/public_html/index.php
//
//  Si necesitas cambiar el arranque en PRODUCCION, edita ese archivo
//  (este esta excluido del despliegue). El .htaccess, en cambio, SI se
//  despliega desde public/.htaccess.
// ---------------------------------------------------------------------------

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
