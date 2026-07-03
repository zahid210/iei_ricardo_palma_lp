const timers = [];

export function initFigureSliders() {
    const sliders = document.querySelectorAll('[data-figure-slider]');

    sliders.forEach(slider => {
        const slides = slider.querySelectorAll('[data-figure-slide]');
        if (slides.length <= 1) return;

        let currentIndex = 0;
        const slideDuration = 5000;

        const timerId = setInterval(() => {
            const previousIndex = currentIndex;
            currentIndex = (currentIndex + 1) % slides.length;

            slides.forEach((slide, i) => {
                if (i === currentIndex) {
                    slide.classList.remove('transition-all', 'duration-700', 'ease-in-out', '-translate-x-full', 'translate-x-0', 'opacity-100', 'z-10', 'z-20');
                    slide.classList.add('transition-none', 'translate-x-full', 'opacity-0', 'z-20');

                    void slide.offsetWidth;

                    slide.classList.remove('transition-none', 'translate-x-full', 'opacity-0');
                    slide.classList.add('transition-all', 'duration-700', 'ease-in-out', 'translate-x-0', 'opacity-100');
                } else if (i === previousIndex) {
                    slide.classList.remove('z-20', 'translate-x-0', 'opacity-100', 'translate-x-full');
                    slide.classList.add('transition-all', 'duration-700', 'ease-in-out', 'z-10', '-translate-x-full', 'opacity-0');
                } else {
                    slide.classList.remove('transition-all', 'duration-700', 'ease-in-out', 'z-20', 'z-10', 'translate-x-0', '-translate-x-full', 'opacity-100');
                    slide.classList.add('translate-x-full', 'opacity-0');
                }
            });
        }, slideDuration);

        timers.push(timerId);
    });
}

export function destroyFigureSliders() {
    timers.forEach(clearInterval);
    timers.length = 0;
}
