/**
 * Animaciones fluidas de aparición (Fade-In Up) con opción de cascada (stagger)
 */
export function initScrollReveal() {
    const revealElements = document.querySelectorAll('[data-reveal]');
    if (revealElements.length === 0) return;

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const element = entry.target;

            if (element.hasAttribute('data-stagger')) {
                const children = element.children;
                Array.from(children).forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add('opacity-100', 'translate-y-0');
                    }, index * 100);
                });
            } else {
                element.classList.add('opacity-100', 'translate-y-0');
            }

            observer.unobserve(element);
        });
    }, { threshold: 0.15 });

    revealElements.forEach(el => observer.observe(el));
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
