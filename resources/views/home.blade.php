@extends('layouts.app')

@section('title', 'I.E.I. N° 31756 Ricardo Palma')
@section('meta_description', 'Bienvenidos a la página de la Institución Educativa Integrada N° 31756 Ricardo Palma en Cerro de Pasco. Conoce nuestro compromiso con la educación.')
@section('content')
    <!-- Hero Section con contenido + Slider Automático -->
    <section role="region" aria-roledescription="carousel" aria-label="Galería institucional" aria-live="polite" class="relative flex min-h-[30rem] w-full items-center overflow-hidden bg-ricardo-teal sm:min-h-[36rem] md:min-h-[40rem] lg:min-h-[44rem]" data-hero-slider>

        <!-- Slide 1 -->
        <img
            src="{{ asset('images/fachada_colegio.jpg') }}"
            alt="Fachada de la I.E.I. Ricardo Palma"
            class="absolute inset-0 h-full w-full object-cover object-[center_32%] opacity-100 scale-105 z-10 transition-all duration-[6000ms] ease-out"
            data-hero-slide
            fetchpriority="high"
        >

        <!-- Slide 2 -->
        <img
            src="{{ asset('images/hero_2.jpg') }}"
            alt="Docentes de la Institución"
            class="absolute inset-0 h-full w-full object-cover object-center opacity-0 scale-100 z-0 transition-none"
            data-hero-slide
            loading="lazy"
        >

        <!-- Slide 3 -->
        <img
            src="{{ asset('images/plana_docente.jpg') }}"
            alt="Estudiantes Ricardinos"
            class="absolute inset-0 h-full w-full object-cover object-center opacity-0 scale-100 z-0 transition-none"
            data-hero-slide
            loading="lazy"
        >

        <!-- Filtro oscuro sobre la fotografía -->
        <div class="pointer-events-none absolute inset-0 z-20 bg-linear-to-r from-[#2b2d2b]/82 via-[#2b2d2b]/63 to-[#2b2d2b]/35"></div>

        <!-- Contenido principal -->
        <div class="relative z-30 mx-auto w-full max-w-[968px] px-6 pb-[30px] pt-[50px] lg:px-0 lg:pb-[38px] lg:pt-[60px]">

            {{-- Etiqueta superior --}}
            <span class="mb-4 inline-flex items-center gap-2.5 rounded-full border border-white/28 bg-white/12 px-3.5 py-[7px] font-system text-[10px] font-bold uppercase tracking-[2px] text-white">
                <span class="h-[7px] w-[7px] flex-shrink-0 rounded-full bg-ricardo-yellow"></span>
                I.E.I. N.° 31756 — Cerro de Pasco
            </span>

            <h1 class="mb-[18px] max-w-[680px] text-[clamp(36px,4.4vw,58px)] font-normal leading-[1.13] tracking-[0.5px] text-white [font-variant:small-caps]">
                Formando Ricardinos
                <span class="mt-[7px] block text-[0.72em] leading-[1.18] text-ricardo-yellow">
                    comprometidos con su comunidad
                </span>
            </h1>

            <p class="mb-[30px] mt-5 max-w-[560px] text-[15px] leading-[1.45] text-[#e7e5e0] sm:text-[16px]">
                Educación Inicial, Primaria y Secundaria basada en valores, innovación y Jornada Escolar
                Completa para un futuro brillante.
            </p>

            <div class="flex flex-wrap items-center gap-[13px] max-[420px]:flex-col max-[420px]:items-stretch">
                <a href="#niveles"
                   class="inline-flex min-h-[45px] items-center justify-center gap-3 border border-ricardo-teal bg-ricardo-teal px-[25px] text-[14px] text-[#061e1b] no-underline transition-colors duration-300 hover:border-ricardo-teal-dark hover:bg-ricardo-teal-dark hover:text-white max-[420px]:w-full">
                    Conoce Nuestros Niveles
                    <span class="text-[18px]" aria-hidden="true">&rarr;</span>
                </a>

                <a href="{{ route('noticias') }}"
                   class="inline-flex min-h-[45px] min-w-[163px] items-center justify-center border border-white/38 bg-white/6 px-[25px] text-[14px] text-white/85 transition-colors duration-300 hover:bg-white/18 hover:text-white max-[420px]:w-full">
                    Últimas Noticias
                </a>
            </div>

            {{-- Indicadores del carrusel --}}
            <div class="mt-[38px] flex items-center gap-[9px] lg:mt-[50px]" role="group" aria-label="Seleccionar imagen del carrusel">
                @foreach([1, 2, 3] as $numero)
                    <button type="button"
                            data-hero-indicator
                            data-active="{{ $loop->first ? 'true' : 'false' }}"
                            aria-label="Diapositiva {{ $numero }}"
                            class="h-[5px] w-[13px] cursor-pointer rounded-[5px] border-0 bg-[#e1e1cd]/55 p-0 transition-all duration-300 data-[active=true]:w-[32px] data-[active=true]:bg-ricardo-yellow"></button>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-10 sm:py-12 lg:py-14">
        <div class="mx-auto grid max-w-7xl gap-4 px-4 sm:px-6 lg:px-8 md:grid-cols-[.82fr_1.18fr]">
            <article
                class="relative flex min-h-64 items-center justify-center bg-neutral-50 px-8 py-10 text-center sm:min-h-80 lg:min-h-[28rem] opacity-0 translate-y-8 transition-all duration-700 ease-out"
                data-reveal>
                <!-- MEJORA 3: Listones geométricos con entrada retrasada y fluida -->
                <div class="absolute right-0 top-0 flex h-50 w-11 [clip-path:polygon(0_0,_100%_0,_100%_100%,_0_84%)] opacity-0 -translate-y-6 transition-all duration-700 delay-300 ease-out"
                     data-reveal>
                    <span class="h-full w-1/2 bg-ricardo-teal"></span>
                    <span class="h-full w-1/2 bg-ricardo-red"></span>
                </div>
                <h2 class="font-mate text-3xl leading-tight text-neutral-800 sm:text-4xl lg:text-5xl">
                    “Ser Ricardino,<br>
                    es ser cada día<br>
                    mejor”
                </h2>
            </article>

            <figure role="region" aria-roledescription="carousel" aria-label="Estudiante destacada" class="relative w-full min-h-64 overflow-hidden sm:min-h-80 lg:min-h-[28rem] opacity-0 translate-y-8 transition-all duration-700 ease-out"
                    data-reveal data-figure-slider>
                <img
                    src="{{ asset('images/alumna_destacada.png') }}"
                    alt="Estudiante ricardina desarrollando sus actividades escolares"
                    class="absolute inset-0 h-full w-full object-cover translate-x-0 opacity-100 z-10"
                    data-figure-slide
                >
                <img
                    src="{{ asset('images/ricardino_campeon.jpg') }}"
                    alt="Estudiantes campeones"
                    class="absolute inset-0 h-full w-full object-cover translate-x-full opacity-0 z-0"
                    data-figure-slide
                    loading="lazy"
                ><img
                    src="{{ asset('images/ricardino_libros.jpg') }}"
                    alt="Estudiantes viendo libros"
                    class="absolute inset-0 h-full w-full object-cover translate-x-full opacity-0 z-0"
                    data-figure-slide
                    loading="lazy"
                >
            </figure>
        </div>
    </section>

    <!-- Sección Nosotros -->
    <section id="nosotros" class="bg-white pb-10 sm:pb-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title>Bienvenidos a la I.E.I N.° 31756 Ricardo Palma</x-section-title>

            <div class="mt-5 grid gap-7 lg:grid-cols-[.42fr_.58fr] lg:items-start">
                <figure role="region" aria-roledescription="carousel" aria-label="Docente en clase" class="relative overflow-hidden aspect-[1080/757] w-full opacity-0 translate-y-8 transition-all duration-700 ease-out"
                        data-reveal data-figure-slider>
                    <img
                        src="{{ asset('images/ricardino_escolta.jpg ') }}"
                        alt="Docente acompañando a estudiantes en clase"
                        class="absolute inset-0 h-full w-full object-cover translate-x-0 opacity-100 z-10"
                        data-figure-slide
                    >
                    <img
                        src="{{ asset('images/ricardinos_premiacion.jpg') }}"
                        alt="Estudiantes premiados"
                        class="absolute inset-0 h-full w-full object-cover translate-x-full opacity-0 z-0"
                        data-figure-slide
                        loading="lazy"
                    ><img
                        src="{{ asset('images/ricardinos_formados.jpg') }}"
                        alt="Estudiantes en formacion"
                        class="absolute inset-0 h-full w-full object-cover translate-x-full opacity-0 z-0"
                        data-figure-slide
                        loading="lazy"
                    >
                </figure>

                <article class="space-y-5 text-[15px] leading-relaxed text-neutral-700 sm:text-[17px] lg:pt-1 opacity-0 translate-y-8 transition-all duration-700 ease-out" data-reveal>
                    <p>
                        La <strong class="font-semibold text-ricardo-teal">Institución Educativa Integrada N.° 31756
                            “Ricardo Palma”</strong>,
                        ubicada en Cerro de Pasco, se ha consolidado como una institución comprometida con la formación
                        integral de sus estudiantes
                        en los niveles de Inicial, Primaria y Secundaria.
                    </p>
                    <p>
                        A lo largo de su trayectoria, ha impulsado proyectos de innovación educativa, fortaleciendo el
                        aprendizaje mediante la
                        Jornada Escolar Completa (JEC) y promoviendo una educación basada en valores, el respeto y la
                        mejora continua.
                    </p>
                    <p>
                        Hoy, la institución continúa formando estudiantes competentes, autónomos y comprometidos con su
                        comunidad, integrando
                        nuevas estrategias pedagógicas y el uso de las tecnologías.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <!-- Sección Niveles (Efecto Cascada / Stagger Activado) -->
    <section id="niveles" class="scroll-mt-28 bg-white py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title>Nuestros Niveles</x-section-title>

            <div class="mt-12 grid gap-10 sm:grid-cols-3 sm:gap-6 lg:mt-16 lg:gap-16" data-reveal data-stagger>
                <x-level-badge image="images/nivel_inicial.png" label="Nivel Inicial" class="opacity-0 translate-y-8 transition-all duration-700 ease-out" />
                <x-level-badge image="images/nivel_primaria.png" label="Nivel Primaria" class="opacity-0 translate-y-8 transition-all duration-700 ease-out" />
                <x-level-badge image="images/nivel_secundaria.png" label="Nivel Secundaria" class="opacity-0 translate-y-8 transition-all duration-700 ease-out" />
            </div>
        </div>
    </section>

    <!-- Sección Galería (Optimizada con efecto Cascada y Micro-zooms) -->
    <section id="galeria" class="bg-white py-10 sm:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title>Galería</x-section-title>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:gap-6" data-reveal data-stagger>
                <!-- MEJORA 1: Zoom suave al pasar el cursor en tarjetas 1, 2 y 3 -->
                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-700 ease-out">
                    <img src="{{ asset('images/galeria_1.jpg') }}"
                         alt="Reconocimiento académico de estudiante ricardino"
                         class="aspect-[3/2] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>

                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-700 ease-out">
                    <img src="{{ asset('images/galeria_2.jpg') }}"
                         alt="Equipo femenino campeón de futsal"
                         class="aspect-[3/2] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>

                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-700 ease-out">
                    <img src="{{ asset('images/galeria_3.jpg') }}"
                         alt="Equipo masculino campeón de futsal"
                         class="aspect-[3/2] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>

                <article class="group relative overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-700 ease-out">
                    <img
                        src="{{ asset('images/galeria_4.jpg') }}"
                        alt="Más actividades institucionales"
                        class="aspect-[3/2] w-full scale-100 object-cover blur-xs transition duration-500 group-hover:scale-105 group-hover:blur-none"
                        loading="lazy"
                    >
                    <div class="absolute inset-0 flex items-center justify-center bg-black/40 transition duration-300 group-hover:bg-black/20">
                        <a href="{{route('galeria')}}"
                           class="border border-white px-8 py-3 font-mate text-xl uppercase tracking-wide text-white transition-colors hover:bg-white hover:text-neutral-900 sm:text-2xl">
                            Ver Más
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <!-- Sección Nuestro Objetivo y Contadores Animados -->
    <section id="objetivo" class="bg-white pb-16 sm:pb-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title>Nuestro Objetivo</x-section-title>

            <div class="mt-10 flex flex-col gap-12">

                <article class="mx-auto max-w-4xl text-center text-[19px] leading-relaxed text-neutral-800 sm:text-xl lg:text-2xl opacity-0 translate-y-8 transition-all duration-700 ease-out" data-reveal>
                    <p>
                        Formar estudiantes íntegros, críticos, creativos e innovadores mediante una educación de
                        calidad, inclusiva y basada en valores; consolidando una institución líder con gestión participativa,
                        docentes actualizados, familias comprometidas e infraestructura moderna y sostenible.
                    </p>
                </article>

                <div class="grid grid-cols-1 gap-8 sm:grid-cols-3 sm:gap-x-6 lg:gap-x-10">

                    <x-stat-item count="10" label="Docentes Totales" class="group">
                        <x-slot:icon>
                            <svg width="50" height="60" viewBox="0 0 50 60" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"
                                 class="h-full w-full object-contain transition-all duration-300 group-hover:-translate-y-1 group-hover:scale-110">
                                <path
                                    d="M35.4167 52.5V47.5C35.4167 44.8478 34.5387 42.3043 32.9759 40.4289C31.4131 38.5536 29.2935 37.5 27.0833 37.5H10.4167C8.20653 37.5 6.08692 38.5536 4.52411 40.4289C2.96131 42.3043 2.08334 44.8478 2.08334 47.5V52.5M47.9167 52.5V47.5C47.9153 45.2843 47.3007 43.1319 46.1695 41.3808C45.0383 39.6296 43.4544 38.3789 41.6667 37.825M33.3333 7.825C35.1259 8.37575 36.7147 9.62675 37.8492 11.3808C38.9838 13.1348 39.5997 15.2921 39.5997 17.5125C39.5997 19.7329 38.9838 21.8902 37.8492 23.6442C36.7147 25.3982 35.1259 26.6492 33.3333 27.2M27.0833 17.5C27.0833 23.0228 23.3524 27.5 18.75 27.5C14.1476 27.5 10.4167 23.0228 10.4167 17.5C10.4167 11.9772 14.1476 7.5 18.75 7.5C23.3524 7.5 27.0833 11.9772 27.0833 17.5Z"
                                    stroke="#129582" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </x-slot:icon>
                    </x-stat-item>

                    <x-stat-item count="200" label="Padres Satisfechos" class="group">
                        <x-slot:icon>
                            <div class="flex h-full w-full items-center justify-center">
                                <img
                                    src="{{ asset('images/padre.png') }}"
                                    alt="Icono Padres"
                                    class="h-[3.25rem] w-auto max-w-none object-contain sm:h-[3.5rem] transition-all duration-300 group-hover:-translate-y-1 group-hover:scale-110"
                                >
                            </div>
                        </x-slot:icon>
                    </x-stat-item>

                    <x-stat-item count="150" label="Estudiantes Totales" class="group">
                        <x-slot:icon>
                            <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                 xmlns="http://www.w3.org/2000/svg"
                                 class="h-full w-full object-contain transition-all duration-300 group-hover:-translate-y-1 group-hover:scale-110">
                                <path
                                    d="M59.993 59.9988C59.9953 59.9988 59.9977 60 60 60C58.1265 51.6423 50.9887 45.2551 42.2134 44.4595C42.134 48.1025 36.6957 51.0426 29.9994 51.0426C23.302 51.0426 17.8649 48.1025 17.7854 44.4595C9.01244 45.2563 1.87234 51.6434 0 60C0.00350406 60 0.00700903 59.9988 0.0105131 59.9988H59.993Z"
                                    fill="#129582"/>
                                <path
                                    d="M18.4531 23.4699L14.7388 21.874C14.6547 22.5572 14.6021 23.2519 14.6021 23.9582C14.6021 24.2957 14.615 24.6298 14.6337 24.9615C14.6629 25.4463 14.7084 25.9265 14.7785 26.3997C14.789 26.5446 14.8019 26.6873 14.8159 26.83C15.7865 37.7393 22.2141 46.1689 30.0001 46.1689C37.7862 46.1689 44.2138 37.7393 45.1844 26.83C45.1984 26.6861 45.2089 26.5435 45.2206 26.3997C45.2907 25.9265 45.3362 25.4463 45.3643 24.9615C45.3841 24.6286 45.3958 24.2957 45.3958 23.9582C45.3958 23.2519 45.3433 22.5572 45.2592 21.874L41.5437 23.4711C41.5472 25.807 41.1851 27.948 41.1851 27.9492C41.9887 27.3936 42.7222 27.1037 43.3214 26.9552C42.4372 36.4843 36.8109 43.833 29.9978 43.833C23.1848 43.833 17.5596 36.4843 16.6754 26.9541C17.2746 27.1025 18.0104 27.3913 18.8117 27.948C18.8117 27.948 18.4496 25.807 18.4531 23.4699Z"
                                    fill="#129582"/>
                                <path
                                    d="M8.68291 10.5822L10.1207 11.2004L9.99927 12.1596C9.44914 12.2524 9.02865 12.7279 9.02865 13.302C9.02865 13.8181 9.36737 14.2566 9.83809 14.405L8.96441 26.5507C8.9282 27.0575 9.03098 27.8671 9.19217 28.3484L9.89999 30.4605C9.98059 30.7017 10.0869 30.8223 10.1932 30.8223C10.2995 30.8223 10.4057 30.7017 10.4875 30.4605L11.1965 28.3484C11.3577 27.8671 11.4605 27.0575 11.4243 26.5507L10.5529 14.405C11.0201 14.2554 11.3624 13.8193 11.3624 13.302C11.3624 12.7279 10.9419 12.2524 10.3894 12.1596L10.2773 11.2677L13.5991 12.6943L15.225 13.3937V19.6277L20.5991 21.9358L27.6656 24.9745C28.3092 25.2505 29.156 25.3886 30.0016 25.3886C30.8484 25.3886 31.6952 25.2505 32.3377 24.9745L39.4042 21.9358L44.7794 19.6266V13.3925L46.4053 12.6931L51.3191 10.5799C52.6063 10.0278 52.6063 9.12434 51.3191 8.57226L32.3388 0.412898C31.6941 0.138019 30.8484 0 30.0016 0C29.1548 0 28.308 0.138019 27.6656 0.415217L8.68408 8.57458C7.39692 9.12666 7.39692 10.0302 8.68291 10.5822Z"
                                    fill="#129582"/>
                            </svg>
                        </x-slot:icon>
                    </x-stat-item>

                </div>
            </div>
        </div>
    </section>
@endsection
