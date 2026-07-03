// resources/js/app.js

import { initHeaderScroll } from './modules/header.js';

document.addEventListener('DOMContentLoaded', () => {
    // Ejecutar lógica global
    initHeaderScroll();

    // ---- CARGA BAJO DEMANDA (Lazy Loading / Escalabilidad) ----

    // ¿Existe el slider del Hero?
    if (document.querySelector('[data-hero-slider]')) {
        import('./modules/hero-slider.js').then(module => {
            module.initHeroSlider();
        }).catch(err => console.warn('hero-slider:', err));
    }

    // ¿Existen sliders horizontales en las figuras?
    if (document.querySelector('[data-figure-slider]')) {
        import('./modules/figure-slider.js').then(module => {
            module.initFigureSliders();
        }).catch(err => console.warn('figure-slider:', err));
    }

    // ¿Hay elementos de animación en esta página?
    if (document.querySelector('[data-reveal]') || document.querySelector('[data-target-count]')) {
        import('./modules/animations.js').then(module => {
            module.initScrollReveal();
            module.initStatCounters();
        }).catch(err => console.warn('animations:', err));
    }

    // ¿Estamos en la página de contacto o existe una notificación (toast)?
    if (document.getElementById('mensaje') || document.getElementById('toast-success')) {
        import('./modules/forms.js').then(module => {
            // Inicializar contador si el formulario está en pantalla
            if (document.getElementById('mensaje')) {
                module.initTextareaCounter();
            }
            // Inicializar auto-cierre si el toast se renderizó
            if (document.getElementById('toast-success')) {
                module.initToastDismissal();
            }
        }).catch(err => console.warn('forms:', err));
    }

    // ¿Estamos en la sección de noticias con el widget de Facebook?
    if (document.getElementById('fb-scale-wrap')) {
        import('./modules/social.js').then(module => {
            module.initFacebookScaler();
        }).catch(err => console.warn('social:', err));
    }
});
