/**
 * Maneja dinámicamente cualquier textarea con contador en el sitio
 */
export function initTextareaCounter(textareaId = 'mensaje', counterId = 'mensaje-counter') {
    const textarea = document.getElementById(textareaId);
    const counter = document.getElementById(counterId);

    if (textarea && counter) {
        textarea.addEventListener('input', () => {
            const maxLength = textarea.getAttribute('maxlength') || 255;
            counter.textContent = `${textarea.value.length}/${maxLength}`;
        });
    }
}
