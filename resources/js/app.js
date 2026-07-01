document.addEventListener('DOMContentLoaded', () => {
    // 1. EFECTO SCROLL EN EL HEADER (De app.blade.php)
    initHeaderScroll();

    // 2. REVELADO AL HACER SCROLL Y EFECTO CASCADA (Home, Nosotros y Docentes)
    initScrollReveal();

    // 3. CONTADORES ANIMADOS (Home)
    initStatCounters();

    // 4. CONTADOR DE CARACTERES GLOBAL (Contacto)
    initTextareaCounter();

    // 5. ESCALADO RESPONSIVO DE FACEBOOK (Noticias)
    initFacebookScaler();
});

/**
 * Reduce el header o le añade sombra profunda al hacer scroll
 */
function initHeaderScroll() {
    const header = document.querySelector('header'); // O la clase de tu navbar
    if (!header) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            header.classList.add('shadow-md', 'bg-white/95', 'backdrop-blur-xs');
            header.classList.remove('shadow-xs');
        } else {
            header.classList.remove('shadow-md', 'bg-white/95', 'backdrop-blur-xs');
            header.classList.add('shadow-xs');
        }
    });
}

/**
 * Animaciones fluidas de aparición (Fade-In Up) con opción de cascada (stagger)
 */
function initScrollReveal() {
    const revealElements = document.querySelectorAll('[data-reveal]');

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const element = entry.target;

            // Si es un contenedor de cascada (ej. la grilla de valores o directivos)
            if (element.hasAttribute('data-stagger')) {
                const children = element.children;
                Array.from(children).forEach((child, index) => {
                    setTimeout(() => {
                        child.classList.add('opacity-100', 'translate-y-0');
                    }, index * 100); // 100ms de retraso entre cada tarjeta
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
function initStatCounters() {
    const counters = document.querySelectorAll('[data-target-count]');

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const target = entry.target;
            const countTo = parseInt(target.getAttribute('data-target-count'), 10);
            let current = 0;
            const duration = 1500; // Duración total en milisegundos
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

/**
 * Maneja dinámicamente cualquier textarea con contador en el sitio
 */
function initTextareaCounter() {
    const textarea = document.getElementById('mensaje');
    const counter = document.getElementById('mensaje-counter');

    if (textarea && counter) {
        textarea.addEventListener('input', () => {
            counter.textContent = `${textarea.value.length}/255`;
        });
    }
}

/**
 * Ajusta el contenedor de Facebook al ancho disponible dinámicamente
 */
function initFacebookScaler() {
    const wrap = document.getElementById('fb-scale-wrap');
    const inner = document.getElementById('fb-scale-inner');
    if (!wrap || !inner) return;

    function estirar() {
        const w = wrap.clientWidth;
        if (w > 500) {
            const s = w / 500;
            inner.style.transform = `scale(${s})`;
            wrap.style.height = Math.ceil(inner.getBoundingClientRect().height) + 'px';
        } else {
            inner.style.transform = 'none';
            wrap.style.height = 'auto';
        }
    }

    const fbCheck = setInterval(() => {
        if (inner.querySelector('iframe')) {
            clearInterval(fbCheck);
            setTimeout(estirar, 500);
        }
    }, 200);

    setTimeout(() => clearInterval(fbCheck), 15000);
    window.addEventListener('resize', estirar);
}
