/**
 * Reduce el header o le añade sombra profunda al hacer scroll
 */
export function initHeaderScroll() {
    const header = document.querySelector('header');
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
