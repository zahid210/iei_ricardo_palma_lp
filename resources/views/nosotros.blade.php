@extends('layouts.app')

@section('title', 'Nosotros | I.E.I. 31756 Ricardo Palma')

@section('content')
    <!-- Hero / Encabezado de Nosotros -->
    <section class="bg-white pt-6 pb-10 sm:pt-10 sm:pb-12">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <article
                class="relative flex flex-col items-center justify-center bg-neutral-50 px-8 py-14 text-center sm:min-h-64 lg:min-h-[20rem]">
                <!-- Detalle decorativo superior derecho (heredado del inicio) -->
                <div
                    class="absolute right-0 top-0 flex h-32 w-8 [clip-path:polygon(0_0,_100%_0,_100%_100%,_0_84%)] sm:h-40 sm:w-10">
                    <span class="h-full w-1/2 bg-ricardo-teal"></span>
                    <span class="h-full w-1/2 bg-ricardo-red"></span>
                </div>

                <h1 class="font-mate text-3xl leading-tight text-neutral-800 sm:text-4xl lg:text-5xl">
                    Innovación y Excelencia Educativa
                </h1>
                <p class="mx-auto mt-5 max-w-3xl text-sm leading-relaxed text-neutral-700 sm:text-base">
                    En la institución, nos enorgullece ofrecer una educación que combina lo mejor de la innovación
                    tecnológica con un enfoque en la excelencia académica. Nuestro objetivo es preparar a los
                    estudiantes no solo para superar los desafíos académicos, sino también para convertirse en líderes y
                    ciudadanos responsables en un mundo en constante cambio.
                </p>
            </article>
        </div>
    </section>

    <!-- ¿Quiénes Somos? -->
    <section class="bg-white pb-12 sm:pb-16">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>¿Quiénes Somos?</x-section-title>

            <div class="mt-8 grid gap-8 lg:grid-cols-[.5fr_.5fr] lg:items-center">
                <article class="space-y-4 text-sm leading-relaxed text-neutral-700 sm:text-base">
                    <p>
                        Somos una institución comprometida en proporcionar una educación de calidad que se alinea con
                        las demandas del mundo actual. Nuestro enfoque se centra en el desarrollo integral de los
                        alumnos, fomentando tanto sus habilidades académicas como sus capacidades sociales y
                        emocionales.
                    </p>
                    <p>
                        A lo largo del tiempo, nuestra institución ha fortalecido su labor pedagógica mediante la
                        participación activa de docentes, directivos, estudiantes y padres de familia, contribuyendo al
                        desarrollo educativo de la comunidad y reafirmando su compromiso con una formación integral,
                        inclusiva y orientada a la mejora continua.
                    </p>
                </article>
                <figure class="overflow-hidden rounded-sm shadow-sm">
                    <!-- SUGERENCIA: Usa una foto representativa del colegio, estudiantes o fachada aquí -->
                    <img
                        src="{{ asset('images/quienes_somos.jpg') }}"
                        alt="Comunidad Educativa Ricardo Palma"
                        class="aspect-[4/3] w-full object-cover"
                        loading="lazy"
                    >
                </figure>
            </div>
        </div>
    </section>

    <section class="bg-neutral-50 py-12 sm:py-16">
        <div class="mx-auto grid max-w-7xl gap-8 px-6 sm:px-8 md:grid-cols-2">

            <article
                class="relative border-t-4 border-ricardo-teal bg-white p-8 shadow-sm flex flex-col justify-between overflow-hidden">
                <div class="absolute right-0 top-0 flex h-24 w-6 [clip-path:polygon(0_0,_100%_0,_100%_100%,_0_84%)]">
                    <span class="h-full w-1/2 bg-ricardo-teal"></span>
                    <span class="h-full w-1/2 bg-ricardo-red"></span>
                </div>

                <div>
                    <h2 class="font-mate text-2xl text-ricardo-teal-dark sm:text-3xl">Misión</h2>
                    <div class="mt-4 pr-4 space-y-4 text-sm leading-relaxed text-neutral-700">
                        <p>
                            Brindar una educación integral, inclusiva y de calidad a los estudiantes de la Institución
                            Educativa Integrada N.° 31756 “Ricardo Palma”, promoviendo el desarrollo de competencias,
                            valores, pensamiento crítico, creatividad e innovación, en un ambiente de respeto,
                            responsabilidad y convivencia democrática.
                        </p>
                        <p>
                            Asumimos la responsabilidad de dar una formación integral a cada uno de nuestros alumnos en
                            las distintas etapas de su desarrollo, desde el respeto a sus creencias, poniendo el máximo
                            empeño en el cultivo de valores humanos y en la creación de hábitos de estudio, trabajo y
                            convivencia para una excelente formación académica y personal, acorde a las demandas de
                            nuestra sociedad actual.
                        </p>
                    </div>
                </div>

                <div class="mt-8 text-right">
                    <span class="block font-system text-[10px] font-bold uppercase tracking-widest text-neutral-400">Enfoque Pedagógico</span>
                    <p class="mt-1 font-mate text-base text-ricardo-teal-dark font-medium">
                        Formación integral, inclusiva y de calidad
                    </p>
                </div>
            </article>

            <article
                class="relative border-t-4 border-ricardo-red bg-white p-8 shadow-sm flex flex-col justify-between overflow-hidden">
                <div class="absolute right-0 top-0 flex h-24 w-6 [clip-path:polygon(0_0,_100%_0,_100%_100%,_0_84%)]">
                    <span class="h-full w-1/2 bg-ricardo-teal"></span>
                    <span class="h-full w-1/2 bg-ricardo-red"></span>
                </div>

                <div>
                    <h2 class="font-mate text-2xl text-ricardo-red sm:text-3xl">Visión</h2>
                    <div class="mt-4 pr-4 text-sm leading-relaxed text-neutral-700">
                        <p>
                            Ser la primera elección de las familias que garantice la formación académica, la madurez
                            emocional y la educación en valores necesarias para el futuro de sus hijos en un mundo
                            tecnológico y global.
                        </p>
                    </div>
                </div>

                <div class="mt-8 text-right">
                    <span class="block font-system text-[10px] font-bold uppercase tracking-widest text-neutral-400">Valores Fundamentales</span>
                    <p class="mt-1 font-mate text-base text-ricardo-red-dark font-medium">
                        Equidad, innovación, empatía y autonomía
                    </p>
                </div>
            </article>

        </div>
    </section>

    <!-- Valores Institucionales -->
    <section class="bg-white py-12 sm:py-16">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>Valor Institucional</x-section-title>
            <p class="mx-auto mt-4 max-w-3xl text-center text-sm leading-relaxed text-neutral-700 sm:text-base">
                En nuestra institución promovemos la práctica permanente de valores que fortalecen la convivencia
                escolar y la formación integral de los estudiantes.
            </p>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="group border border-neutral-100 bg-white p-6 transition-colors hover:border-ricardo-red">
                    <h3 class="font-mate text-xl text-ricardo-red transition-colors group-hover:text-ricardo-red-dark">
                        Respeto</h3>
                    <p class="mt-2 text-sm text-neutral-600">Valoramos a cada persona y fomentamos una convivencia
                        armoniosa basada en el buen trato y la tolerancia.</p>
                </div>
                <div class="group border border-neutral-100 bg-white p-6 transition-colors hover:border-ricardo-red">
                    <h3 class="font-mate text-xl text-ricardo-red transition-colors group-hover:text-ricardo-red-dark">
                        Responsabilidad</h3>
                    <p class="mt-2 text-sm text-neutral-600">Cumplimos nuestros deberes con compromiso, puntualidad y
                        dedicación en cada una de nuestras acciones.</p>
                </div>
                <div class="group border border-neutral-100 bg-white p-6 transition-colors hover:border-ricardo-red">
                    <h3 class="font-mate text-xl text-ricardo-red transition-colors group-hover:text-ricardo-red-dark">
                        Honestidad</h3>
                    <p class="mt-2 text-sm text-neutral-600">Actuamos con verdad, transparencia y coherencia en nuestra
                        vida personal y escolar.</p>
                </div>
                <div class="group border border-neutral-100 bg-white p-6 transition-colors hover:border-ricardo-red">
                    <h3 class="font-mate text-xl text-ricardo-red transition-colors group-hover:text-ricardo-red-dark">
                        Solidaridad</h3>
                    <p class="mt-2 text-sm text-neutral-600">Promovemos la ayuda mutua, el compañerismo y el trabajo
                        colaborativo dentro de la comunidad educativa.</p>
                </div>
                <div class="group border border-neutral-100 bg-white p-6 transition-colors hover:border-ricardo-red">
                    <h3 class="font-mate text-xl text-ricardo-red transition-colors group-hover:text-ricardo-red-dark">
                        Compromiso</h3>
                    <p class="mt-2 text-sm text-neutral-600">Asumimos con seriedad nuestra labor educativa y el esfuerzo
                        constante por mejorar cada día.</p>
                </div>
                <div class="group border border-neutral-100 bg-white p-6 transition-colors hover:border-ricardo-red">
                    <h3 class="font-mate text-xl text-ricardo-red transition-colors group-hover:text-ricardo-red-dark">
                        Innovación</h3>
                    <p class="mt-2 text-sm text-neutral-600">Impulsamos nuevas formas de enseñar y aprender, integrando
                        estrategias y recursos que fortalezcan el desarrollo de competencias.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Equipo Directivo -->
    <section class="bg-neutral-50 py-12 sm:py-16">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>Equipo Directivo</x-section-title>

            <div class="mt-10 grid grid-cols-2 gap-x-6 gap-y-10 sm:grid-cols-3 lg:grid-cols-4 lg:gap-x-8 lg:gap-y-12">

                <article class="group text-center">
                    <div class="mx-auto aspect-[3/4] w-full overflow-hidden rounded-sm bg-neutral-200 shadow-sm">
                        <img src="{{ asset('images/equipo/walter_porras.png') }}" alt="Dr. Walter Porras Ramirez"
                             class="h-full w-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    <h3 class="mt-4 font-mate text-base text-neutral-800 sm:text-lg">Dr. Walter Porras Ramirez</h3>
                    <p class="mt-1 font-system text-xs font-bold uppercase tracking-wider text-ricardo-red">Director</p>
                </article>

                <article class="group text-center">
                    <div class="mx-auto aspect-[3/4] w-full overflow-hidden rounded-sm bg-neutral-200 shadow-sm">
                        <img src="{{ asset('images/equipo/nicolas_espinoza.png') }}" alt="Dr. Nicolas Espinoza Suarez"
                             class="h-full w-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    <h3 class="mt-4 font-mate text-base text-neutral-800 sm:text-lg">Dr. Nicolas Espinoza Suarez</h3>
                    <p class="mt-1 font-system text-xs font-bold uppercase tracking-wider text-ricardo-teal">Sub
                        Director</p>
                </article>

                <article class="group text-center">
                    <div class="mx-auto aspect-[3/4] w-full overflow-hidden rounded-sm bg-neutral-200 shadow-sm">
                        <img src="{{ asset('images/equipo/adrian_tamara.png') }}" alt="Dr. Adrián Támara Trinidad"
                             class="h-full w-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    <h3 class="mt-4 font-mate text-base text-neutral-800 sm:text-lg">Dr. Adrián Támara Trinidad</h3>
                    <p class="mt-1 font-system text-xs font-bold uppercase tracking-wider text-ricardo-teal">Coordinador
                        Pedagógico</p>
                </article>

                <article class="group text-center">
                    <div class="mx-auto aspect-[3/4] w-full overflow-hidden rounded-sm bg-neutral-200 shadow-sm">
                        <img src="{{ asset('images/equipo/rayda_rivas.png') }}" alt="Dra. Rayda Rivas Solorzano"
                             class="h-full w-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    <h3 class="mt-4 font-mate text-base text-neutral-800 sm:text-lg">Dra. Rayda Rivas Solorzano</h3>
                    <p class="mt-1 font-system text-xs font-bold uppercase tracking-wider text-ricardo-teal">
                        Coordinadora de Ciencias</p>
                </article>

                <article class="group text-center">
                    <div class="mx-auto aspect-[3/4] w-full overflow-hidden rounded-sm bg-neutral-200 shadow-sm">
                        <img src="{{ asset('images/equipo/carmen_romero.png') }}" alt="Dra. Carmen Romero Garcia"
                             class="h-full w-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    <h3 class="mt-4 font-mate text-base text-neutral-800 sm:text-lg">Dra. Carmen Romero Garcia</h3>
                    <p class="mt-1 font-system text-xs font-bold uppercase tracking-wider text-ricardo-teal">
                        Coordinadora de TOE</p>
                </article>

                <article class="group text-center">
                    <div class="mx-auto aspect-[3/4] w-full overflow-hidden rounded-sm bg-neutral-200 shadow-sm">
                        <img src="{{ asset('images/equipo/luz_pardave.png') }}" alt="Mg. Luz Pardave Yachas"
                             class="h-full w-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    <h3 class="mt-4 font-mate text-base text-neutral-800 sm:text-lg">Mg. Luz Pardave Yachas</h3>
                    <p class="mt-1 font-system text-xs font-bold uppercase tracking-wider text-ricardo-teal">
                        Coordinadora Nivel Inicial</p>
                </article>

                <article class="group text-center">
                    <div class="mx-auto aspect-[3/4] w-full overflow-hidden rounded-sm bg-neutral-200 shadow-sm">
                        <img src="{{ asset('images/equipo/catering_campos.png') }}" alt="Lic. Catering Campos Fernandez"
                             class="h-full w-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    <h3 class="mt-4 font-mate text-base text-neutral-800 sm:text-lg">Lic. Catering Campos Fernandez</h3>
                    <p class="mt-1 font-system text-xs font-bold uppercase tracking-wider text-ricardo-teal">
                        Psicóloga</p>
                </article>

                <article class="group text-center">
                    <div class="mx-auto aspect-[3/4] w-full overflow-hidden rounded-sm bg-neutral-200 shadow-sm">
                        <img src="{{ asset('images/equipo/jean_rajo.png') }}" alt="Tec. Jean Rajo Guzman"
                             class="h-full w-full object-cover scale-100 transition-transform duration-300 group-hover:scale-105"
                             loading="lazy">
                    </div>
                    <h3 class="mt-4 font-mate text-base text-neutral-800 sm:text-lg">Tec. Jean Rajo Guzman</h3>
                    <p class="mt-1 font-system text-xs font-bold uppercase tracking-wider text-ricardo-teal">CIST</p>
                </article>

            </div>
        </div>
    </section>

    <!-- Compromiso y Reflejos -->
    <section class="bg-white py-12 sm:py-16">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <div class="grid gap-10 md:grid-cols-2 lg:gap-16">

                <article>
                    <h2 class="font-mate text-2xl text-ricardo-red">Compromiso Institucional</h2>
                    <div class="mt-4 space-y-4 text-sm leading-relaxed text-neutral-700">
                        <p>
                            En la Institución Educativa Integrada N.° 31756 “Ricardo Palma” trabajamos con dedicación
                            para formar estudiantes con valores, capacidades y visión de futuro, fortaleciendo una
                            educación de calidad al servicio de nuestra comunidad.
                        </p>
                        <p>
                            Renovamos nuestro compromiso de seguir construyendo un espacio educativo inclusivo,
                            participativo e innovador, donde cada estudiante tenga la oportunidad de aprender, crecer y
                            desarrollarse integralmente.
                        </p>
                    </div>
                </article>

                <article>
                    <h2 class="font-mate text-2xl text-ricardo-red">Reflejos</h2>
                    <div class="mt-4 space-y-4 text-sm leading-relaxed text-neutral-700">
                        <p>
                            La Institución Educativa Integrada N.° 31756 “Ricardo Palma” refleja su compromiso con una
                            educación basada en valores, respeto, responsabilidad e innovación, promoviendo el
                            desarrollo integral de los estudiantes en un ambiente de convivencia armoniosa y aprendizaje
                            permanente.
                        </p>
                        <p>
                            Cada acción formativa, cada actividad institucional y cada logro alcanzado son reflejo del
                            trabajo conjunto de directivos, docentes, estudiantes y padres de familia, quienes
                            contribuyen al fortalecimiento de una comunidad educativa unida, participativa y
                            comprometida con el futuro.
                        </p>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <section class="bg-white py-20 sm:py-28">
        <div class="mx-auto max-w-4xl px-6 text-center sm:px-8">

            <div class="mx-auto flex h-[2px] w-24 justify-center">
                <span class="h-full w-1/2 bg-ricardo-teal"></span>
                <span class="h-full w-1/2 bg-ricardo-red"></span>
            </div>

            <h2 class="font-mate text-2xl font-light italic leading-relaxed text-neutral-600 mt-8 sm:text-3xl md:text-4xl">
                "Comprometidos con tu futuro,<br class="hidden sm:inline"> y el de tus hijos"
            </h2>

            <p class="mt-4 font-system text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400">
                I.E.I. Ricardo Palma
            </p>

        </div>
    </section>
@endsection
