@props([
    'id' => null,
])

<div @if ($id) id="{{ $id }}" @endif class="scroll-mt-28 overflow-hidden">
    {{-- El Texto: Aparece hacia arriba de forma independiente --}}
    <h2 {{ $attributes->merge(['class' => 'font-mate text-xl uppercase leading-none text-neutral-800 sm:text-2xl lg:text-3xl opacity-0 translate-y-4 transition-all duration-700 ease-out']) }} data-reveal>
        {{ $slot }}
    </h2>

    {{-- La Barra Bicolor: Efecto de crecimiento/desplazamiento hacia la derecha --}}
    {{-- origin-left asegura que se expanda de izquierda a derecha --}}
    <div class="mt-5 h-3 w-full max-w-none opacity-0 scale-x-0 origin-left transition-all duration-1000 ease-out" data-reveal data-bar>
        <div class="h-1.5 bg-ricardo-teal"></div>
        <div class="h-1.5 bg-ricardo-red"></div>
    </div>
</div>
