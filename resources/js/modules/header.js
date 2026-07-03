export function initHeaderScroll() {
    const header = document.querySelector('header');
    if (!header) return;

    let ticking = false;

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                if (window.scrollY > 20) {
                    header.classList.add('shadow-md', 'bg-white/95', 'backdrop-blur-xs');
                    header.classList.remove('shadow-xs');
                } else {
                    header.classList.remove('shadow-md', 'bg-white/95', 'backdrop-blur-xs');
                    header.classList.add('shadow-xs');
                }
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });
}
