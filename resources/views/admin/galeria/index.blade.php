@extends('admin.layout')

@section('title', 'Gestión de Galería')

@push('styles')
<style>
    .galeria-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
        margin-top: 24px;
    }

    .galeria-card {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: border-color 0.15s;
    }

    .galeria-card:hover {
        border-color: #cbd5e1;
    }

    .galeria-thumb {
        width: 100%;
        height: 150px;
        object-fit: cover;
        background-color: #f1f5f9;
        border-bottom: 1px solid var(--border-color);
    }

    .galeria-info {
        padding: 12px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .galeria-title {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
        line-height: 1.35;
    }

    .galeria-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
    }

    .upload-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        padding: 24px;
        margin-bottom: 24px;
    }

    .form-control {
        width: 100%;
        padding: 9px 12px;
        font-family: inherit;
        font-size: 13.5px;
        border: 1px solid var(--border-color);
        background: #fafafa;
        color: var(--text-primary);
        outline: none;
    }

    .form-control:focus {
        border-color: var(--brand-green);
        background: #ffffff;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-primary);
    }

    /* ÁREA DROPZONE */
    .dropzone-box {
        border: 2px dashed var(--border-color);
        background: #f8fafc;
        padding: 22px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.15s, background-color 0.15s;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .dropzone-box:hover,
    .dropzone-box.dragover {
        border-color: var(--brand-green);
        background: #f0fdf4;
    }

    .dropzone-icon {
        width: 32px;
        height: 32px;
        color: var(--brand-green);
    }

    .dropzone-text {
        font-size: 13px;
        color: var(--text-primary);
        font-weight: 500;
    }

    .dropzone-subtext {
        font-size: 11.5px;
        color: var(--text-secondary);
    }

    .file-preview-strip {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
        padding: 8px 12px;
        background: #f1f5f9;
        border: 1px solid var(--border-color);
    }

    .file-preview-strip img {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }

    .btn-delete-icon {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--danger-btn);
        padding: 6px 10px;
        font-size: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-delete-icon:hover {
        background: #fee2e2;
        border-color: #fca5a5;
    }

    .empty-gallery {
        background: var(--surface-color);
        border: 1px dashed var(--border-color);
        padding: 40px;
        text-align: center;
        color: var(--text-secondary);
        font-size: 14px;
    }
    /* MODAL FLOTANTE EN LA MISMA PANTALLA */
    .admin-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(17, 24, 39, 0.65);
        backdrop-filter: blur(2px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .admin-modal-backdrop.active {
        opacity: 1;
        visibility: visible;
    }

    .admin-modal {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
    }

    .modal-header h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .btn-close-modal {
        background: transparent;
        border: none;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        color: var(--text-secondary);
        padding: 4px;
    }

    .btn-close-modal:hover {
        color: var(--text-primary);
    }

    .modal-body {
        padding: 24px;
        overflow-y: auto;
    }

    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        background: #fafbfc;
    }

    /* LIGHTBOX FLOTANTE PARA EXPANDIR LA IMAGEN A TAMAÑO COMPLETO */
    .lightbox-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.88);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        z-index: 2000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
        cursor: zoom-out;
    }

    .lightbox-backdrop.active {
        opacity: 1;
        visibility: visible;
    }

    .lightbox-content {
        max-width: 90vw;
        max-height: 88vh;
        object-fit: contain;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        border: 2px solid rgba(255, 255, 255, 0.2);
        cursor: default;
    }

    .lightbox-close-btn {
        position: absolute;
        top: 16px;
        right: 20px;
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.3);
        width: 36px;
        height: 36px;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.15s;
    }

    .lightbox-close-btn:hover {
        background: rgba(255, 255, 255, 0.35);
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Galería Institucional</h2>
            <p>Sube y gestiona las fotografías que se muestran en el sitio web y carruseles.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('galeria') }}" target="_blank" class="btn-outline">
                Ver galería pública →
            </a>
            <button type="button" class="btn-primary" id="btnOpenUploadModal">
                <svg class="icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Nueva Fotografía
            </button>
        </div>
    </div>

    <!-- CUADRÍCULA DE FOTOGRAFÍAS -->
    <div class="galeria-grid">
        @forelse($fotos as $foto)
            <div class="galeria-card">
                <img
                    src="{{ $foto->url }}"
                    alt="{{ $foto->titulo }}"
                    class="galeria-thumb js-lightbox-trigger"
                    style="cursor: zoom-in;"
                    title="Clic para ver en tamaño grande"
                    onerror="this.src='{{ asset('images/logo_color.png') }}'; this.style.objectFit='contain';"
                >
                <div class="galeria-info">
                    <span class="galeria-title">{{ $foto->titulo }}</span>
                    <div class="galeria-actions">
                        <span style="font-size: 11px; color: var(--text-secondary);">
                            ID: #{{ $foto->id }}
                        </span>
                        <form action="{{ route('admin.galeria.destroy', $foto->id) }}" method="POST" data-confirm="¿Eliminar permanentemente la fotografía &quot;{{ $foto->titulo }}&quot;?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-icon">
                                <svg class="icon" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-gallery" style="grid-column: 1 / -1;">
                No hay fotografías registradas aún. Haz clic en <strong>Nueva Fotografía</strong> para agregar la primera.
            </div>
        @endforelse
    </div>

    <!-- MODAL PARA AGREGAR NUEVA FOTO EN LA MISMA PANTALLA -->
    <div id="uploadGaleriaModal" class="admin-modal-backdrop" aria-hidden="true">
        <div class="admin-modal">
            <div class="modal-header">
                <h3>Subir Nueva Fotografía</h3>
                <button type="button" class="btn-close-modal" id="closeUploadModalBtn" aria-label="Cerrar modal">✕</button>
            </div>

            <form action="{{ route('admin.galeria.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div style="margin-bottom: 16px;">
                        <label class="form-label" for="titulo">Título o descripción del evento *</label>
                        <input
                            type="text"
                            name="titulo"
                            id="titulo"
                            class="form-control"
                            required
                            placeholder="Ej: Ceremonia de Clausura 2026"
                        >
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label class="form-label">Archivo de imagen * <span>(JPG, PNG, WebP)</span></label>
                        <div id="galeriaDropzone" class="dropzone-box" onclick="document.getElementById('galeria_file').click();">
                            <svg class="dropzone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <div class="dropzone-text">Arrastra una imagen aquí o haz clic para seleccionarla</div>
                            <div class="dropzone-subtext">Formatos permitidos: JPG, PNG, WEBP (hasta 5 MB)</div>
                        </div>

                        <input type="file" name="imagen_file" id="galeria_file" style="display: none;" accept="image/*" required>

                        <div id="galeriaPreviewStrip" class="file-preview-strip" style="display: none; align-items: center; gap: 14px; padding: 10px; background: #f8fafc; border: 1px solid var(--border-color); margin-top: 10px;">
                            <img id="galeriaPreviewImg" src="" alt="Vista previa" style="width: 80px; height: 55px; object-fit: cover; border: 1px solid var(--border-color);">
                            <div style="font-size: 12px; color: var(--text-secondary); flex-grow: 1;">
                                <strong id="galeriaPreviewName" style="color: var(--text-primary); display: block; font-size: 13px;"></strong>
                                <span id="galeriaPreviewSize"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" id="cancelUploadModalBtn">Cancelar</button>
                    <button type="submit" class="btn-primary">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Guardar Fotografía
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- LIGHTBOX PARA VER FOTO EN GRANDE -->
    <div id="galeriaLightbox" class="lightbox-backdrop" aria-hidden="true">
        <button type="button" class="lightbox-close-btn" id="closeGaleriaLightboxBtn" aria-label="Cerrar vista grande">✕</button>
        <img id="galeriaLightboxImg" src="" alt="Imagen ampliada" class="lightbox-content">
    </div>
@endsection

@push('scripts')
<script>
    (function() {
        // Modal de subida
        const uploadModal = document.getElementById('uploadGaleriaModal');
        const btnOpenModal = document.getElementById('btnOpenUploadModal');
        const closeModalBtn = document.getElementById('closeUploadModalBtn');
        const cancelModalBtn = document.getElementById('cancelUploadModalBtn');

        function openModal() {
            uploadModal.classList.add('active');
            uploadModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            uploadModal.classList.remove('active');
            uploadModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        if (btnOpenModal) btnOpenModal.addEventListener('click', openModal);
        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);

        uploadModal.addEventListener('click', (e) => {
            if (e.target === uploadModal) closeModal();
        });

        // Dropzone & Previsualización
        const dropzone = document.getElementById('galeriaDropzone');
        const fileInput = document.getElementById('galeria_file');
        const previewStrip = document.getElementById('galeriaPreviewStrip');
        const previewImg = document.getElementById('galeriaPreviewImg');
        const previewName = document.getElementById('galeriaPreviewName');
        const previewSize = document.getElementById('galeriaPreviewSize');

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length > 0) {
                fileInput.files = files;
                handleSelectedFile(files[0]);
            }
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files && fileInput.files.length > 0) {
                handleSelectedFile(fileInput.files[0]);
            }
        });

        function handleSelectedFile(file) {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewName.textContent = file.name;
                previewSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
                previewStrip.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }

        // Lightbox para fotos de la galería
        const lightbox = document.getElementById('galeriaLightbox');
        const lightboxImg = document.getElementById('galeriaLightboxImg');
        const closeLightboxBtn = document.getElementById('closeGaleriaLightboxBtn');

        function openLightbox(src) {
            if (src) {
                lightboxImg.src = src;
                lightbox.classList.add('active');
                lightbox.setAttribute('aria-hidden', 'false');
            }
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
            lightbox.setAttribute('aria-hidden', 'true');
        }

        document.querySelectorAll('.js-lightbox-trigger').forEach(img => {
            img.addEventListener('click', () => openLightbox(img.src));
        });

        if (closeLightboxBtn) closeLightboxBtn.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', (e) => {
            if (e.target !== lightboxImg) closeLightbox();
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (lightbox.classList.contains('active')) closeLightbox();
                if (uploadModal.classList.contains('active')) closeModal();
            }
        });
    })();
</script>
@endpush
