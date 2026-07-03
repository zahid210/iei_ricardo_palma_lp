/**
 * Animaciones fluidas de aparición (Fade-In Up) con opción de cascada (stagger)
 */
/**
 * Animaciones fluidas de aparición (Fade-In Up) con opción de cascada (stagger)
 */
export function initScrollReveal() {
    const allReveal = document.querySelectorAll('[data-reveal]');
    if (allReveal.length === 0) return;

    const staggerContainers = document.querySelectorAll('[data-reveal][data-stagger]');
    const filtered = Array.from(allReveal).filter(el => {
        if (el.hasAttribute('data-stagger')) return true;
        return !el.closest('[data-reveal][data-stagger]');
    });

    if (filtered.length === 0) return;

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const element = entry.target;

            if (element.hasAttribute('data-stagger')) {
                const children = element.children;
                Array.from(children).forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.remove('translate-y-4', 'translate-y-6', 'translate-y-8', 'translate-y-12');
                        child.classList.add('opacity-100', 'translate-y-0');

                        const innerBars = child.querySelectorAll('[data-bar], [data-bar-v]');
                        innerBars.forEach(bar => {
                            if (bar.hasAttribute('data-bar')) bar.classList.add('opacity-100', 'scale-x-100');
                            if (bar.hasAttribute('data-bar-v')) bar.classList.add('opacity-100', 'scale-y-100');
                        });
                    }, index * 100);
                });
            } else if (element.hasAttribute('data-bar')) {
                element.classList.add('opacity-100', 'scale-x-100');
            } else if (element.hasAttribute('data-bar-v')) {
                element.classList.add('opacity-100', 'scale-y-100');
            } else {
                element.classList.remove('translate-y-4', 'translate-y-6', 'translate-y-8', 'translate-y-12');
                element.classList.add('opacity-100', 'translate-y-0');
            }

            observer.unobserve(element);
        });
    }, { threshold: 0.15 });

    filtered.forEach(el => observer.observe(el));
}

/**
 * Anima los números de estadísticas desde 0 hasta su valor objetivo
 */
export function initStatCounters() {
    const counters = document.querySelectorAll('[data-target-count]');
    if (counters.length === 0) return;

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const target = entry.target;
            const countTo = parseInt(target.getAttribute('data-target-count'), 10);
            let current = 0;
            const duration = 1500;
            const stepTime = Math.max(Math.floor(duration / countTo), 15);

            const timer = setInterval(() => {
                current += Math.ceil(countTo / (duration / stepTime));
                if (current >= countTo) {
                    target.textContent = countTo + '+';
                    clearInterval(timer);
                } else {
                    target.textContent = current + '+';
                }
            }, stepTime);

            observer.unobserve(target);
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
}
