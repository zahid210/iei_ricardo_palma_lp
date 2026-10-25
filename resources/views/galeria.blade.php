@extends('layouts.app')

@section('title', 'Galería | I.E.I. N° 31756 Ricardo Palma')
@section('meta_description', 'Explora los logros más destacados de nuestra institución.')

@section('content')
    <section class="bg-white pb-12 sm:pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14">
            <x-section-title>Galería Institucional</x-section-title>

            <p class="mx-auto mt-4 max-w-3xl text-center text-[15px] leading-relaxed text-neutral-700 sm:text-[17px] opacity-0 translate-y-4 transition-all duration-500 ease-out" data-reveal>
                Momentos destacados de nuestra comunidad educativa.
            </p>

            <div class="mt-10 relative">

                {{-- GRID DINÁMICO CON TU DISEÑO BENTO BOX --}}
                <div class="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6" data-reveal data-stagger>
                    @foreach($imagenes as $item)
                        <article class="break-inside-avoid group relative overflow-hidden rounded-xl shadow-lg opacity-0 translate-y-8 transition-all duration-700 ease-out">
                            {{-- La imagen se ajusta al ancho del contenedor y mantiene su altura original --}}
                            <img src="{{ $item->url }}"
                                 alt="{{ $item->titulo }}"
                                 class="w-full h-auto block transition-transform duration-700 ease-in-out group-hover:scale-105"
                                 loading="lazy"
                                 onerror="this.src='{{ asset('images/logo_color.png') }}';">

                            {{-- Overlay sutil para elegancia --}}
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-500"></div>
                        </article>
                    @endforeach
                </div>

                {{-- DOTS DINÁMICOS (PAGINACIÓN) --}}
                @if($imagenes->hasPages())
                    <div class="mt-12 flex items-center justify-center gap-3">
                        @foreach(range(1, $imagenes->lastPage()) as $i)
                            <a href="{{ $imagenes->url($i) }}"
                               class="h-3 w-3 rounded-full transition-colors {{ $imagenes->currentPage() === $i ? 'bg-ricardo-teal' : 'border border-ricardo-teal bg-transparent hover:bg-ricardo-teal/30' }}"
                               aria-label="Página {{ $i }}">
                            </a>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </section>
@endsection
