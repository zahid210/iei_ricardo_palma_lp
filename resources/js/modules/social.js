export function initFacebookScaler() {
    const wrap = document.getElementById('fb-scale-wrap');
    const inner = document.getElementById('fb-scale-inner');
    if (!wrap || !inner) return;

    let wrapObserver;
    let iframeObserver;

    function limpiarObservers() {
        if (wrapObserver) wrapObserver.disconnect();
        if (iframeObserver) iframeObserver.disconnect();
    }

    function estirar() {
        const w = wrap.clientWidth;
        if (w === 0) return;
        const s = w / 500;
        inner.style.transform = `scale(${s})`;
        const alturaReal = inner.offsetHeight * s;
        wrap.style.height = Math.ceil(alturaReal) + 'px';
    }

    wrapObserver = new ResizeObserver(() => { estirar(); });
    wrapObserver.observe(inner);
    window.addEventListener('resize', estirar);

    const fbCheck = setInterval(() => {
        const iframe = inner.querySelector('iframe');
        if (iframe) {
            clearInterval(fbCheck);
            clearTimeout(failsafeTimeout);
            estirar();
            iframeObserver = new ResizeObserver(() => { estirar(); });
            iframeObserver.observe(iframe);
        }
    }, 200);
    const failsafeTimeout = setTimeout(() => {
        clearInterval(fbCheck);
        limpiarObservers();
    }, 10000);
}
