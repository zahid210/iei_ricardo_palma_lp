@extends('layouts.app')

@section('title', 'Docentes | I.E.I. N° 31756 Ricardo Palma')
@section('meta_description', 'Conoce al equipo de profesores y profesionales comprometidos con la educación, el desarrollo integral y los valores de los estudiantes ricardinos.')

@section('content')
    <!-- BANNER INSTITUCIONAL -->
    <section class="institution-hero" style="--hero-bg: url('{{ asset('images/plana_docente.jpg') }}'); --hero-pos: center 15%;">
        <div class="institution-overlay"></div>

        <div class="institution-content">
            <span class="institution-eyebrow">
                COMUNIDAD EDUCATIVA
            </span>

            <h1>
                Nuestra
                <span class="text-highlight">Plana Docente</span>
            </h1>

            <p>
                "Profesionales comprometidos con la formación integral, el aprendizaje de calidad y el desarrollo de nuestros estudiantes."
            </p>
        </div>
    </section>

    <!-- SECCIÓN DE PRESENTACIÓN -->
    <section class="institution-intro">
        <div class="intro-content">

            <div class="intro-icon" aria-hidden="true">
                {{-- Símbolo de Birrete (Graduation Cap) --}}
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="36"
                    height="36"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/>
                    <path d="M22 10v6"/>
                    <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/>
                </svg>
            </div>

            <p>
                En la Institución Educativa Integrada N.° 31756 “Ricardo Palma”, contamos con un equipo de
                docentes comprometidos con la educación, la formación en valores y el desarrollo integral de
                nuestros estudiantes. Su labor diaria fortalece los aprendizajes, promueve la convivencia
                escolar y contribuye al crecimiento académico, personal y social de toda nuestra comunidad
                educativa.
            </p>

        </div>
    </section>

    <section class="section-muted py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="w-full mb-10">
                <x-section-title>Compromiso Pedagógico</x-section-title>
            </div>

            <div class="max-w-4xl mx-auto text-[15px] sm:text-[15px] lg:text-[17px] text-neutral-600 leading-relaxed space-y-4 mb-14 text-center opacity-0 translate-y-6 transition-all duration-700 ease-out"
                 data-reveal>
                <p>
                    Nuestros docentes asumen con responsabilidad la tarea de educar, orientar y acompañar a los
                    estudiantes en su proceso formativo. Su labor se basa en el respeto, la inclusión, la innovación, la
                    práctica de valores y la mejora continua de los aprendizajes.
                </p>
                <p class="font-medium text-neutral-700">
                    Como parte de su compromiso institucional, desarrollan actividades pedagógicas que favorecen:
                </p>
            </div>

            <div class="hidden lg:grid grid-cols-[1fr_auto_1fr] items-stretch gap-x-4 max-w-5xl mx-auto mb-10">

                <div class="flex flex-col justify-between py-12" data-reveal data-stagger>
                    <div class="flex items-center justify-end w-full opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <span class="mr-4 font-mate text-[15px] font-medium text-neutral-800">Comprensión lectora</span>
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#CA1708] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>
                    <div class="flex items-center justify-end w-full opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <span class="mr-4 font-mate text-[15px] font-medium text-neutral-800">Resolución de problemas</span>
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#129582] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>
                    <div class="flex items-center justify-end w-full opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <span class="mr-4 font-mate text-[15px] font-medium text-neutral-800">Pensamiento crítico</span>
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#CA1708] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>
                </div>

                <div class="px-6 flex items-center justify-center opacity-0 scale-95 transition-all duration-1000 ease-out"
                     data-reveal>
                    <img
                        src="{{ asset('images/octagono_docente.png') }}"
                        alt="Ejes Pedagógicos"
                        class="w-[280px] h-auto object-contain"
                    >
                </div>

                <div class="flex flex-col justify-between py-12" data-reveal data-stagger>
                    <div class="flex items-center justify-start w-full opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#CA1708] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                        <span class="ml-4 font-mate text-[15px] font-medium text-neutral-800">Convivencia democrática</span>
                    </div>
                    <div class="flex items-center justify-start w-full opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#129582] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                        <span class="ml-4 font-mate text-[15px] font-medium text-neutral-800">Formación integral</span>
                    </div>
                    <div class="flex items-center justify-start w-full opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#CA1708] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                        <span class="ml-4 font-mate text-[15px] font-medium text-neutral-800">Uso responsable de tecnología</span>
                    </div>
                </div>

            </div>

            <div class="block lg:hidden max-w-md mx-auto">
                <div class="flex justify-center mb-8 opacity-0 scale-95 transition-all duration-700 ease-out" data-reveal>
                    <img src="{{ asset('images/octagono_docente.png') }}" alt="Ejes Pedagógicos" class="w-48 sm:w-56 h-auto">
                </div>

                <div class="space-y-5 font-mate text-neutral-800 text-center" data-reveal data-stagger>

                    <div class="opacity-0 translate-y-4 transition-all duration-500 ease-out flex flex-col items-center">
                        <span>Comprensión lectora</span>
                        <div class="mt-2 h-[1px] w-full max-w-xs bg-[#CA1708] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>

                    <div class="opacity-0 translate-y-4 transition-all duration-500 ease-out flex flex-col items-center">
                        <span>Resolución de problemas</span>
                        <div class="mt-2 h-[1px] w-full max-w-xs bg-[#129582] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>

                    <div class="opacity-0 translate-y-4 transition-all duration-500 ease-out flex flex-col items-center">
                        <span>Pensamiento crítico</span>
                        <div class="mt-2 h-[1px] w-full max-w-xs bg-[#CA1708] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>

                    <div class="opacity-0 translate-y-4 transition-all duration-500 ease-out flex flex-col items-center">
                        <span>Convivencia democrática</span>
                        <div class="mt-2 h-[1px] w-full max-w-xs bg-[#CA1708] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>

                    <div class="opacity-0 translate-y-4 transition-all duration-500 ease-out flex flex-col items-center">
                        <span>Formación integral de los estudiantes</span>
                        <div class="mt-2 h-[1px] w-full max-w-xs bg-[#129582] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>

                    <div class="opacity-0 translate-y-4 transition-all duration-500 ease-out flex flex-col items-center">
                        <span>Uso responsable de la tecnología</span>
                        <div class="mt-2 h-[1px] w-full max-w-xs bg-[#CA1708] opacity-0 scale-x-0 origin-center transition-all duration-700 ease-out" data-bar></div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- LISTADO DE DOCENTES POR NIVEL -->
    <section class="bg-white py-14 sm:py-20 border-t border-neutral-100">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="inline-block text-xs uppercase tracking-wider font-semibold text-ricardo-teal mb-2">
                    Nuestra Plana Educativa
                </span>
                <x-section-title>Docentes y Personal por Nivel</x-section-title>
                <p class="mt-4 text-[15px] sm:text-[16px] text-neutral-600">
                    Conoce a los maestros y maestras que guían el aprendizaje en cada una de nuestras etapas formativas.
                </p>
            </div>

            @php
                $nivelesInfo = [
                    'Inicial' => [
                        'color' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
                        'accent' => 'text-emerald-700',
                        'desc' => 'Primeros pasos en el desarrollo integral, psicomotriz y socioemocional.',
                    ],
                    'Primaria' => [
                        'color' => 'bg-amber-50 text-amber-800 border-amber-200',
                        'accent' => 'text-amber-700',
                        'desc' => 'Consolidación de competencias fundamentales, lectura y pensamiento matemático.',
                    ],
                    'Secundaria' => [
                        'color' => 'bg-sky-50 text-sky-800 border-sky-200',
                        'accent' => 'text-sky-700',
                        'desc' => 'Jornada Escolar Completa (JEC), pensamiento crítico y formación preuniversitaria.',
                    ],
                ];
            @endphp

            <div class="space-y-16">
                @foreach($porNivel as $nivel => $lista)
                    @if($lista->isNotEmpty())
                        <div class="border border-neutral-200 rounded-none bg-neutral-50/50 p-6 sm:p-8" data-reveal>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-neutral-200 gap-3">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h3 class="font-mate text-2xl font-bold text-neutral-900">
                                            Nivel {{ $nivel }}
                                        </h3>
                                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-none border {{ $nivelesInfo[$nivel]['color'] ?? 'bg-neutral-100 text-neutral-800 border-neutral-300' }}">
                                            {{ $lista->count() }} profesionales
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-neutral-500 mt-1">
                                        {{ $nivelesInfo[$nivel]['desc'] ?? '' }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($lista as $docente)
                                    <div class="bg-white border border-neutral-200 p-4 flex items-start gap-3.5 hover:border-ricardo-teal transition-colors rounded-none">
                                        <div class="w-10 h-10 flex-shrink-0 bg-neutral-100 border border-neutral-200 flex items-center justify-center font-bold text-neutral-600 text-sm">
                                            {{ mb_substr($docente->nombres_apellidos, 0, 1) }}
                                        </div>
                                        <div class="min-w-0 flex-grow">
                                            <h4 class="text-sm font-semibold text-neutral-900 leading-snug line-clamp-2" title="{{ $docente->nombres_apellidos }}">
                                                {{ $docente->nombres_apellidos }}
                                            </h4>
                                            <span class="inline-block mt-1 text-[11.5px] uppercase font-semibold tracking-wide {{ $nivelesInfo[$nivel]['accent'] ?? 'text-neutral-600' }}">
                                                {{ $docente->cargo }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
