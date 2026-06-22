@props([
    'image',
    'label',
])

<article class="flex justify-center">
    <img
        src="{{ asset($image) }}"
        alt="{{ $label }}"
        class="h-auto w-40 transition duration-300 hover:scale-105 sm:w-48 lg:w-56 xl:w-64"
        loading="lazy"
    >
</article>
