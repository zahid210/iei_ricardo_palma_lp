<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Landing page institucional de la I.E.I. N.° 31756 Ricardo Palma.">
    <title>@yield('title', config('app.name', 'I.E.I. 31756 Ricardo Palma'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-literata text-neutral-800 antialiased">
<!-- Header Institucional Compacto -->
<header class="sticky top-0 z-50 w-full bg-white shadow-sm">
    <!-- Barra superior estilizada con menos padding vertical -->
    <div class="bg-ricardo-teal py-1.5 text-center font-system text-[10px] leading-none text-white sm:text-xs">
        I.E.I N.° 31756 Ricardo Palma
    </div>

    <!-- Navegación optimizada: py-2 en lugar de py-4 y alineación horizontal desde sm -->
    <nav
        class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-5 py-2  sm:flex-row sm:gap-0 sm:px-8 md:py-2.5"
        aria-label="Navegación principal">

        <a href="{{ route('home') }}" class="shrink-0" aria-label="Ir al inicio">
            <img src="{{ asset('images/logo_color.png') }}" alt="I.E.I. Ricardo Palma"
                 class="h-12 w-auto transition-all sm:h-14">
        </a>

        <div
            class="flex flex-wrap justify-center gap-x-5 gap-y-1 text-center font-mate text-xs uppercase tracking-wider text-neutral-700 sm:gap-x-6 md:gap-x-8 sm:text-sm lg:text-base">

            <a href="{{ route('home') }}"
               class="border-b-2 {{ Route::is('home') ? 'border-ricardo-red' : 'border-transparent' }} pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">
                Inicio
            </a>

            <a href="{{ route('nosotros') }}"
               class="border-b-2 {{ Route::is('nosotros') ? 'border-ricardo-red' : 'border-transparent' }} pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">
                Nosotros
            </a>

            <a href="{{ route('home') }}#niveles"
               class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">
                Docentes
            </a>

            <a href="{{ route('home') }}#galeria"
               class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">
                Noticias
            </a>

            <a href="{{ route('home') }}#contacto"
               class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">
                Contacto
            </a>
        </div>
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer id="contacto" class="bg-ricardo-teal text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-10 sm:px-8 md:grid-cols-3 md:py-12">

        <section class="w-full md:max-w-[260px] mx-auto text-center md:text-left" aria-labelledby="footer-contacto">
            <h2 id="footer-contacto" class="font-system text-sm font-bold uppercase tracking-wider text-ricardo-yellow">
                Contáctanos
            </h2>
            <img src="{{ asset('images/logo_original_blanco.png') }}" alt="I.E.I. Ricardo Palma"
                 class="mx-auto mt-6 h-28 w-auto object-contain sm:h-32 md:mx-0">

            <div class="mt-6 flex justify-center gap-4 md:justify-start" aria-label="Redes sociales">
                <a href="https://www.facebook.com/ricardinosemprendeores" target="_blank" rel="noopener noreferrer"
                   class="group flex h-9 w-9 items-center justify-center rounded-full border border-white/40 transition-all duration-200 hover:scale-110 hover:border-white hover:bg-white/10"
                   title="Síguenos en Facebook">
                    <img src="{{ asset('images/facebook.svg') }}" alt="Facebook"
                         class="h-4 w-4 transition-transform duration-200 brightness-0 invert">
                </a>

                <a href="https://wa.me/51921896330" target="_blank" rel="noopener noreferrer"
                   class="group flex h-9 w-9 items-center justify-center rounded-full border border-white/40 transition-all duration-200 hover:scale-110 hover:border-white hover:bg-white/10"
                   title="Contáctanos por WhatsApp">
                    <img src="{{ asset('images/whatsapp.svg') }}" alt="WhatsApp"
                         class="h-4 w-4 transition-transform duration-200 brightness-0 invert">
                </a>

                <a href="https://www.youtube.com/@ricardopalma4155" target="_blank" rel="noopener noreferrer"
                   class="group flex h-9 w-9 items-center justify-center rounded-full border border-white/40 transition-all duration-200 hover:scale-110 hover:border-white hover:bg-white/10"
                   title="Visita nuestro canal de YouTube">
                    <img src="{{ asset('images/youtube.svg') }}" alt="YouTube"
                         class="h-4 w-4 transition-transform duration-200 brightness-0 invert">
                </a>
            </div>
        </section>

        <section class="w-65 mx-auto text-center md:text-left" aria-labelledby="footer-ubicacion">
            <h2 id="footer-ubicacion" class="font-system text-sm font-bold uppercase tracking-wider text-ricardo-yellow">Ubicación</h2>
            <p class="mt-3 font-system text-xs text-white/90 leading-relaxed">Barrio La Esperanza, Chaupimarca - Pasco</p>

            <div class="mt-4 inline-block overflow-hidden rounded-sm bg-white p-1 shadow-sm text-left">
                <div class="relative h-32 w-65 overflow-hidden bg-[#e7ecef]">
                    <a href="https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9" target="_blank" rel="noopener noreferrer"
                       class="block h-full w-full group">
                        <img
                            src="https://maps.googleapis.com/maps/api/staticmap?center=-10.6852,-76.2592&zoom=16&size=260x128&scale=2&maptype=roadmap&markers=color:red%7C-10.6852,-76.2592&key=AIzaSyCUxQyRkTBGfV1WYm95ZmM-tzQ0nCAO2Es"
                            alt="Mapa de ubicación exacta de la I.E.I. Ricardo Palma"
                            class="h-full w-full object-cover transition-opacity duration-200 group-hover:opacity-90"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 flex items-center justify-center bg-black/5 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                            <span class="rounded bg-neutral-900/80 px-2 py-1 text-[10px] font-medium text-white shadow-sm">
                                Ver en Google Maps
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="w-fit md:min-w-[140px] mx-auto text-center md:text-left" aria-labelledby="footer-enlaces">
            <h2 id="footer-enlaces" class="font-system text-sm font-bold uppercase tracking-wider text-ricardo-yellow">Enlaces</h2>
            <ul class="mt-4 space-y-2.5 font-system text-sm text-white/90">
                <li><a href="{{ route('home') }}" class="transition-colors duration-200 hover:text-ricardo-yellow">Inicio</a></li>
                <li><a href="{{ route('nosotros') }}" class="transition-colors duration-200 hover:text-ricardo-yellow">Nosotros</a></li>
                <li><a href="{{ route('home') }}#niveles" class="transition-colors duration-200 hover:text-ricardo-yellow">Niveles</a></li>
                <li><a href="{{ route('home') }}#galeria" class="transition-colors duration-200 hover:text-ricardo-yellow">Galería</a></li>
                <li><a href="{{ route('home') }}#contacto" class="transition-colors duration-200 hover:text-ricardo-yellow">Objetivo</a></li>
            </ul>
        </section>
    </div>

    <div class="bg-ricardo-teal-dark py-4 text-center font-system text-xs text-white/70 border-t border-white/5">
        <p>© {{ now()->year }} I.E.I. 31756 Ricardo Palma. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>
