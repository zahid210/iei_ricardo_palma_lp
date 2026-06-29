@extends('layouts.app')

@section('title', 'Docentes | I.E.I. 31756 Ricardo Palma')

@section('content')
    <!-- SECCIÓN 1: Fotografía Principal y Leyenda -->
    <section class="bg-white pt-8 pb-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Fotografía de la Plana Docente -->
            <div class="w-full">
                <img
                    src="{{ asset('images/plana_docente.jpg') }}"
                    alt="Plana Docente de la Institución Educativa Ricardo Palma"
                    class="w-full h-auto object-cover"
                    fetchpriority="high"
                >
            </div>

            <!-- Leyenda Inferior con Líneas Laterales -->
            <div class="mt-6 flex items-center justify-center gap-4 text-center w-full max-w-5xl mx-auto">
                <!-- Línea izquierda: Teal puro -->
                <div class="hidden md:block h-[1px] w-full max-w-[150px] bg-ricardo-teal"></div>

                <p class="font-serif text-[13px] sm:text-sm text-neutral-800 font-medium px-2">
                    Profesionales comprometidos con la formación integral, el aprendizaje de calidad y el desarrollo de nuestros estudiantes.
                </p>

                <!-- Línea derecha: Rojo puro -->
                <div class="hidden md:block h-[1px] w-full max-w-[150px] bg-ricardo-red"></div>
            </div>

        </div>
    </section>

    <!-- SECCIÓN 2: Introducción Institucional (Fondo Gris Claro con Borde Rojo) -->
    <section class="bg-[#F5F5F5] py-14">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Bloque de texto con la característica línea roja a la izquierda -->
            <div class="border-l-[3px] border-ricardo-red pl-6 space-y-6 text-sm sm:text-[15px] lg:text-base text-neutral-800 leading-relaxed font-serif text-justify">
                <p>
                    En la Institución Educativa Integrada N.° 31756 “Ricardo Palma”, contamos con un equipo de docentes comprometidos con la educación, la formación en valores y el desarrollo integral de nuestros estudiantes. Su labor diaria fortalece los aprendizajes, promueve la convivencia escolar y contribuye al crecimiento académico, personal y social de toda nuestra comunidad educativa.
                </p>
                <p>
                    Nuestros docentes desempeñan un rol fundamental en la orientación, acompañamiento y formación de los estudiantes, aplicando estrategias pedagógicas que responden a las necesidades actuales de la educación y fomentan una enseñanza activa, inclusiva y significativa.
                </p>
            </div>
        </div>
    </section>

    <!-- SECCIÓN 3: Compromiso Pedagógico y Diagrama -->
    <section class="bg-white py-14 sm:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <!-- Encabezado Fiel al Mockup (Alineado a la izquierda, barra completa) -->
            <div class="w-full mb-10">
                <h2 class="font-serif text-2xl sm:text-3xl text-neutral-800 mb-3" style="font-variant: small-caps;">
                    Compromiso Pedagógico
                </h2>
                <!-- Doble barra de color sólida que cruza todo el ancho -->
                <div class="w-full flex flex-col">
                    <div class="h-[3px] w-full bg-ricardo-teal"></div>
                    <div class="h-[4px] w-full bg-[#c92a2a]"></div> <!-- Tonalidad roja de la barra -->
                </div>
            </div>

            <!-- Textos Introductorios Centrados -->
            <div class="max-w-4xl mx-auto text-sm sm:text-[15px] lg:text-base text-neutral-800 leading-relaxed font-serif space-y-5 mb-14 text-center">
                <p>
                    Nuestros docentes asumen con responsabilidad la tarea de educar, orientar y acompañar a los estudiantes en su proceso formativo. Su labor se basa en el respeto, la inclusión, la innovación, la práctica de valores y la mejora continua de los aprendizajes.
                </p>
                <p>
                    Como parte de su compromiso institucional, desarrollan actividades pedagógicas que favorecen:
                </p>
            </div>

            <!-- DIAGRAMA CON IMAGEN CENTRAL (Octágono) -->

            <!-- Vista de Escritorio (Estructura de 3 Columnas) -->
            <div class="hidden lg:grid grid-cols-[1fr_auto_1fr] items-stretch gap-x-2 max-w-5xl mx-auto mb-10">

                <!-- COLUMNA IZQUIERDA -->
                <div class="flex flex-col justify-between py-12">
                    <!-- Eje 1 (Línea Roja Clara) -->
                    <div class="flex items-center justify-end w-full">
                        <span class="mr-4 font-serif text-[15px] text-neutral-800">Comprensión lectora</span>
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#e58a8a]"></div>
                    </div>
                    <!-- Eje 2 (Línea Turquesa) -->
                    <div class="flex items-center justify-end w-full">
                        <span class="mr-4 font-serif text-[15px] text-neutral-800">Resolución de problemas</span>
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#67a79e]"></div>
                    </div>
                    <!-- Eje 3 (Línea Roja Oscura) -->
                    <div class="flex items-center justify-end w-full">
                        <span class="mr-4 font-serif text-[15px] text-neutral-800">Pensamiento crítico</span>
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#b12e2e]"></div>
                    </div>
                </div>

                <!-- COLUMNA CENTRAL (Imagen provista por ti) -->
                <div class="px-6 flex items-center justify-center">
                    <img
                        src="{{ asset('images/octagono_docente.png') }}"
                        alt="Ejes Pedagógicos"
                        class="w-[280px] h-auto object-contain"
                    >
                </div>

                <!-- COLUMNA DERECHA -->
                <div class="flex flex-col justify-between py-12">
                    <!-- Eje 4 (Línea Roja Clara) -->
                    <div class="flex items-center justify-start w-full">
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#e58a8a]"></div>
                        <span class="ml-4 font-serif text-[15px] text-neutral-800">Convivencia democrática</span>
                    </div>
                    <!-- Eje 5 (Línea Turquesa) -->
                    <div class="flex items-center justify-start w-full">
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#67a79e]"></div>
                        <span class="ml-4 font-serif text-[15px] text-neutral-800">Formación integral de los estudiantes</span>
                    </div>
                    <!-- Eje 6 (Línea Turquesa Oscura/Grisácea - Basado en la imagen) -->
                    <div class="flex items-center justify-start w-full">
                        <div class="h-[1px] flex-grow max-w-[140px] bg-[#5c6e6b]"></div>
                        <span class="ml-4 font-serif text-[15px] text-neutral-800">Uso responsable de la tecnología</span>
                    </div>
                </div>

            </div>

            <!-- Vista Adaptativa para Móviles y Tablets -->
            <div class="block lg:hidden max-w-md mx-auto space-y-8">
                <!-- Imagen centrada arriba en móviles -->
                <div class="flex justify-center mb-8">
                    <img src="{{ asset('images/octagono_docente.png') }}" alt="Ejes Pedagógicos" class="w-48 sm:w-56 h-auto">
                </div>

                <!-- Lista de compromisos -->
                <div class="space-y-4 font-serif text-neutral-800 text-center">
                    <div class="border-b border-[#e58a8a] pb-2">Comprensión lectora</div>
                    <div class="border-b border-[#67a79e] pb-2">Resolución de problemas</div>
                    <div class="border-b border-[#b12e2e] pb-2">Pensamiento crítico</div>
                    <div class="border-b border-[#e58a8a] pb-2">Convivencia democrática</div>
                    <div class="border-b border-[#67a79e] pb-2">Formación integral de los estudiantes</div>
                    <div class="border-b border-[#5c6e6b] pb-2">Uso responsable de la tecnología</div>
                </div>
            </div>

        </div>
    </section>
@endsection
