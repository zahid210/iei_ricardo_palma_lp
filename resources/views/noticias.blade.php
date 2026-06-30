@extends('layouts.app')

@section('title', 'Noticias | I.E.I. 31756 Ricardo Palma')

@section('content')
    {{-- Facebook SDK (carga diferida y asíncrona) --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v21.0">
    </script>

    {{-- ENCABEZADO --}}
    <section class="bg-white pt-8 pb-6 sm:pt-12 sm:pb-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-title>Últimas Noticias</x-section-title>
            <p class="mt-4 max-w-2xl font-serif text-sm leading-relaxed text-neutral-600 sm:text-base">
                Mantente al tanto de las actividades, eventos y comunicados oficiales de
                la I.E.I. 31756 Ricardo Palma. Toda nuestra actividad institucional se
                comparte a través de nuestra página de Facebook.
            </p>
        </div>
    </section>

    {{-- CUERPO --}}
    <section class="border-t border-neutral-200 bg-[#F5F5F5] py-10 sm:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                {{-- COLUMNA PRINCIPAL: Feed de Facebook (ancho completo) --}}
                <div class="lg:col-span-2">
                    <div class="rounded-lg border border-neutral-200 bg-white shadow-sm">
                        {{-- Cabecera del widget --}}
                        <div class="flex items-center justify-between border-b border-neutral-100 px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#1877F2]">
                                    <svg class="h-4 w-4 fill-current text-white" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-system text-sm font-bold text-neutral-800">
                                        I.E.I. 31756 Ricardo Palma
                                    </h3>
                                    <div class="flex items-center gap-1.5">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        <span class="font-system text-[11px] text-neutral-400">En vivo</span>
                                    </div>
                                </div>
                            </div>
                            <a href="https://www.facebook.com/ricardinosemprendeores" target="_blank" rel="noopener noreferrer"
                               class="font-system text-xs font-bold uppercase tracking-wider text-[#1877F2] transition-colors hover:text-[#166FE5]">
                                Seguir
                            </a>
                        </div>

                        {{-- Widget Page Plugin con hack scale --}}
                        <div class="bg-neutral-50 p-4 sm:p-6">
                            <div id="fb-scale-wrap" class="relative w-full">
                                <div id="fb-scale-inner" style="width:500px; margin:0 auto; transform-origin:top center">
                                    <div class="fb-page"
                                         data-href="https://www.facebook.com/ricardinosemprendeores"
                                         data-tabs="timeline,events"
                                         data-width="500"
                                         data-height="800"
                                         data-small-header="false"
                                         data-adapt-container-width="true"
                                         data-hide-cover="false"
                                         data-show-facepile="true"
                                         data-lazy="true">
                                        <blockquote cite="https://www.facebook.com/ricardinosemprendeores" class="fb-xfbml-parse-ignore">
                                            <a href="https://www.facebook.com/ricardinosemprendeores"
                                               class="block p-4 text-center font-serif text-xs text-neutral-400">
                                                Cargando publicaciones desde Facebook…
                                            </a>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Script: estira el feed al ancho del contenedor vía scale --}}
                        <script>
                            (function() {
                                var wrap = document.getElementById('fb-scale-wrap');
                                var inner = document.getElementById('fb-scale-inner');
                                if (!wrap || !inner) return;

                                function estirar() {
                                    var w = wrap.clientWidth;
                                    if (w > 500) {
                                        var s = w / 500;
                                        inner.style.transform = 'scale(' + s + ')';
                                        wrap.style.height = Math.ceil(inner.getBoundingClientRect().height) + 'px';
                                    } else {
                                        inner.style.transform = 'none';
                                        wrap.style.height = 'auto';
                                    }
                                }

                                var fbCheck = setInterval(function() {
                                    if (inner.querySelector('iframe')) {
                                        clearInterval(fbCheck);
                                        setTimeout(estirar, 500);
                                    }
                                }, 200);
                                setTimeout(function() { clearInterval(fbCheck); }, 15000);
                                window.addEventListener('resize', estirar);
                            })();
                        </script>
                    </div>
                </div>

                {{-- SIDEBAR --}}
                <div class="space-y-6">

                    {{-- Información de la página --}}
                    <div class="rounded-lg border border-neutral-200 bg-white p-6 text-center shadow-sm">
                        <img src="{{ asset('images/logo_color.png') }}" alt="Logo I.E.I. Ricardo Palma"
                             class="mx-auto mb-3 h-14 w-auto">
                        <h4 class="font-mate text-sm font-bold text-neutral-800">
                            I.E.I. 31756 Ricardo Palma
                        </h4>
                        <p class="mt-0.5 font-serif text-xs text-neutral-500">
                            Barrio La Esperanza, Chaupimarca
                        </p>

                        <div class="mt-4 flex justify-center gap-6 border-t border-neutral-100 pt-4">
                            <div class="text-center">
                                <p class="font-system text-lg font-bold text-ricardo-teal">1K+</p>
                                <p class="font-system text-[10px] uppercase tracking-wider text-neutral-400">
                                    Seguidores
                                </p>
                            </div>
                            <div class="text-center">
                                <p class="font-system text-lg font-bold text-ricardo-teal">500+</p>
                                <p class="font-system text-[10px] uppercase tracking-wider text-neutral-400">
                                    Publicaciones
                                </p>
                            </div>
                        </div>

                        <a href="https://www.facebook.com/ricardinosemprendeores" target="_blank" rel="noopener noreferrer"
                           class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#1877F2] px-5 py-2.5 font-system text-xs font-bold uppercase tracking-wider text-white shadow-sm transition-colors hover:bg-[#166FE5]">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Visitar página
                        </a>
                    </div>

                    {{-- Comunicación oficial --}}
                    <div class="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm">
                        <h4 class="font-serif text-sm font-bold text-neutral-800">
                            <span class="mr-2 inline-block h-4 w-1 rounded-full bg-ricardo-teal align-middle"></span>
                            Comunicación oficial
                        </h4>
                        <p class="mt-2 font-serif text-xs leading-relaxed text-neutral-600">
                            Todos los comunicados y anuncios importantes de la institución
                            se publican en nuestra página de Facebook. Síguenos para no
                            perderte ninguna novedad.
                        </p>
                    </div>

                    {{-- Fallback para bloqueador de anuncios --}}
                    <div class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100">
                                <svg class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-system text-sm font-bold text-neutral-800">
                                    ¿No ves las noticias?
                                </h4>
                                <p class="mt-1 font-serif text-xs leading-relaxed text-neutral-500">
                                    Si usas un bloqueador de anuncios, el widget de Facebook
                                    podría no cargar. Accede directamente a nuestra página
                                    para ver todas las publicaciones.
                                </p>
                                <a href="https://www.facebook.com/ricardinosemprendeores"
                                   target="_blank" rel="noopener noreferrer"
                                   class="mt-2 inline-block font-system text-xs font-bold text-[#1877F2] transition-colors hover:text-[#166FE5]">
                                    Ir a Facebook &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Compartir --}}
                    <div class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <span class="font-system text-xs font-bold uppercase tracking-wider text-neutral-500">
                                Compartir
                            </span>
                            <div class="fb-share-button"
                                 data-href="https://www.facebook.com/ricardinosemprendeores"
                                 data-layout="button"
                                 data-size="large">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
