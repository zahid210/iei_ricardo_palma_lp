@extends('admin.layout')

@section('title', 'Gestión de Noticias')

@push('styles')
<style>
    .news-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .news-card-item {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: border-color 0.15s;
    }

    .news-card-item:hover {
        border-color: #cbd5e1;
    }

    .news-thumb {
        width: 120px;
        height: 80px;
        object-fit: cover;
        background-color: #f1f5f9;
        flex-shrink: 0;
        border: 1px solid var(--border-color);
    }

    .news-meta-info {
        flex-grow: 1;
        min-width: 0;
    }

    .news-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 2px 6px;
        background: #fef3c7;
        color: #92400e;
        margin-bottom: 4px;
    }

    .news-title-text {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .news-sub-text {
        font-size: 12px;
        color: var(--text-secondary);
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .news-action-btns {
        display: flex;
        gap: 6px;
        flex-shrink: 0;
    }

    .btn-icon-admin {
        background-color: transparent;
        border: 1px solid var(--border-color);
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.15s;
    }

    .btn-icon-admin:hover {
        background-color: #f3f4f6;
        color: var(--text-primary);
    }

    .btn-icon-admin.danger:hover {
        background-color: #fee2e2;
        border-color: #fca5a5;
        color: var(--danger-btn);
    }

    .empty-state {
        background: var(--surface-color);
        border: 1px dashed var(--border-color);
        padding: 48px;
        text-align: center;
        color: var(--text-secondary);
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
        max-width: 800px;
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

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: var(--text-primary);
    }

    .form-label span {
        color: var(--text-secondary);
        font-weight: normal;
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

    textarea.form-control {
        resize: vertical;
    }

    /* ÁREA DROPZONE PARA ARRASTRAR Y SOLTAR */
    .dropzone-box {
        border: 2px dashed var(--border-color);
        background: #f8fafc;
        padding: 18px;
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
        width: 28px;
        height: 28px;
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

    /* CONTENEDOR DE VISTA PREVIA DE IMAGEN MÁS GRANDE */
    .file-preview-strip {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 12px;
        padding: 12px 14px;
        background: #f1f5f9;
        border: 1px solid var(--border-color);
    }

    .preview-thumbnail-wrapper {
        position: relative;
        cursor: pointer;
        display: inline-block;
        flex-shrink: 0;
    }

    .preview-thumbnail-wrapper img {
        width: 140px;
        height: 95px;
        object-fit: cover;
        border: 1px solid var(--border-color);
        display: block;
        transition: filter 0.15s ease;
    }

    .preview-thumbnail-wrapper:hover img {
        filter: brightness(0.9);
    }

    .preview-zoom-badge {
        position: absolute;
        bottom: 4px;
        right: 4px;
        background: rgba(0, 0, 0, 0.7);
        color: #ffffff;
        font-size: 10px;
        padding: 2px 5px;
        display: flex;
        align-items: center;
        gap: 3px;
        pointer-events: none;
    }

    .preview-zoom-badge svg {
        width: 10px;
        height: 10px;
        stroke: currentColor;
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

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .file-preview-strip {
            flex-direction: column;
            align-items: flex-start;
        }
        .preview-thumbnail-wrapper img {
            width: 100%;
            height: 140px;
        }
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Noticias</h2>
            <p>Publica, edita y organiza las noticias y comunicados del colegio.</p>
        </div>
        {{-- Botón para abrir modal de creación en la misma pantalla --}}
        <button type="button" class="btn-primary" id="btnOpenCreateNews">
            <svg class="icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nueva noticia
        </button>
    </div>

    <div class="news-list">
        @forelse($noticias as $item)
            <article class="news-card-item">
                <img src="{{ asset($item->imagen) }}" alt="{{ $item->titulo }}" class="news-thumb" onerror="this.src='{{ asset('images/logo_color.png') }}'; this.style.objectFit='contain';">
                
                <div class="news-meta-info">
                    @if($item->destacada)
                        <span class="news-badge">Destacada en portada</span>
                    @endif
                    <h3 class="news-title-text" title="{{ $item->titulo }}">{{ $item->titulo }}</h3>
                    <p class="news-sub-text">
                        <span><strong>Fecha:</strong> {{ $item->fecha_publicacion->format('d/m/Y') }}</span>
                        <span><strong>Autor:</strong> {{ $item->autor }}</span>
                        <span><strong>Orden:</strong> {{ $item->orden }}</span>
                    </p>
                </div>

                <div class="news-action-btns">
                    <a href="{{ route('noticias.show', $item->slug) }}" target="_blank" class="btn-icon-admin" title="Ver en el sitio público">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>

                    {{-- Botón que abre el modal en la misma pantalla --}}
                    <button
                        type="button"
                        class="btn-icon-admin btn-open-edit"
                        title="Editar noticia en esta pantalla"
                        data-id="{{ $item->id }}"
                        data-action="{{ route('admin.noticias.update', $item->id) }}"
                        data-titulo="{{ $item->titulo }}"
                        data-fecha="{{ $item->fecha_publicacion->format('Y-m-d') }}"
                        data-autor="{{ $item->autor }}"
                        data-orden="{{ $item->orden }}"
                        data-destacada="{{ $item->destacada ? '1' : '0' }}"
                        data-imagen="{{ asset($item->imagen) }}"
                        data-extracto="{{ $item->extracto }}"
                        data-contenido="{{ $item->contenido }}"
                    >
                        <svg class="icon" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>

                    <form action="{{ route('admin.noticias.destroy', $item->id) }}" method="POST" data-confirm="¿Estás seguro de eliminar la noticia &quot;{{ $item->titulo }}&quot;? Esta acción no se puede deshacer." style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon-admin danger" title="Eliminar noticia">
                            <svg class="icon" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        </button>
                    </form>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <p>No hay noticias registradas actualmente.</p>
                <div style="margin-top: 14px;">
                    <button type="button" class="btn-primary" onclick="document.getElementById('btnOpenCreateNews').click();" style="display: inline-flex;">
                        Crear la primera noticia
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    <!-- MODAL PARA CREAR NUEVA NOTICIA EN LA MISMA PANTALLA -->
    <div id="createNewsModal" class="admin-modal-backdrop" aria-hidden="true">
        <div class="admin-modal">
            <div class="modal-header">
                <h3>Publicar Nueva Noticia</h3>
                <button type="button" class="btn-close-modal" id="closeCreateModalBtn" aria-label="Cerrar modal">✕</button>
            </div>

            <form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label for="create_titulo" class="form-label">Título de la noticia *</label>
                        <input type="text" name="titulo" id="create_titulo" class="form-control" required placeholder="Ej: Celebración por el Día de la Primavera">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="create_fecha_publicacion" class="form-label">Fecha de publicación *</label>
                            <input type="date" name="fecha_publicacion" id="create_fecha_publicacion" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="create_autor" class="form-label">Autor / Comisión</label>
                            <input type="text" name="autor" id="create_autor" class="form-control" value="Comisión de Comunicaciones">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="create_extracto" class="form-label">Extracto breve * <span>(resumen corto)</span></label>
                        <textarea name="extracto" id="create_extracto" rows="2" class="form-control" required placeholder="Breve resumen de 1 a 2 oraciones..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="create_contenido" class="form-label">Contenido completo * <span>(párrafos de la noticia)</span></label>
                        <textarea name="contenido" id="create_contenido" rows="6" class="form-control" required placeholder="Escribe el cuerpo de la noticia..."></textarea>
                    </div>

                    <!-- DROPZONE PARA SUBIR IMAGEN EN CREAR -->
                    <div class="form-group">
                        <label class="form-label">Imagen de la noticia <span>(JPG, PNG, WebP)</span></label>
                        
                        <div id="dropzoneCreate" class="dropzone-box" onclick="document.getElementById('create_imagen_file').click();">
                            <svg class="dropzone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <div class="dropzone-text">Arrastra una imagen aquí o haz clic para seleccionarla</div>
                            <div class="dropzone-subtext">Formatos permitidos: JPG, PNG, WEBP (hasta 5 MB)</div>
                        </div>

                        <input type="file" name="imagen_file" id="create_imagen_file" style="display: none;" accept="image/*">

                        <div id="createPreviewStrip" class="file-preview-strip" style="display: none;">
                            <div class="preview-thumbnail-wrapper" id="createThumbWrapper" title="Clic para expandir en tamaño completo">
                                <img id="createPreviewImg" src="" alt="Vista previa">
                                <span class="preview-zoom-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                                    Expandir
                                </span>
                            </div>
                            <div style="font-size: 13px; color: var(--text-secondary); flex-grow: 1;">
                                <div id="createPreviewName" style="color: var(--text-primary); font-weight: 600; margin-bottom: 2px;"></div>
                                <span id="createPreviewSize" style="display: block; font-size: 12px; margin-bottom: 6px;"></span>
                                <button type="button" id="btnExpandCreateImage" class="btn-outline" style="padding: 4px 8px; font-size: 11.5px;">
                                    🔍 Ver en pantalla completa
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="create_orden" class="form-label">Orden de visualización</label>
                            <input type="number" name="orden" id="create_orden" class="form-control" value="0">
                        </div>

                        <div class="form-group" style="display: flex; align-items: center; padding-top: 22px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer;">
                                <input type="checkbox" name="destacada" id="create_destacada" value="1">
                                Destacar como noticia principal en portada
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" id="cancelCreateModalBtn">Cancelar</button>
                    <button type="submit" class="btn-primary">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Publicar Noticia
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DE EDICIÓN EN LA MISMA PANTALLA -->
    <div id="editNewsModal" class="admin-modal-backdrop" aria-hidden="true">
        <div class="admin-modal">
            <div class="modal-header">
                <h3>Editar Noticia</h3>
                <button type="button" class="btn-close-modal" id="closeModalBtn" aria-label="Cerrar modal">✕</button>
            </div>

            <form id="editNewsForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_titulo" class="form-label">Título de la noticia *</label>
                        <input type="text" name="titulo" id="edit_titulo" class="form-control" required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="edit_fecha_publicacion" class="form-label">Fecha de publicación *</label>
                            <input type="date" name="fecha_publicacion" id="edit_fecha_publicacion" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_autor" class="form-label">Autor / Comisión</label>
                            <input type="text" name="autor" id="edit_autor" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_extracto" class="form-label">Extracto breve *</label>
                        <textarea name="extracto" id="edit_extracto" rows="2" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_contenido" class="form-label">Contenido completo *</label>
                        <textarea name="contenido" id="edit_contenido" rows="6" class="form-control" required></textarea>
                    </div>

                    <!-- CARGA DE IMAGEN CON ZONA DE ARRASTRAR Y VISTA PREVIA EXPANDIBLE -->
                    <div class="form-group">
                        <label class="form-label">Imagen de la noticia <span>(JPG, PNG, WebP)</span></label>
                        
                        <div id="dropzoneEdit" class="dropzone-box" onclick="document.getElementById('edit_imagen_file').click();">
                            <svg class="dropzone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <div class="dropzone-text">Arrastra una imagen aquí o haz clic para seleccionarla</div>
                            <div class="dropzone-subtext">Formatos permitidos: JPG, PNG, WEBP (hasta 5 MB)</div>
                        </div>

                        <input type="file" name="imagen_file" id="edit_imagen_file" style="display: none;" accept="image/*">

                        <!-- VISTA PREVIA MÁS GRANDE CON BOTÓN DE ZOOM -->
                        <div id="editCurrentPreview" class="file-preview-strip" style="display: none;">
                            <div class="preview-thumbnail-wrapper" id="previewThumbWrapper" title="Clic para expandir en tamaño completo">
                                <img id="editPreviewImg" src="" alt="Vista previa">
                                <span class="preview-zoom-badge">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                                    Expandir
                                </span>
                            </div>
                            <div style="font-size: 13px; color: var(--text-secondary); flex-grow: 1;">
                                <div id="editPreviewName" style="color: var(--text-primary); font-weight: 600; margin-bottom: 2px;">Imagen actual</div>
                                <span id="editPreviewNotice" style="display: block; font-size: 12px; margin-bottom: 6px;">Si no subes una nueva imagen, se mantendrá la actual.</span>
                                <button type="button" id="btnExpandImage" class="btn-outline" style="padding: 4px 8px; font-size: 11.5px;">
                                    🔍 Ver en pantalla completa
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="edit_orden" class="form-label">Orden de visualización</label>
                            <input type="number" name="orden" id="edit_orden" class="form-control">
                        </div>

                        <div class="form-group" style="display: flex; align-items: center; padding-top: 22px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 500; cursor: pointer;">
                                <input type="checkbox" name="destacada" id="edit_destacada" value="1">
                                Destacar como noticia principal en portada
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" id="cancelModalBtn">Cancelar</button>
                    <button type="submit" class="btn-primary">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- LIGHTBOX MODAL PARA VER CUALQUIER IMAGEN EXPANDIDA EN TAMAÑO COMPLETO -->
    <div id="imageLightbox" class="lightbox-backdrop" aria-hidden="true">
        <button type="button" class="lightbox-close-btn" id="closeLightboxBtn" aria-label="Cerrar imagen grande">✕</button>
        <img id="lightboxImg" src="" alt="Imagen expandida" class="lightbox-content">
    </div>
@endsection

@push('scripts')
<script>
    (function() {
        // --- 1. MODAL CREAR NOTICIA ---
        const createModal = document.getElementById('createNewsModal');
        const btnOpenCreate = document.getElementById('btnOpenCreateNews');
        const closeCreateBtn = document.getElementById('closeCreateModalBtn');
        const cancelCreateBtn = document.getElementById('cancelCreateModalBtn');

        const dropzoneCreate = document.getElementById('dropzoneCreate');
        const createFileInput = document.getElementById('create_imagen_file');
        const createPreviewStrip = document.getElementById('createPreviewStrip');
        const createPreviewImg = document.getElementById('createPreviewImg');
        const createPreviewName = document.getElementById('createPreviewName');
        const createPreviewSize = document.getElementById('createPreviewSize');
        const createThumbWrapper = document.getElementById('createThumbWrapper');
        const btnExpandCreateImage = document.getElementById('btnExpandCreateImage');

        function openCreateModal() {
            createModal.classList.add('active');
            createModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            createModal.classList.remove('active');
            createModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        if (btnOpenCreate) btnOpenCreate.addEventListener('click', openCreateModal);
        if (closeCreateBtn) closeCreateBtn.addEventListener('click', closeCreateModal);
        if (cancelCreateBtn) cancelCreateBtn.addEventListener('click', closeCreateModal);

        // Drag & drop en modal crear
        setupDropzone(dropzoneCreate, createFileInput, (file) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                createPreviewImg.src = e.target.result;
                createPreviewName.textContent = file.name;
                createPreviewSize.textContent = 'Tamaño: ' + (file.size / 1024).toFixed(1) + ' KB';
                createPreviewStrip.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        });

        // --- 2. MODAL EDITAR NOTICIA ---
        const editModal = document.getElementById('editNewsModal');
        const editForm = document.getElementById('editNewsForm');
        const closeEditBtn = document.getElementById('closeModalBtn');
        const cancelEditBtn = document.getElementById('cancelModalBtn');
        const editBtns = document.querySelectorAll('.btn-open-edit');

        const dropzoneEdit = document.getElementById('dropzoneEdit');
        const editFileInput = document.getElementById('edit_imagen_file');
        const editPreviewStrip = document.getElementById('editCurrentPreview');
        const editPreviewImg = document.getElementById('editPreviewImg');
        const editPreviewName = document.getElementById('editPreviewName');
        const editPreviewNotice = document.getElementById('editPreviewNotice');
        const previewThumbWrapper = document.getElementById('previewThumbWrapper');
        const btnExpandImage = document.getElementById('btnExpandImage');

        function openEditModal(btn) {
            editForm.action = btn.dataset.action;
            document.getElementById('edit_titulo').value = btn.dataset.titulo || '';
            document.getElementById('edit_fecha_publicacion').value = btn.dataset.fecha || '';
            document.getElementById('edit_autor').value = btn.dataset.autor || '';
            document.getElementById('edit_orden').value = btn.dataset.orden || '0';
            document.getElementById('edit_destacada').checked = btn.dataset.destacada === '1';
            document.getElementById('edit_extracto').value = btn.dataset.extracto || '';
            document.getElementById('edit_contenido').value = btn.dataset.contenido || '';
            editFileInput.value = '';

            if (btn.dataset.imagen) {
                editPreviewImg.src = btn.dataset.imagen;
                editPreviewName.textContent = 'Imagen actual de la noticia';
                editPreviewNotice.textContent = 'Si no seleccionas un archivo nuevo, se mantendrá esta imagen.';
                editPreviewStrip.style.display = 'flex';
            } else {
                editPreviewStrip.style.display = 'none';
            }

            editModal.classList.add('active');
            editModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            editModal.classList.remove('active');
            editModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        editBtns.forEach(btn => {
            btn.addEventListener('click', () => openEditModal(btn));
        });

        if (closeEditBtn) closeEditBtn.addEventListener('click', closeEditModal);
        if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEditModal);

        // Drag & drop en modal editar
        setupDropzone(dropzoneEdit, editFileInput, (file) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                editPreviewImg.src = e.target.result;
                editPreviewName.textContent = file.name;
                editPreviewNotice.textContent = 'Nueva imagen seleccionada para subir (' + (file.size / 1024).toFixed(1) + ' KB)';
                editPreviewStrip.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        });

        // --- 3. LIGHTBOX EXPANDIR IMAGEN ---
        const lightbox = document.getElementById('imageLightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const closeLightboxBtn = document.getElementById('closeLightboxBtn');

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

        if (previewThumbWrapper) previewThumbWrapper.addEventListener('click', () => openLightbox(editPreviewImg.src));
        if (btnExpandImage) btnExpandImage.addEventListener('click', () => openLightbox(editPreviewImg.src));
        if (createThumbWrapper) createThumbWrapper.addEventListener('click', () => openLightbox(createPreviewImg.src));
        if (btnExpandCreateImage) btnExpandCreateImage.addEventListener('click', () => openLightbox(createPreviewImg.src));
        if (closeLightboxBtn) closeLightboxBtn.addEventListener('click', closeLightbox);

        lightbox.addEventListener('click', (e) => {
            if (e.target !== lightboxImg) closeLightbox();
        });

        // Control de teclado y clics fuera de modales
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (lightbox.classList.contains('active')) {
                    closeLightbox();
                } else if (createModal && createModal.classList.contains('active')) {
                    closeCreateModal();
                } else if (editModal && editModal.classList.contains('active')) {
                    closeEditModal();
                }
            }
        });

        [createModal, editModal].forEach(modalEl => {
            if (modalEl) {
                modalEl.addEventListener('click', (e) => {
                    if (e.target === modalEl) {
                        modalEl.classList.remove('active');
                        modalEl.setAttribute('aria-hidden', 'true');
                        document.body.style.overflow = '';
                    }
                });
            }
        });

        // Función reutilizable para dropzones
        function setupDropzone(dropzoneEl, inputEl, onFileLoaded) {
            if (!dropzoneEl || !inputEl) return;

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzoneEl.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzoneEl.classList.add('dragover');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzoneEl.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzoneEl.classList.remove('dragover');
                });
            });

            dropzoneEl.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length > 0) {
                    inputEl.files = files;
                    if (files[0].type.startsWith('image/')) onFileLoaded(files[0]);
                }
            });

            inputEl.addEventListener('change', () => {
                if (inputEl.files && inputEl.files.length > 0) {
                    if (inputEl.files[0].type.startsWith('image/')) onFileLoaded(inputEl.files[0]);
                }
            });
        }
    })();
</script>
@endpush
