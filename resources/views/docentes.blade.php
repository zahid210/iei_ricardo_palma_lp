@extends('layouts.app')

@section('title', 'Docentes | I.E.I. 31756 Ricardo Palma')

@section('content')
    <!-- Encabezado de la Sección (Heredado del look de Nosotros) -->
    <section class="bg-white pt-6 pb-10 sm:pt-10 sm:pb-12">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <article class="relative flex flex-col items-center justify-center bg-ricardo-paper px-8 py-14 text-center sm:min-h-64 lg:min-h-[20rem]">
                <!-- Detalle decorativo superior derecho exacto -->
                <div class="absolute right-0 top-0 flex h-32 w-8 [clip-path:polygon(0_0,_100%_0,_100%_100%,_0_84%)] sm:h-40 sm:w-10">
                    <span class="h-full w-1/2 bg-ricardo-teal"></span>
                    <span class="h-full w-1/2 bg-ricardo-red"></span>
                </div>

                <h1 class="font-mate text-3xl leading-tight text-neutral-800 sm:text-4xl lg:text-5xl">
                    Nuestra Plana Docente
                </h1>
                <p class="mx-auto mt-5 max-w-3xl text-sm leading-relaxed text-neutral-700 sm:text-base">
                    Profesionales altamente calificados comprometidos con la formación integral, la innovación pedagógica y el desarrollo continuo de nuestros estudiantes en cada nivel académico.
                </p>
            </article>
        </div>
    </section>

    <!-- Presentación e Imagen -->
    <section class="bg-white pb-12 sm:pb-16">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>Vocación y Experiencia</x-section-title>

            <div class="mt-8 grid gap-8 lg:grid-cols-[.55fr_.45fr] lg:items-center">
                <article class="space-y-4 text-sm leading-relaxed text-neutral-700 sm:text-base">
                    <p>
                        En la <strong class="font-semibold text-ricardo-teal">Institución Educativa Integrada N.° 31756 “Ricardo Palma”</strong>, la labor docente trasciende las aulas. Nuestro equipo asume la responsabilidad formativa en los niveles de Inicial, Primaria y Secundaria, consolidando un entorno de aprendizaje activo bajo el modelo de la Jornada Escolar Completa (JEC).
                    </p>
                    <p>
                        Nuestros maestros se capacitan continuamente para diseñar estrategias didácticas inclusivas y personalizadas, asegurando que cada estudiante potencie sus habilidades intelectuales y socioemocional de acuerdo con las exigencias del entorno actual.
                    </p>
                    <p>
                        A través del trabajo colaborativo con los directivos y los padres de familia, la plana docente promueve una convivencia escolar armoniosa, guiando a la comunidad ricandina hacia la mejora continua y la excelencia.
                    </p>
                </article>

                <figure class="overflow-hidden rounded-sm shadow-2xs border border-neutral-100">
                    <img
                        src="{{ asset('images/plana_docente.jpg') }}"
                        alt="Plana Docente Ricardo Palma"
                        class="aspect-[4/3] w-full object-cover"
                        loading="lazy"
                    >
                </figure>
            </div>
        </div>
    </section>

    <!-- Compromiso Pedagógico (Mismo patrón estético que "Valores" en Nosotros) -->
    <section class="bg-ricardo-paper py-12 sm:py-16 border-t border-b border-neutral-200/50">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>Compromiso Pedagógico</x-section-title>
            <p class="mx-auto mt-4 max-w-3xl text-center text-sm leading-relaxed text-neutral-700 sm:text-base">
                Nuestra práctica metodológica se orienta bajo principios de excelencia, promoviendo permanentemente seis ejes fundamentales dentro del proceso de aprendizaje:
            </p>

            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                <!-- Tarjeta 1 -->
                <div class="group border border-neutral-100 bg-white p-6 transition-all hover:border-ricardo-teal hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <h3 class="font-mate text-xl text-neutral-800 transition-colors group-hover:text-ricardo-teal-dark">Pensamiento Crítico</h3>
                        <span class="font-system text-xs font-bold text-neutral-300 transition-colors group-hover:text-ricardo-teal/40">01</span>
                    </div>
                    <p class="mt-2 text-sm text-neutral-600">Fomento del análisis autónomo y la reflexión profunda en el estudiante ante su entorno real.</p>
                </div>

                <!-- Tarjeta 2 -->
                <div class="group border border-neutral-100 bg-white p-6 transition-all hover:border-ricardo-teal hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <h3 class="font-mate text-xl text-neutral-800 transition-colors group-hover:text-ricardo-teal-dark">Comprensión Lectora</h3>
                        <span class="font-system text-xs font-bold text-neutral-300 transition-colors group-hover:text-ricardo-teal/40">02</span>
                    </div>
                    <p class="mt-2 text-sm text-neutral-600">Potenciación de las habilidades cognitivas para interpretar y procesar diversas fuentes de información.</p>
                </div>

                <!-- Tarjeta 3 -->
                <div class="group border border-neutral-100 bg-white p-6 transition-all hover:border-ricardo-teal hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <h3 class="font-mate text-xl text-neutral-800 transition-colors group-hover:text-ricardo-teal-dark">Resolución de Problemas</h3>
                        <span class="font-system text-xs font-bold text-neutral-300 transition-colors group-hover:text-ricardo-teal/40">03</span>
                    </div>
                    <p class="mt-2 text-sm text-neutral-600">Estrategias lógicas y reflexivas para afrontar con efectividad los desafíos del mundo contemporáneo.</p>
                </div>

                <!-- Tarjeta 4 -->
                <div class="group border border-neutral-100 bg-white p-6 transition-all hover:border-ricardo-teal hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <h3 class="font-mate text-xl text-neutral-800 transition-colors group-hover:text-ricardo-teal-dark">Convivencia Democrática</h3>
                        <span class="font-system text-xs font-bold text-neutral-300 transition-colors group-hover:text-ricardo-teal/40">04</span>
                    </div>
                    <p class="mt-2 text-sm text-neutral-600">Establecimiento de relaciones sanas basadas en la equidad, el respeto mutuo y la cultura de paz.</p>
                </div>

                <!-- Tarjeta 5 -->
                <div class="group border border-neutral-100 bg-white p-6 transition-all hover:border-ricardo-teal hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <h3 class="font-mate text-xl text-neutral-800 transition-colors group-hover:text-ricardo-teal-dark">Tecnología Responsable</h3>
                        <span class="font-system text-xs font-bold text-neutral-300 transition-colors group-hover:text-ricardo-teal/40">05</span>
                    </div>
                    <p class="mt-2 text-sm text-neutral-600">Integración ética y balanceada de herramientas digitales orientadas a potenciar el aprendizaje activo.</p>
                </div>

                <!-- Tarjeta 6 -->
                <div class="group border border-neutral-100 bg-white p-6 transition-all hover:border-ricardo-teal hover:shadow-xs">
                    <div class="flex items-center justify-between">
                        <h3 class="font-mate text-xl text-neutral-800 transition-colors group-hover:text-ricardo-teal-dark">Formación Integral</h3>
                        <span class="font-system text-xs font-bold text-neutral-300 transition-colors group-hover:text-ricardo-teal/40">06</span>
                    </div>
                    <p class="mt-2 text-sm text-neutral-600">Equilibrio constante y progresivo entre la madurez socioemocional y la excelencia académica.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Cierre de Sección Estilizado (Idéntico al final de Nosotros e Inicio) -->
    <section class="bg-white py-20 sm:py-24">
        <div class="mx-auto max-w-4xl px-6 text-center sm:px-8">

            <div class="mx-auto flex h-[2px] w-24 justify-center">
                <span class="h-full w-1/2 bg-ricardo-teal"></span>
                <span class="h-full w-1/2 bg-ricardo-red"></span>
            </div>

            <h2 class="font-mate text-2xl font-light italic leading-relaxed text-neutral-600 mt-8 sm:text-3xl md:text-4xl">
                “Ser Ricardino,<br class="sm:hidden"> es ser cada día mejor”
            </h2>

            <p class="mt-4 font-system text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-400">
                I.E.I. Ricardo Palma • Plana Docente
            </p>

        </div>
    </section>
@endsection
