@extends('layouts.app')

@section('title', 'Galería | I.E.I. N° 31756 Ricardo Palma')

@section('content')
    <section class="bg-white pb-12 sm:pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10 sm:pt-14">
            <x-section-title>Galería Institucional</x-section-title>

            <p class="mx-auto mt-4 max-w-3xl text-center text-sm leading-relaxed text-neutral-700 sm:text-base opacity-0 translate-y-4 transition-all duration-500 ease-out" data-reveal>
                Momentos destacados de nuestra comunidad educativa.
            </p>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:gap-6" data-reveal data-stagger>
                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-500 ease-out">
                    <img src="{{ asset('images/galeria_1.jpg') }}"
                         alt="Reconocimiento académico de estudiante ricardino"
                         class="aspect-[4/3] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>

                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-500 ease-out">
                    <img src="{{ asset('images/galeria_2.jpg') }}"
                         alt="Equipo femenino campeón de futsal"
                         class="aspect-[4/3] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>

                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-500 ease-out">
                    <img src="{{ asset('images/galeria_3.jpg') }}"
                         alt="Equipo masculino campeón de futsal"
                         class="aspect-[4/3] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>

                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-500 ease-out">
                    <img src="{{ asset('images/galeria_4_2.jpg') }}"
                         alt="Campeon karate"
                         class="aspect-[4/3] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>

                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-500 ease-out">
                    <img src="{{ asset('images/galeria_5.jpg') }}"
                         alt="Campeon primer puesto"
                         class="aspect-[4/3] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>

                <article class="group overflow-hidden rounded-sm shadow-xs opacity-0 translate-y-8 transition-all duration-500 ease-out">
                    <img src="{{ asset('images/galeria_6.jpg') }}"
                         alt="Campeona primer puesta"
                         class="aspect-[4/3] w-full object-cover scale-100 transition-transform duration-500 ease-out group-hover:scale-105"
                         loading="lazy">
                </article>
            </div>
        </div>
    </section>
@endsection
