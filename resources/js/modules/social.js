export function initFacebookScaler() {
    const wrap = document.getElementById('fb-scale-wrap');
    const inner = document.getElementById('fb-scale-inner');
    if (!wrap || !inner) return;

    function estirar() {
        const w = wrap.clientWidth;
        if (w === 0) return;
        const s = w / 500;
        inner.style.transform = `scale(${s})`;
        const alturaReal = inner.offsetHeight * s;
        wrap.style.height = Math.ceil(alturaReal) + 'px';
    }

    const resizeObserver = new ResizeObserver(() => { estirar(); });
    resizeObserver.observe(inner);
    window.addEventListener('resize', estirar);

    const fbCheck = setInterval(() => {
        const iframe = inner.querySelector('iframe');
        if (iframe) {
            clearInterval(fbCheck);
            estirar();
            resizeObserver.observe(iframe);
        }
    }, 200);
    setTimeout(() => clearInterval(fbCheck), 10000);
}
