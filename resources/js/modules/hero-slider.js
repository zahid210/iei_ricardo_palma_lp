let timerId;
let slides;
let currentIndex = 0;
const slideDuration = 3000;

function setActiveSlide(index) {
    slides.forEach((slide, i) => {
        if (i === index) {
            slide.classList.remove('transition-all', 'duration-[6000ms]', 'transition-opacity', 'duration-[1500ms]', 'scale-105');
            slide.classList.add('transition-none', 'scale-100', 'z-10');

            void slide.offsetWidth;

            slide.classList.remove('transition-none', 'opacity-0', 'scale-100');
            slide.classList.add('transition-all', 'duration-[6000ms]', 'ease-out', 'opacity-100', 'scale-105');
        } else {
            slide.classList.remove('transition-all', 'duration-[6000ms]', 'opacity-100', 'z-10');
            slide.classList.add('transition-opacity', 'duration-[1500ms]', 'ease-in-out', 'opacity-0', 'z-0');
        }
    });
}

function startAutoPlay() {
    stopAutoPlay();
    timerId = setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        setActiveSlide(currentIndex);
    }, slideDuration);
}

function stopAutoPlay() {
    clearInterval(timerId);
    timerId = null;
}

export function initHeroSlider() {
    const slider = document.querySelector('[data-hero-slider]');
    if (!slider) return;

    slides = slider.querySelectorAll('[data-hero-slide]');
    if (slides.length <= 1) return;

    currentIndex = 0;
    setActiveSlide(0);
    startAutoPlay();
}

export function destroyHeroSlider() {
    stopAutoPlay();
}
