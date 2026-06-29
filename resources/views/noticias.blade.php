@extends('layouts.app')

@section('title', 'Noticias | I.E.I. 31756 Ricardo Palma')

@section('content')
    <!-- SDK de Facebook (Requerido para renderizar el widget) -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v18.0"></script>

    <!-- ENCABEZADO DE LA SECCIÓN -->
    <section class="bg-white pt-8 pb-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Encabezado con tu componente nativo -->
            <div class="w-full mb-6">
                <x-section-title>Últimas Noticias</x-section-title>
            </div>

            <p class="font-serif text-sm sm:text-base text-neutral-600 leading-relaxed max-w-3xl">
                Sigue de cerca las actividades, comunicados urgentes y el día a día de nuestra comunidad ricardina a través de nuestra plataforma oficial de comunicación en tiempo real.
            </p>
        </div>
    </section>

    <!-- CUERPO PRINCIPAL ASIMÉTRICO (Soluciona el vacío en Desktop) -->
    <section class="bg-[#F5F5F5] py-10 sm:py-14 border-t border-neutral-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Grid distributivo: 1 columna en móvil, 12 columnas en escritorio grande -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- COLUMNA IZQUIERDA: Cartelera Escolar e Información Activa (7 Columnas en Desktop) -->
                <div class="lg:col-span-7 space-y-6">

                    <!-- Bloque Informativo Institucional -->
                    <div class="bg-white p-6 rounded-xs border border-neutral-200 shadow-3xs">
                        <h3 class="font-serif text-lg text-neutral-800 font-bold mb-3 flex items-center gap-2">
                            <span class="w-[3px] h-5 bg-ricardo-teal inline-block"></span>
                            Comunicación y Transparencia
                        </h3>
                        <p class="font-serif text-sm text-neutral-600 leading-relaxed mb-4">
                            Nuestra institución mantiene sus canales digitales actualizados para asegurar que los padres de familia, estudiantes y la comunidad de Chaupimarca cuenten con información oportuna sobre los eventos del año lectivo.
                        </p>

                        <div class="border-t border-neutral-100 pt-4 space-y-3">
                            <div class="flex items-start gap-3 text-xs">
                                <span class="px-2 py-0.5 bg-red-100 text-ricardo-red font-bold rounded-xs uppercase font-sans tracking-wider shrink-0">Aviso</span>
                                <p class="text-neutral-700 font-serif leading-relaxed">
                                    Los comunicados oficiales firmados por el equipo directivo se respaldan simultáneamente mediante nuestra plataforma de redes sociales.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Caja Auxiliar: Soporte para bloqueadores de anuncios (Mejora la UX) -->
                    <div class="bg-white p-6 rounded-xs border border-neutral-200 shadow-3xs">
                        <h3 class="font-serif text-lg text-neutral-800 font-bold mb-3 flex items-center gap-2">
                            <span class="w-[3px] h-5 bg-ricardo-red inline-block"></span>
                            ¿No puedes visualizar el panel de noticias?
                        </h3>
                        <p class="font-serif text-sm text-neutral-600 leading-relaxed">
                            Si utilizas extensiones para bloquear publicidad (como AdBlock, uBlock o Brave Shield), es posible que el plugin externo de Facebook no se cargue por políticas de privacidad de tu navegador. Si ese es tu caso, puedes ingresar directamente haciendo clic aquí:
                        </p>

                        <div class="mt-5">
                            <a
                                href="https://www.facebook.com/ieiricardopalma" {{-- Reemplazar por la URL real del colegio --}}
                            target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 bg-[#1877F2] text-white font-sans text-xs font-bold uppercase tracking-widest px-5 py-3 rounded-xs hover:bg-[#166FE5] transition-colors shadow-3xs"
                            >
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Ir a nuestra página de Facebook
                            </a>
                        </div>
                    </div>

                </div>

                <!-- COLUMNA DERECHA: El Feed Oficial de Facebook (5 Columnas en Desktop) -->
                <div class="lg:col-span-5 w-full flex justify-center lg:justify-end">

                    <!-- Contenedor con ancho delimitado para que Facebook no se rompa visualmente -->
                    <div class="bg-white p-4 rounded-xs border border-neutral-200 shadow-3xs w-full max-w-[1000px]">

                        <!-- Mini cabecera del feed con animación live -->
                        <div class="flex items-center justify-between mb-3 pb-2 border-b border-neutral-100">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="font-sans text-[11px] font-bold uppercase tracking-wider text-neutral-400">Publicaciones Recientes</span>
                            </div>
                        </div>

                        <!-- Widget Oficial incrustado (Usa el tope máximo de ancho permitido por Meta) -->
                        <div class="w-full flex justify-center overflow-hidden rounded-xs bg-neutral-50">
                            <div
                                class="fb-page"
                                data-href="https://www.facebook.com/ricardinosemprendeores"
                                data-tabs="timeline,events"
                                data-width="1000"
                                data-height="1000"
                                data-small-header="false"
                                data-adapt-container-width="true"
                                data-hide-cover="false"
                                data-show-facepile="false"
                            >
                                <blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/facebook" class="text-xs text-neutral-400 font-serif p-4 block">
                                        Cargando actualizaciones desde Facebook...
                                    </a>
                                </blockquote>
                            </div>
                        </div>

                        <!-- Detalle bicromático institucional inferior -->
                        <div class="mt-4 flex items-center justify-center">
                            <div class="h-[2px] w-12 flex">
                                <span class="h-full w-1/2 bg-ricardo-teal"></span>
                                <span class="h-full w-1/2 bg-ricardo-red"></span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>
@endsection
