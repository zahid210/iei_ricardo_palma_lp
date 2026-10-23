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
@endsection
