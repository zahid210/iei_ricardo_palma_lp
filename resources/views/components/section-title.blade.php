@props([
    'id' => null,
])

<div @if ($id) id="{{ $id }}" @endif class="scroll-mt-28 overflow-hidden">
    {{-- El Texto: Aparece hacia arriba de forma independiente --}}
    <h2 {{ $attributes->merge(['class' => 'font-mate text-xl uppercase leading-none text-neutral-800 sm:text-2xl lg:text-3xl opacity-0 translate-y-4 transition-all duration-700 ease-out']) }} data-reveal>
        {{ $slot }}
    </h2>

    {{-- Subrayado de dos líneas juntas: verde completa y roja más corta con corte en diagonal --}}
    <div class="section-underline-container">
        {{-- Línea verde delgada: de inicio a fin --}}
        <div class="section-underline-teal"></div>
        {{-- Línea roja delgada: más corta y junta con corte diagonal --}}
        <div class="section-underline-red"></div>
    </div>
</div>
