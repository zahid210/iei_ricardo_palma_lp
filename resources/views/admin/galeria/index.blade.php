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
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Galería Institucional</h2>
            <p>Sube y gestiona las fotografías que se muestran en el sitio web y carruseles.</p>
        </div>
        <a href="{{ route('galeria') }}" target="_blank" class="btn-outline">
            Ver galería pública →
        </a>
    </div>

    <!-- PANEL DE SUBIDA CON ARRASTRE -->
    <div class="upload-card">
        <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 16px; color: var(--text-primary);">
            + Subir nueva fotografía a la galería
        </h3>

        <form action="{{ route('admin.galeria.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
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
                <label class="form-label">Archivo de imagen *</label>
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

                <div id="galeriaPreviewStrip" class="file-preview-strip" style="display: none;">
                    <img id="galeriaPreviewImg" src="" alt="Vista previa">
                    <div style="font-size: 12px; color: var(--text-secondary); flex-grow: 1;">
                        <strong id="galeriaPreviewName" style="color: var(--text-primary); display: block;"></strong>
                        <span id="galeriaPreviewSize"></span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                <svg class="icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Guardar en Galería
            </button>
        </form>
    </div>

    <!-- CUADRÍCULA DE FOTOGRAFÍAS -->
    <div class="galeria-grid">
        @forelse($fotos as $foto)
            <div class="galeria-card">
                <img
                    src="{{ asset($foto->imagen_path) }}"
                    alt="{{ $foto->titulo }}"
                    class="galeria-thumb"
                    onerror="this.src='{{ asset('images/logo_color.png') }}'; this.style.objectFit='contain';"
                >
                <div class="galeria-info">
                    <span class="galeria-title">{{ $foto->titulo }}</span>
                    <div class="galeria-actions">
                        <span style="font-size: 11px; color: var(--text-secondary);">
                            ID: #{{ $foto->id }}
                        </span>
                        <form action="{{ route('admin.galeria.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta fotografía permanentemente?');">
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
                No hay fotografías registradas aún. Sube la primera fotografía usando el formulario superior.
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
<script>
    (function() {
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
    })();
</script>
@endpush
