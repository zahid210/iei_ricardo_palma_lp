/**
 * Ajusta el contenedor de Facebook al ancho disponible dinámicamente
 */
export function initFacebookScaler() {
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
