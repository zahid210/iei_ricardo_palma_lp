export function initTextareaCounter(textareaId = 'mensaje', counterId = 'mensaje-counter') {
    const textarea = document.getElementById(textareaId);
    const counter = document.getElementById(counterId);

    if (textarea && counter) {
        textarea.addEventListener('input', () => {
            const maxLength = parseInt(textarea.getAttribute('maxlength'), 10) || 255;
            const currentLength = textarea.value.length;
            counter.textContent = `${currentLength}/${maxLength}`;

            if (currentLength >= 200) {
                counter.classList.remove('text-neutral-400');
                counter.classList.add('text-amber-600');
            } else {
                counter.classList.remove('text-amber-600');
                counter.classList.add('text-neutral-400');
            }
        });
    }
}
