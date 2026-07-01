@props([
    'value' => null,
    'label',
    'count' => null, // Nuevo prop opcional para activar la animación
])

<article {{ $attributes->merge(['class' => 'text-center']) }}>
    <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center text-ricardo-teal sm:h-12 sm:w-12">
        {{ $icon }}
    </div>

    <strong
        class="block font-literata text-4xl font-normal leading-none text-ricardo-red sm:text-5xl"
        @if($count) data-target-count="{{ $count }}" @endif
    >
        {{ $count ? '0+' : $value }}
    </strong>

    <p class="mt-1 font-mate text-sm uppercase leading-tight text-neutral-700 sm:text-base">
        {{ $label }}
    </p>
</article>
