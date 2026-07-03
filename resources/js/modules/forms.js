export function initTextareaCounter(textareaId = 'mensaje', counterId = 'mensaje-counter', threshold = 200) {
    const textarea = document.getElementById(textareaId);
    const counter = document.getElementById(counterId);

    if (textarea && counter) {
        textarea.addEventListener('input', () => {
            const maxLength = parseInt(textarea.getAttribute('maxlength'), 10) || 255;
            const currentLength = textarea.value.length;
            counter.textContent = `${currentLength}/${maxLength}`;

            if (currentLength >= threshold) {
                counter.classList.remove('text-neutral-400');
                counter.classList.add('text-amber-600');
            } else {
                counter.classList.remove('text-amber-600');
                counter.classList.add('text-neutral-400');
            }
        });
    }
}

// Nueva función para auto-ocultar los toasts
export function initToastDismissal(toastId = 'toast-success', duration = 4000) {
    const toast = document.getElementById(toastId);

    if (toast) {
        setTimeout(() => {
            // 1. Iniciar animación de desvanecimiento
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-4');

            // 2. Eliminar completamente del DOM después de la transición (500ms)
            setTimeout(() => {
                toast.remove();
            }, 500);
        }, duration);
    }
}
