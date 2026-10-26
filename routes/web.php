<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactoController as AdminContactoController;
use App\Http\Controllers\Admin\DocenteController as AdminDocenteController;
use App\Http\Controllers\Admin\GaleriaController as AdminGaleriaController;
use App\Http\Controllers\Admin\NoticiaController as AdminNoticiaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Páginas públicas de solo lectura: se cachea la respuesta HTML completa (TTL 1 h).
Route::middleware('cache.response:3600')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/nosotros', [PageController::class, 'nosotros'])->name('nosotros');
    Route::get('/docentes', [PageController::class, 'docentes'])->name('docentes');
});

// Noticias: TTL corto. La respuesta HTML lleva dentro el feed de Facebook, así
// que se regenera seguido para que las publicaciones se refresquen solas.
Route::middleware('cache.response:900')->group(function () {
    Route::get('/noticias', [PageController::class, 'noticias'])->name('noticias');
    Route::get('/noticias/{slug}', [PageController::class, 'noticiaDetalle'])->name('noticias.show');
});

// Galería: se cachean los datos (no el HTML) y se invalidan con `galeria:sync`.
Route::get('/galeria', [PageController::class, 'galeria'])->name('galeria');

// Contacto: NUNCA se cachea (contiene el token CSRF y mensajes flash).
Route::get('/contacto', [PageController::class, 'contacto'])->name('contacto');

Route::post('/contacto', [ContactController::class, 'store'])
    ->middleware('throttle:3,5')
    ->name('contacto.store');

// Ruta de respaldo: sirve archivos de storage cuando el servidor web (LiteSpeed/Apache)
// delega a index.php por no tener enlace simbólico físico o permisos en docroot
Route::get('/storage/{path}', function (string $path) {
    $cleanPath = ltrim(str_replace(['../', '..\\'], '', $path), '/');

    // 1. Buscar en Storage::disk('public')
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    if ($disk->exists($cleanPath)) {
        $fullPath = $disk->path($cleanPath);

        // Copia de respaldo defensiva al document root de cPanel si existe
        $targetDirs = [
            base_path('../public_html/storage'),
            isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/storage' : null,
            public_path('storage'),
        ];
        foreach ($targetDirs as $targetDir) {
            if ($targetDir) {
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }
                $destFile = $targetDir . '/' . basename($cleanPath);
                if (is_dir($targetDir) && is_writable($targetDir) && !file_exists($destFile)) {
                    @copy($fullPath, $destFile);
                }
            }
        }

        return response()->file($fullPath, [
            'Cache-Control' => 'public, max-age=2592000',
        ]);
    }

    // 2. Buscar en public/storage local
    $localPublicStorage = public_path('storage/' . $cleanPath);
    if (file_exists($localPublicStorage)) {
        return response()->file($localPublicStorage, [
            'Cache-Control' => 'public, max-age=2592000',
        ]);
    }

    abort(404);
})->where('path', '.*');

// ==========================================
// PANEL DE ADMINISTRACIÓN (Ruta Oculta)
// ==========================================
Route::prefix('admin')->group(function () {
    // Autenticación con limitador de tasa (brute-force protection: 5 intentos por minuto)
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Módulos protegidos por autenticación
    Route::middleware('auth')->name('admin.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.noticias.index');
        })->name('dashboard');

        // Noticias
        Route::resource('noticias', AdminNoticiaController::class)
            ->parameters(['noticias' => 'noticia'])
            ->except(['show']);

        // Galería
        Route::resource('galeria', AdminGaleriaController::class)
            ->parameters(['galeria' => 'galeria'])
            ->only(['index', 'store', 'destroy']);

        // Docentes
        Route::resource('docentes', AdminDocenteController::class)
            ->parameters(['docentes' => 'docente'])
            ->only(['index', 'store', 'update', 'destroy']);

        // Mensajes de contacto (solo lectura y cambio de estado, sin eliminación física para auditoría)
        Route::get('/mensajes', [AdminContactoController::class, 'index'])->name('mensajes.index');
        Route::get('/mensajes/{contacto}', [AdminContactoController::class, 'show'])->name('mensajes.show');
        Route::patch('/mensajes/{contacto}/toggle-leido', [AdminContactoController::class, 'toggleLeido'])->name('mensajes.toggle');
    });
});

