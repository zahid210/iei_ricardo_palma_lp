/**
 * Animaciones fluidas de aparición (Fade-In Up) con opción de cascada (stagger)
 */
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

            // 1. Si es un contenedor con efecto cascada (ej: grillas, listas)
            if (element.hasAttribute('data-stagger')) {
                const children = element.children;
                Array.from(children).forEach((child, index) => {
                    setTimeout(() => {
                        // Limpieza preventiva de desplazamientos iniciales
                        child.classList.remove('translate-y-4', 'translate-y-6', 'translate-y-8', 'translate-y-12');
                        child.classList.add('opacity-100', 'translate-y-0');

                        // Si el elemento hijo tiene barras decorativas internas, las activamos en su turno
                        const innerBars = child.querySelectorAll('[data-bar], [data-bar-v]');
                        innerBars.forEach(bar => {
                            if (bar.hasAttribute('data-bar')) bar.classList.add('opacity-100', 'scale-x-100');
                            if (bar.hasAttribute('data-bar-v')) bar.classList.add('opacity-100', 'scale-y-100');
                        });
                    }, index * 100);
                });
                // 2. Si es una barra horizontal individual
            } else if (element.hasAttribute('data-bar')) {
                element.classList.add('opacity-100', 'scale-x-100');
                // 3. Si es una barra vertical individual
            } else if (element.hasAttribute('data-bar-v')) {
                element.classList.add('opacity-100', 'scale-y-100');
                // 4. Animación estándar para textos o imágenes individuales
            } else {
                // Removemos la clase de empuje original para que no compita con el translate-y-0
                element.classList.remove('translate-y-4', 'translate-y-6', 'translate-y-8', 'translate-y-12');
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
