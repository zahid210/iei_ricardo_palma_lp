<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="@yield('meta_description', 'Portal oficial de la I.E.I. N.° 31756 Ricardo Palma en Chaupimarca, Pasco. Conoce nuestra historia, plana docente, noticias y actividades.')">

    <title>@yield('title', 'I.E.I. N° 31756 Ricardo Palma - Cerro de Pasco')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/branding/logo_color.png') }}?v=1">

    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'I.E.I. N° 31756 Ricardo Palma')">
    <meta property="og:description" content="@yield('meta_description', 'Portal oficial de la I.E.I. N.° 31756 Ricardo Palma en Chaupimarca, Pasco.')">
    <meta property="og:image" content="{{ asset('images/branding/logo_color.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="I.E.I. 31756 Ricardo Palma">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-literata text-neutral-800 antialiased selection:bg-ricardo-teal selection:text-white">

{{-- Header Institucional --}}
<header class="sticky top-0 z-50 w-full bg-white shadow-sm border-b border-neutral-100">
    <div class="bg-ricardo-teal py-1.5 text-center font-system text-[10px] leading-none text-white sm:text-xs tracking-wide">
        I.E.I N.° 31756 Ricardo Palma
    </div>

    <nav class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-5 py-2 sm:flex-row sm:gap-0 sm:px-8 md:py-2.5" aria-label="Navegación principal">
        <a href="{{ route('home') }}" class="shrink-0 transition-transform hover:scale-105 duration-200" aria-label="Ir al inicio">
            <img src="{{ asset('images/branding/logo_color.png') }}" alt="I.E.I. Ricardo Palma" class="h-12 w-auto sm:h-14">
        </a>

        <div class="flex flex-wrap justify-center gap-x-5 gap-y-1 text-center font-mate text-xs uppercase tracking-wider text-neutral-700 sm:gap-x-6 md:gap-x-8 sm:text-sm lg:text-base">
            @foreach(['home' => 'Inicio', 'nosotros' => 'Nosotros', 'docentes' => 'Docentes', 'noticias' => 'Noticias', 'contacto' => 'Contacto'] as $route => $label)
                <a href="{{ route($route) }}"
                   class="border-b-2 {{ Route::is($route) ? 'border-ricardo-red text-ricardo-teal' : 'border-transparent' }} pb-0.5 transition-all duration-300 hover:border-ricardo-red hover:text-ricardo-teal">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </nav>
</header>

{{-- Contenido principal con animación de entrada --}}
<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer id="contacto" class="bg-ricardo-teal text-white mt-10">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-10 sm:px-8 md:grid-cols-3 md:py-12 translate-y-4 opacity-0 transition-all duration-700" data-reveal>

        {{-- Columna 1: Contacto --}}
        <section class="w-full md:max-w-[260px] mx-auto text-center md:text-left" aria-labelledby="footer-contacto">
            <h2 id="footer-contacto" class="font-system text-sm font-bold uppercase tracking-wider text-ricardo-yellow">Contáctanos</h2>
            <img src="{{ asset('images/branding/logo_original_blanco.png') }}" alt="I.E.I. Ricardo Palma" class="mx-auto mt-6 h-28 w-auto object-contain sm:h-32 md:mx-0">

            <div class="mt-6 flex justify-center gap-4 md:justify-start" aria-label="Redes sociales">
                @foreach(['facebook' => 'https://www.facebook.com/ricardinosemprendeores', 'whatsapp' => 'https://wa.me/51921896330', 'youtube' => 'https://www.youtube.com/@ricardopalma4155'] as $social => $link)
                    <a href="{{ $link }}" target="_blank" rel="noopener noreferrer"
                       class="group flex h-9 w-9 items-center justify-center rounded-full border border-white/40 transition-all duration-300 hover:scale-110 hover:border-white hover:bg-white/10"
                       title="Síguenos en {{ ucfirst($social) }}">
                        <img src="{{ asset('images/iconos/'.$social.'.svg') }}" alt="{{ ucfirst($social) }}" class="h-4 w-4 brightness-0 invert" onerror="this.src='{{ asset('images/'.$social.'.svg') }}';">
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Columna 2: Ubicación --}}
        <section class="w-65 mx-auto text-center md:text-left" aria-labelledby="footer-ubicacion">
            <h2 id="footer-ubicacion" class="font-system text-sm font-bold uppercase tracking-wider text-ricardo-yellow">Ubicación</h2>
            <p class="mt-3 font-system text-xs text-white/90 leading-relaxed">Barrio La Esperanza, Chaupimarca - Pasco</p>

            <div class="mt-4 inline-block overflow-hidden rounded-sm bg-white p-1 shadow-sm text-left">
                <div class="relative h-32 w-65 overflow-hidden bg-[#e7ecef]">
                    <a href="https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9" target="_blank" rel="noopener noreferrer" class="block h-full w-full group">
                        <img src="https://maps.googleapis.com/maps/api/staticmap?center=-10.6852,-76.2592&zoom=16&size=260x128&scale=2&maptype=roadmap&markers=color:red%7C-10.6852,-76.2592&key={{ config('services.google.maps_key', '') }}"
                             alt="Ubicación" class="h-full w-full object-cover transition-opacity duration-200 group-hover:opacity-90" loading="lazy">
                    </a>
                </div>
            </div>
        </section>

        {{-- Columna 3: Enlaces --}}
        <section class="w-fit md:min-w-[140px] mx-auto text-center md:text-left" aria-labelledby="footer-enlaces">
            <h2 id="footer-enlaces" class="font-system text-sm font-bold uppercase tracking-wider text-ricardo-yellow">Enlaces</h2>
            <ul class="mt-4 space-y-2.5 font-system text-sm text-white/90">
                @foreach(['home' => 'Inicio', 'nosotros' => 'Nosotros', 'docentes' => 'Docentes', 'galeria' => 'Galeria','noticias' => 'Noticias', 'contacto' => 'Contacto'] as $route => $label)
                    <li><a href="{{ route($route) }}" class="transition-colors duration-200 hover:text-ricardo-yellow">{{ $label }}</a></li>
                @endforeach
            </ul>
        </section>
    </div>

    <div class="bg-ricardo-teal-dark py-4 text-center font-system text-xs text-white/70 border-t border-white/5">
        <p>© {{ now()->year }} I.E.I. 31756 Ricardo Palma. Todos los derechos reservados.</p>
    </div>
</footer>

@stack('scripts')
</body>
</html>
