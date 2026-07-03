let timerId;
let slides;
let currentIndex = 0;
const slideDuration = 5000;

function setActiveSlide(index) {
    slides.forEach((slide, i) => {
        if (i === index) {
            slide.style.transition = 'none';
            slide.classList.remove('opacity-100', 'scale-105');
            slide.classList.add('scale-100', 'z-10');

            void slide.offsetWidth;

            slide.style.transition = 'opacity 6000ms ease-out, transform 6000ms ease-out';
            slide.classList.remove('opacity-0', 'scale-100');
            slide.classList.add('opacity-100', 'scale-105');
        } else {
            slide.style.transition = 'opacity 1500ms ease-in-out';
            slide.classList.remove('opacity-100', 'z-10');
            slide.classList.add('opacity-0', 'z-0');
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

function togglePause(slider) {
    const isPaused = slider.getAttribute('data-paused') === 'true';
    const btn = slider.querySelector('[data-hero-pause]');
    const icon = btn?.querySelector('[data-hero-pause-icon]');

    if (isPaused) {
        startAutoPlay();
        if (icon) {
            icon.innerHTML = '<rect x="6" y="4" width="4" height="16" rx="1"/><rect x="14" y="4" width="4" height="16" rx="1"/>';
        }
        btn?.setAttribute('aria-label', 'Pausar carrusel');
        slider.removeAttribute('data-paused');
    } else {
        stopAutoPlay();
        if (icon) {
            icon.innerHTML = '<polygon points="5,4 19,12 5,20" fill="currentColor"/>';
        }
        btn?.setAttribute('aria-label', 'Reanudar carrusel');
        slider.setAttribute('data-paused', 'true');
    }
}

export function initHeroSlider() {
    const slider = document.querySelector('[data-hero-slider]');
    if (!slider) return;

    slides = slider.querySelectorAll('[data-hero-slide]');
    if (slides.length <= 1) return;

    currentIndex = 0;
    setActiveSlide(0);
    startAutoPlay();

    const pauseBtn = slider.querySelector('[data-hero-pause]');
    if (pauseBtn) {
        pauseBtn.addEventListener('click', () => togglePause(slider));
    }
}

export function destroyHeroSlider() {
    stopAutoPlay();
}
