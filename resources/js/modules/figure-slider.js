// resources/js/modules/figure-slider.js

export function initFigureSliders() {
    const sliders = document.querySelectorAll('[data-figure-slider]');

    sliders.forEach(slider => {
        const slides = slider.querySelectorAll('[data-figure-slide]');
        if (slides.length <= 1) return; // Si solo hay una imagen, no hace nada

        let currentIndex = 0;
        const slideDuration = 5000; // Cambiar cada 5 segundos

        setInterval(() => {
            const previousIndex = currentIndex;
            currentIndex = (currentIndex + 1) % slides.length;

            slides.forEach((slide, i) => {
                if (i === currentIndex) {
                    // 1. Limpiar estados anteriores y preparar el slide a la derecha instantáneamente
                    slide.classList.remove('transition-all', 'duration-700', 'ease-in-out', '-translate-x-full', 'translate-x-0', 'opacity-100', 'z-10', 'z-20');
                    slide.classList.add('transition-none', 'translate-x-full', 'opacity-0', 'z-20');

                    // Force Reflow para aplicar el posicionamiento inicial
                    void slide.offsetWidth;

                    // 2. Ejecutar la animación hacia el centro (REMOVIENDO las clases de la derecha)
                    slide.classList.remove('transition-none', 'translate-x-full', 'opacity-0');
                    slide.classList.add('transition-all', 'duration-700', 'ease-in-out', 'translate-x-0', 'opacity-100');
                } else if (i === previousIndex) {
                    // 3. Desplazar el slide saliente hacia la izquierda
                    slide.classList.remove('z-20', 'translate-x-0', 'opacity-100', 'translate-x-full');
                    slide.classList.add('transition-all', 'duration-700', 'ease-in-out', 'z-10', '-translate-x-full', 'opacity-0');
                } else {
                    // 4. Mantener los demás en espera oculta a la derecha
                    slide.classList.remove('transition-all', 'duration-700', 'ease-in-out', 'z-20', 'z-10', 'translate-x-0', '-translate-x-full', 'opacity-100');
                    slide.classList.add('translate-x-full', 'opacity-0');
                }
            });
        }, slideDuration);
    });
}
