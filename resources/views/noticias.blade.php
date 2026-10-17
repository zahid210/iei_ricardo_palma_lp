@extends('layouts.app')

@section('title', 'Noticias | I.E.I. N° 31756 Ricardo Palma')
@section('meta_description', 'Entérate de las últimas novedades, eventos institucionales, comunicados de admisión y actividades escolares de nuestra comunidad ricardina en Pasco.')
@section('content')
    {{-- CUERPO DE NOTICIAS --}}
    <section class="py-10 sm:py-14 bg-neutral-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 items-start">

                {{-- COLUMNA PRINCIPAL: Feed de Facebook (Estructura limpia original - Cero animaciones/capas GPU) --}}
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-sm border border-neutral-100/60 rounded-xs">

                        {{-- Cabecera del widget --}}
                        <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center bg-[#1877F2]">
                                    <svg class="h-4 w-4 fill-current text-white" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-system text-sm font-bold text-neutral-800">
                                        I.E.I. 31756 Ricardo Palma
                                    </h3>
                                </div>
                            </div>
                            <a href="https://www.facebook.com/ricardinosemprendeores" target="_blank"
                               rel="noopener noreferrer"
                               class="font-system text-xs font-bold uppercase tracking-wider text-[#1877F2] transition-colors hover:text-[#166FE5]">
                                Seguir
                            </a>
                        </div>

                        {{-- Publicaciones reales de Facebook (traídas por nuestro servidor) --}}
                        <div class="bg-neutral-50 p-4 sm:p-6">
                            @if(!empty($facebookPosts))
                                <div class="space-y-4">
                                    @foreach($facebookPosts as $post)
                                        <article class="bg-white border border-neutral-100/60 rounded-xs p-5 shadow-xs">
                                            <div class="mb-3 flex items-center gap-2">
                                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#1877F2]">
                                                    <svg class="h-3.5 w-3.5 fill-current text-white" viewBox="0 0 24 24">
                                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                    </svg>
                                                </span>
                                                <div>
                                                    <p class="font-system text-xs font-bold leading-tight text-neutral-800">
                                                        I.E.I. 31756 Ricardo Palma
                                                    </p>
                                                    @if($post['date'])
                                                        <p class="font-serif text-[11px] text-neutral-400">{{ $post['date'] }}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($post['message'])
                                                <p class="whitespace-pre-line font-serif text-sm leading-relaxed text-neutral-700">{{ $post['message'] }}</p>
                                            @endif

                                            @if($post['image'])
                                                <img src="{{ $post['image'] }}"
                                                     alt="Publicación de la I.E.I. Ricardo Palma"
                                                     loading="lazy"
                                                     class="mt-3 w-full rounded-xs border border-neutral-100 object-cover">
                                            @endif

                                            @if($post['permalink_url'])
                                                <a href="{{ $post['permalink_url'] }}" target="_blank" rel="noopener noreferrer"
                                                   class="mt-3 inline-block font-system text-xs font-bold text-[#1877F2] transition-colors hover:text-[#166FE5]">
                                                    Ver publicación en Facebook &rarr;
                                                </a>
                                            @endif
                                        </article>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center gap-3 py-10 text-center">
                                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-[#1877F2]">
                                        <svg class="h-5 w-5 fill-current text-white" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </span>
                                    <p class="max-w-sm font-serif text-sm leading-relaxed text-neutral-500">
                                        Síguenos en nuestra página oficial de Facebook para no perderte ningún
                                        comunicado ni actividad.
                                    </p>
                                    <a href="https://www.facebook.com/ricardinosemprendeores" target="_blank"
                                       rel="noopener noreferrer"
                                       class="inline-flex items-center gap-2 rounded-sm bg-[#1877F2] px-5 py-2.5 font-system text-xs font-bold uppercase tracking-wider text-white shadow-xs transition-colors hover:bg-[#166FE5]">
                                        Ver publicaciones en Facebook
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- SIDEBAR: Animaciones estables --}}
                <div class="space-y-6" data-reveal data-stagger>

                    {{-- Tarjeta 1: Información de la página --}}
                    <div class="bg-white p-6 text-center shadow-sm border border-neutral-100/60 rounded-xs opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <img src="{{ asset('images/logo_color.png') }}" alt="Logo I.E.I. Ricardo Palma"
                             class="mx-auto mb-3 h-14 w-auto object-contain">
                        <h4 class="font-mate text-sm font-bold text-neutral-800">
                            I.E.I. 31756 Ricardo Palma
                        </h4>
                        <p class="mt-0.5 font-serif text-xs text-neutral-500">
                            Barrio La Esperanza, Chaupimarca
                        </p>

                        <div class="mt-4 flex justify-center gap-6 pt-4 border-t border-neutral-100">
                            <div class="text-center w-1/2">
                                <p class="font-system text-xl font-extrabold text-ricardo-teal leading-none"
                                   data-target-count="1000">0+</p>
                                <p class="font-system text-[10px] uppercase tracking-wider text-neutral-400 mt-1.5 font-medium">
                                    Seguidores
                                </p>
                            </div>
                            <div class="text-center w-1/2 border-l border-neutral-100">
                                <p class="font-system text-xl font-extrabold text-ricardo-teal leading-none"
                                   data-target-count="500">0+</p>
                                <p class="font-system text-[10px] uppercase tracking-wider text-neutral-400 mt-1.5 font-medium">
                                    Publicaciones
                                </p>
                            </div>
                        </div>

                        <a href="https://www.facebook.com/ricardinosemprendeores" target="_blank"
                           rel="noopener noreferrer"
                           class="mt-5 inline-flex w-full items-center justify-center gap-2 bg-[#1877F2] px-5 py-2.5 font-system text-xs font-bold uppercase tracking-wider text-white transition-colors hover:bg-[#166FE5] shadow-xs rounded-sm">
                            <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Visitar página
                        </a>
                    </div>

                    {{-- Tarjeta 2: Comunicación oficial --}}
                    <div class="bg-white p-6 shadow-sm border border-neutral-100/60 rounded-xs opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <h4 class="font-serif text-sm font-bold text-neutral-800 flex items-center">
                            <span class="mr-2 inline-block h-4 w-[3px] bg-ricardo-teal rounded-full"></span>
                            Comunicación oficial
                        </h4>
                        <p class="mt-2 font-serif text-xs leading-relaxed text-neutral-600 text-justify">
                            Todos los comunicados, avisos de reuniones y anuncios importantes de la institución
                            se canalizan formalmente a través de nuestra página de Facebook. Síguenos para estar al día.
                        </p>
                    </div>

                    {{-- Tarjeta 3: Actualización automática --}}
                    <div class="bg-white p-5 shadow-sm border border-neutral-100/60 rounded-xs opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <div class="flex items-start gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center bg-ricardo-teal/10 rounded-sm">
                                <svg class="h-4 w-4 text-ricardo-teal" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 0 0 4.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 0 1-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-system text-xs font-bold text-neutral-800 uppercase tracking-wide">
                                    Actualizado automáticamente
                                </h4>
                                <p class="mt-1 font-serif text-xs leading-relaxed text-neutral-500 text-justify">
                                    Esta sección muestra las publicaciones más recientes de nuestra página de
                                    Facebook y se actualiza sola.
                                </p>
                                <a href="https://www.facebook.com/ricardinosemprendeores"
                                   target="_blank" rel="noopener noreferrer"
                                   class="mt-2 inline-block font-system text-xs font-bold text-[#1877F2] transition-colors hover:text-[#166FE5]">
                                    Ir a Facebook &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Tarjeta 4: Compartir --}}
                    <div class="bg-white p-5 shadow-sm border border-neutral-100/60 rounded-xs opacity-0 translate-y-6 transition-all duration-500 ease-out">
                        <div class="flex items-center justify-between">
                            <span class="font-system text-xs font-bold uppercase tracking-wider text-neutral-500">
                                Compartir
                            </span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-sm bg-[#1877F2] px-4 py-2 font-system text-xs font-bold uppercase tracking-wider text-white shadow-xs transition-colors hover:bg-[#166FE5]">
                                <svg class="h-3.5 w-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
