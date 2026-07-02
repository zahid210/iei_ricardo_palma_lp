// resources/js/modules/hero-slider.js

export function initHeroSlider() {
    const slider = document.querySelector('[data-hero-slider]');
    if (!slider) return;

    const slides = slider.querySelectorAll('[data-hero-slide]');
    if (slides.length <= 1) return;

    let currentIndex = 0;
    const slideDuration = 3000; // 6 segundos por imagen

    const setActiveSlide = (index) => {
        slides.forEach((slide, i) => {
            if (i === index) {
                // 1. Resetear silenciosamente la escala (instantáneo, sin transición)
                slide.classList.remove('transition-all', 'duration-[6000ms]', 'transition-opacity', 'duration-[1500ms]', 'scale-105');
                slide.classList.add('transition-none', 'scale-100', 'z-10');

                // 2. Forzar un "reflow" para que el navegador aplique el scale-100 inmediatamente
                void slide.offsetWidth;

                // 3. Aplicar las clases de animación (Fade In + Zoom In)
                slide.classList.remove('transition-none', 'opacity-0', 'scale-100');
                slide.classList.add('transition-all', 'duration-[6000ms]', 'ease-out', 'opacity-100', 'scale-105');
            } else {
                // 4. Salida: Fade out rápido (1.5s), pero MANTENIENDO la escala para evitar el rebote
                slide.classList.remove('transition-all', 'duration-[6000ms]', 'opacity-100', 'z-10');
                slide.classList.add('transition-opacity', 'duration-[1500ms]', 'ease-in-out', 'opacity-0', 'z-0');
                // NOTA: No quitamos 'scale-105' aquí, la imagen se desvanecerá estando ampliada.
            }
        });
    };

    setActiveSlide(currentIndex);

    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        setActiveSlide(currentIndex);
    }, slideDuration);
}
