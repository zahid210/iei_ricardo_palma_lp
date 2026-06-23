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

        <!-- Logo Institucional Reducido (h-12 en móvil, h-14 en escritorio) -->
        <a href="{{ route('home') }}" class="shrink-0" aria-label="Ir al inicio">
            <img src="{{ asset('images/logo_color.png') }}" alt="I.E.I. Ricardo Palma"
                 class="h-12 w-auto transition-all sm:h-14">
        </a>

        <!-- Enlaces de navegación con distribución compacta -->
        <div
            class="flex flex-wrap justify-center gap-x-5 gap-y-1 text-center font-mate text-xs uppercase tracking-wider text-neutral-700 sm:gap-x-6 md:gap-x-8 sm:text-sm lg:text-base">
            <a href="{{ route('home') }}"
               class="border-b-2 border-ricardo-red pb-0.5 transition-colors hover:text-ricardo-teal">Inicio</a>
            <a href="{{ url('/#nosotros') }}"
               class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">Nosotros</a>
            <a href="{{ url('/#niveles') }}"
               class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">Docentes</a>
            <a href="{{ url('/#galeria') }}"
               class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">Noticias</a>
            <a href="{{ url('/#contacto') }}"
               class="border-b-2 border-transparent pb-0.5 transition-colors hover:border-ricardo-red hover:text-ricardo-teal">Contacto</a>
        </div>
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer id="contacto" class="bg-ricardo-teal text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-8 sm:px-8 md:grid-cols-3 md:py-10">
        <section class="text-center md:text-left" aria-labelledby="footer-contacto">
            <h2 id="footer-contacto" class="font-system text-sm font-bold uppercase text-ricardo-yellow">
                Contáctanos</h2>
            <img src="{{ asset('images/logo_original_blanco.png') }}" alt="I.E.I. Ricardo Palma"
                 class="mx-auto mt-5 h-24 w-auto md:mx-0">
            <div class="mt-5 flex justify-center gap-3 md:justify-start" aria-label="Redes sociales">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full border border-white text-white"
                          aria-hidden="true">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path
                                d="M14 8h3V4h-3c-3.3 0-5 2-5 5v2H6v4h3v5h4v-5h3l1-4h-4V9c0-.7.3-1 1-1Z"/></svg>
                    </span>
                <span class="flex h-8 w-8 items-center justify-center rounded-full border border-white text-white"
                      aria-hidden="true">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path
                                d="M12 3a9 9 0 0 0-7.7 13.7L3 21l4.4-1.2A9 9 0 1 0 12 3Zm0 2a7 7 0 0 1 5.9 10.8l-.3.5.7 2.3-2.4-.7-.5.3A7 7 0 0 1 5 12a7 7 0 0 1 7-7Zm-2.2 3.4c-.2 0-.5.1-.7.4-.2.3-.9.9-.9 2.2s.9 2.5 1 2.7c.1.2 1.8 2.9 4.4 3.9 2.2.9 2.6.7 3.1.7.5-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.1-1.2l-1.7-.8c-.3-.1-.5-.2-.7.2l-.6.7c-.2.2-.4.3-.7.1a5.7 5.7 0 0 1-2.9-2.5c-.2-.3 0-.5.1-.6l.5-.6c.1-.2.2-.4.1-.6l-.8-1.9c-.2-.5-.4-.5-.7-.5h-.5Z"/></svg>
                    </span>
                <span class="flex h-8 w-8 items-center justify-center rounded-full border border-white text-white"
                      aria-hidden="true">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path
                                d="M21 8.4s-.2-1.5-.8-2.1c-.8-.8-1.6-.8-2-.9C15.4 5.2 12 5.2 12 5.2s-3.4 0-6.2.2c-.4.1-1.3.1-2 .9C3.2 7 3 8.4 3 8.4S2.8 10.1 2.8 12v1.7c0 1.8.2 3.5.2 3.5s.2 1.5.8 2.1c.8.8 1.8.8 2.3.9 1.7.2 5.9.2 5.9.2s3.4 0 6.2-.2c.4-.1 1.3-.1 2-.9.6-.6.8-2.1.8-2.1s.2-1.7.2-3.5V12c0-1.9-.2-3.6-.2-3.6ZM10.5 15.6V8.9l5.8 3.4-5.8 3.3Z"/></svg>
                    </span>
            </div>
        </section>

        <section class="mx-auto w-65 text-center md:mx-0 md:text-left" aria-labelledby="footer-ubicacion">
            <h2 id="footer-ubicacion" class="font-system text-sm font-bold uppercase text-ricardo-yellow">Ubicación</h2>
            <p class="mt-3 font-system text-xs text-white/90 leading-relaxed">Barrio La Esperanza, Chaupimarca -
                Pasco</p>

            <!-- El p-2 del contenedor sumará el espaciado interno correcto alrededor del mapa de w-65 -->
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
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-black/5 opacity-0 transition-opacity duration-200 group-hover:opacity-100">
                    <span class="rounded bg-neutral-900/80 px-2 py-1 text-[10px] font-medium text-white shadow-sm">
                        Ver en Google Maps
                    </span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="text-center md:text-left" aria-labelledby="footer-enlaces">
            <h2 id="footer-enlaces" class="font-system text-sm font-bold uppercase text-ricardo-yellow">Enlaces</h2>
            <ul class="mt-4 space-y-2 font-system text-sm text-white/90">
                <li><a href="{{ route('home') }}" class="transition-colors hover:text-ricardo-yellow">Inicio</a></li>
                <li><a href="{{ url('/#nosotros') }}" class="transition-colors hover:text-ricardo-yellow">Nosotros</a>
                </li>
                <li><a href="{{ url('/#niveles') }}" class="transition-colors hover:text-ricardo-yellow">Niveles</a>
                </li>
                <li><a href="{{ url('/#galeria') }}" class="transition-colors hover:text-ricardo-yellow">Galería</a>
                </li>
                <li><a href="{{ url('/#objetivo') }}" class="transition-colors hover:text-ricardo-yellow">Objetivo</a>
                </li>
            </ul>
        </section>
    </div>

    <div class="bg-ricardo-teal-dark py-4 text-center font-system text-xs text-white/80">
        <p>&copy; {{ now()->year }} I.E.I. 31756 Ricardo Palma. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>
