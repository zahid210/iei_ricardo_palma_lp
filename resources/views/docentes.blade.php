@extends('layouts.app')

@section('title', 'Docentes | I.E.I. N° 31756 Ricardo Palma')

@section('content')
    <section class="bg-white pt-6 pb-10 sm:pt-8 sm:pb-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="w-full overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-700 ease-out"
                 data-reveal>
                <img
                    src="{{ asset('images/plana_docente.jpg') }}"
                    alt="Plana Docente de la Institución Educativa Ricardo Palma"
                    class="w-full h-auto object-cover scale-100 transition-transform duration-700 ease-out hover:scale-102"
                    fetchpriority="high"
                >
            </div>

            <div class="mt-8 flex items-center justify-center gap-4 text-center w-full max-w-5xl mx-auto">
                <div class="hidden md:block h-[1px] w-full max-w-[150px] bg-ricardo-teal/60 opacity-0 scale-x-0 origin-center transition-all duration-1000 ease-out"
                     data-reveal data-bar></div>

                <p class="font-mate text-sm sm:text-base text-neutral-700 italic px-2 max-w-2xl opacity-0 translate-y-4 transition-all duration-700 delay-100 ease-out"
                   data-reveal>
                    "Profesionales comprometidos con la formación integral, el aprendizaje de calidad y el desarrollo de nuestros estudiantes."
                </p>

                <div class="hidden md:block h-[1px] w-full max-w-[150px] bg-ricardo-red/60 opacity-0 scale-x-0 origin-center transition-all duration-1000 ease-out"
                     data-reveal data-bar></div>
            </div>

        </div>
    </section>

    <section class="bg-neutral-50 py-14 border-y border-neutral-100">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="flex items-stretch gap-6 opacity-0 translate-y-8 transition-all duration-700 ease-out"
                 data-reveal>

                <div class="w-[4px] flex flex-col shrink-0 rounded-full overflow-hidden opacity-0 scale-y-0 origin-center transition-all duration-1000 ease-out"
                     data-reveal data-bar-v aria-hidden="true">
                    <div class="h-1/2 w-full bg-ricardo-teal"></div>
                    <div class="h-1/2 w-full bg-ricardo-red"></div>
                </div>

                <div class="space-y-6 text-sm sm:text-[15px] lg:text-base text-neutral-700 leading-relaxed text-justify">
                    <p>
                        En la Institución Educativa Integrada N.° 31756 “Ricardo Palma”, contamos con un equipo de
                        docentes comprometidos con la educación, la formación en valores y el desarrollo integral de
                        nuestros estudiantes. Su labor diaria fortalece los aprendizajes, promueve la convivencia
                        escolar y contribuye al crecimiento académico, personal y social de toda nuestra comunidad
                        educativa.
                    </p>
                    <p>
                        Nuestros docentes desempeñan un rol fundamental en la orientación, acompañamiento y formación de
                        los estudiantes, aplicando estrategias pedagógicas que responden a las necesidades actuales de
                        la educación y fomentan una enseñanza activa, inclusiva y significativa.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <section class="bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="w-full mb-10">
                <x-section-title>Compromiso Pedagógico</x-section-title>
            </div>

            <div class="max-w-4xl mx-auto text-sm sm:text-[15px] lg:text-base text-neutral-600 leading-relaxed space-y-4 mb-14 text-center opacity-0 translate-y-6 transition-all duration-700 ease-out"
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
