// resources/js/app.js

// Importación estática: Se carga siempre porque el header está en app.blade.php
import { initHeaderScroll } from './modules/header.js';

document.addEventListener('DOMContentLoaded', () => {
    // Ejecutar lógica global
    initHeaderScroll();

    // ---- CARGA BAJO DEMANDA (Lazy Loading / Escalabilidad) ----

    // ¿Hay elementos de animación en esta página?
    if (document.querySelector('[data-reveal]') || document.querySelector('[data-target-count]')) {
        import('./modules/animations.js').then(module => {
            module.initScrollReveal();
            module.initStatCounters();
        });
    }

    // ¿Estamos en la página de contacto o hay un formulario con ese ID?
    if (document.getElementById('mensaje')) {
        import('./modules/forms.js').then(module => {
            module.initTextareaCounter();
        });
    }

    // ¿Estamos en la sección de noticias con el widget de Facebook?
    if (document.getElementById('fb-scale-wrap')) {
        import('./modules/social.js').then(module => {
            module.initFacebookScaler();
        });
    }
});
