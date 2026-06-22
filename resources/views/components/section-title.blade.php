@props([
    'id' => null,
])

<div @if ($id) id="{{ $id }}" @endif class="scroll-mt-28">
    <h2 {{ $attributes->merge(['class' => 'font-mate text-xl uppercase leading-none text-neutral-800 sm:text-2xl lg:text-3xl']) }}>
        {{ $slot }}
    </h2>
    <div class="mt-3 h-3 w-full max-w-none">
        <div class="h-1.5 bg-ricardo-teal"></div>
        <div class="h-1.5 bg-ricardo-red"></div>
    </div>
</div>
