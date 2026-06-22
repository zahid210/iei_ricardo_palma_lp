@extends('layouts.app')

@section('title', 'I.E.I. 31756 Ricardo Palma')

@section('content')
    <section class="relative w-full" aria-label="Fachada institucional">
        <img
            src="{{ asset('images/fachada_colegio.jpg') }}"
            alt="Fachada de la I.E.I. Ricardo Palma"
            class="h-[15rem] w-full object-cover sm:h-[24rem] lg:h-[30rem] xl:h-[31rem]"
            fetchpriority="high"
        >
    </section>

    <section class="bg-white py-10 sm:py-12 lg:py-14">
        <div class="mx-auto grid max-w-7xl gap-4 px-6 sm:px-8 md:grid-cols-[.82fr_1.18fr]">
            <article class="relative flex min-h-64 items-center justify-center bg-ricardo-paper px-8 py-10 text-center sm:min-h-80 lg:min-h-[28rem]">
                <div class="absolute right-0 top-0 flex h-28 w-11">
                    <span class="h-full w-1/2 bg-ricardo-teal"></span>
                    <span class="h-full w-1/2 bg-ricardo-red"></span>
                </div>
                <h1 class="font-mate text-3xl leading-tight text-neutral-800 sm:text-4xl lg:text-5xl">
                    “Ser Ricardino,<br>
                    es ser cada día<br>
                    mejor”
                </h1>
            </article>

            <figure class="min-h-64 overflow-hidden sm:min-h-80 lg:min-h-[28rem]">
                <img
                    src="{{ asset('images/alumna_destacada.png') }}"
                    alt="Estudiante ricardina desarrollando sus actividades escolares"
                    class="h-full w-full object-cover"
                    loading="lazy"
                >
            </figure>
        </div>
    </section>

    <section id="nosotros" class="bg-white pb-10 sm:pb-14">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>Bienvenidos a la I.E.I N.° 31756 Ricardo Palma</x-section-title>

            <div class="mt-5 grid gap-7 lg:grid-cols-[.42fr_.58fr] lg:items-start">
                <figure class="overflow-hidden">
                    <img
                        src="{{ asset('images/docente_clase.jpg') }}"
                        alt="Docente acompañando a estudiantes en clase"
                        class="aspect-[1080/757] w-full object-cover"
                        loading="lazy"
                    >
                </figure>

                <article class="space-y-5 text-sm leading-relaxed text-neutral-700 sm:text-base lg:pt-1">
                    <p>
                        La <strong class="font-semibold text-ricardo-teal">Institución Educativa Integrada N.° 31756 “Ricardo Palma”</strong>,
                        ubicada en Cerro de Pasco, se ha consolidado como una institución comprometida con la formación integral de sus estudiantes
                        en los niveles de Inicial, Primaria y Secundaria.
                    </p>
                    <p>
                        A lo largo de su trayectoria, ha impulsado proyectos de innovación educativa, fortaleciendo el aprendizaje mediante la
                        Jornada Escolar Completa (JEC) y promoviendo una educación basada en valores, el respeto y la mejora continua.
                    </p>
                    <p>
                        Hoy, la institución continúa formando estudiantes competentes, autónomos y comprometidos con su comunidad, integrando
                        nuevas estrategias pedagógicas y el uso de las tecnologías.
                    </p>
                </article>
            </div>
        </div>
    </section>

    <section id="niveles" class="bg-white py-8 sm:py-10">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>Nuestros Niveles</x-section-title>

            <div class="mt-12 grid gap-10 sm:grid-cols-3 sm:gap-6 lg:mt-16 lg:gap-16">
                <x-level-badge image="images/nivel_inicial.png" label="Nivel Inicial" />
                <x-level-badge image="images/nivel_primaria.png" label="Nivel Primaria" />
                <x-level-badge image="images/nivel_secundaria.png" label="Nivel Secundaria" />
            </div>
        </div>
    </section>

    <section id="galeria" class="bg-white py-10 sm:py-14">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>Galería</x-section-title>

            <div class="mt-8 grid gap-0 overflow-hidden sm:grid-cols-2">
                <article>
                    <img src="{{ asset('images/galeria_1.jpg') }}" alt="Reconocimiento académico de estudiante ricardino" class="aspect-[3/2] w-full object-cover" loading="lazy">
                </article>
                <article>
                    <img src="{{ asset('images/galeria_2.jpg') }}" alt="Equipo femenino campeón de futsal" class="aspect-[3/2] w-full object-cover" loading="lazy">
                </article>
                <article>
                    <img src="{{ asset('images/galeria_3.jpg') }}" alt="Equipo masculino campeón de futsal" class="aspect-[3/2] w-full object-cover" loading="lazy">
                </article>
                <article class="group relative">
                    <img src="{{ asset('images/galeria_4.jpg') }}" alt="Más actividades institucionales" class="aspect-[3/2] w-full scale-105 object-cover blur-sm transition duration-300 group-hover:blur-none" loading="lazy">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[1px] transition duration-300 group-hover:bg-black/10">
                        <a href="{{ url('/#galeria') }}" class="border border-white px-8 py-3 font-mate text-2xl uppercase tracking-wide text-white transition-colors hover:bg-white hover:text-neutral-900">
                            Ver Más
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section id="objetivo" class="bg-white pb-16 sm:pb-20">
        <div class="mx-auto max-w-7xl px-6 sm:px-8">
            <x-section-title>Nuestro Objetivo</x-section-title>

            <div class="mt-9 grid gap-10 lg:grid-cols-[.48fr_.52fr] lg:items-center">
                <div class="grid grid-cols-2 gap-x-8 gap-y-8 sm:gap-y-10">
                    <x-stat-item value="10+" label="Docentes Totales">
                        <x-slot:icon>
                            <svg viewBox="0 0 24 24" class="h-full w-full fill-none stroke-current stroke-[1.8]"><path d="M8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM16 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.5 20v-1.2c0-2.4 2-4.3 4.5-4.3s4.5 1.9 4.5 4.3V20M11.5 15.2c.8-.5 1.8-.7 2.8-.7 2.5 0 4.5 1.9 4.5 4.3V20"/></svg>
                        </x-slot:icon>
                    </x-stat-item>

                    <x-stat-item value="200+" label="Padres Satisfechos">
                        <x-slot:icon>
                            <svg viewBox="0 0 24 24" class="h-full w-full fill-none stroke-current stroke-[1.8]"><path d="m8 12 3 3 5-6M3 12l4-4 4 4M21 12l-4-4-4 4M7 8l5-5 5 5M4 16l4 4h8l4-4"/></svg>
                        </x-slot:icon>
                    </x-stat-item>

                    <div class="col-span-2">
                        <x-stat-item value="150+" label="Estudiantes Totales">
                            <x-slot:icon>
                                <svg viewBox="0 0 24 24" class="h-full w-full fill-none stroke-current stroke-[1.8]"><path d="m3 9 9-4 9 4-9 4-9-4Z"/><path d="M7 11.2V16c0 1.7 2.2 3 5 3s5-1.3 5-3v-4.8M20 10v5"/></svg>
                            </x-slot:icon>
                        </x-stat-item>
                    </div>
                </div>

                <article class="text-lg leading-relaxed text-neutral-800 sm:text-xl lg:text-2xl">
                    <p>
                        Formar estudiantes íntegros, críticos, creativos e innovadores mediante una educación de calidad, inclusiva y basada
                        en valores; consolidando una institución líder con gestión participativa, docentes actualizados, familias comprometidas
                        e infraestructura moderna y sostenible.
                    </p>
                </article>
            </div>
        </div>
    </section>
@endsection
