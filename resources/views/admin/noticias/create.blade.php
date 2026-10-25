@extends('admin.layout')

@section('title', 'Nueva Noticia')

@push('styles')
<style>
    .form-card {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        padding: 28px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full {
        grid-column: 1 / -1;
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
        font-size: 14px;
        border: 1px solid var(--border-color);
        background: #fafafa;
        color: var(--text-primary);
        outline: none;
        transition: border-color 0.15s, background-color 0.15s;
    }

    .form-control:focus {
        border-color: var(--brand-green);
        background: #ffffff;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .form-checkbox-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 10px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .form-error {
        color: var(--danger-btn);
        font-size: 12px;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Nueva Noticia</h2>
            <p>Ingresa la información detallada para publicar en el sitio web.</p>
        </div>
        <a href="{{ route('admin.noticias.index') }}" class="btn-outline">
            ← Volver al listado
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.noticias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="titulo" class="form-label">Título de la noticia *</label>
                <input
                    type="text"
                    name="titulo"
                    id="titulo"
                    class="form-control"
                    value="{{ old('titulo') }}"
                    required
                    placeholder="Ej. Celebración por el Día de la Primavera"
                >
                @error('titulo') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="fecha_publicacion" class="form-label">Fecha de publicación *</label>
                    <input
                        type="date"
                        name="fecha_publicacion"
                        id="fecha_publicacion"
                        class="form-control"
                        value="{{ old('fecha_publicacion', date('Y-m-d')) }}"
                        required
                    >
                    @error('fecha_publicacion') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="autor" class="form-label">Autor / Comisión</label>
                    <input
                        type="text"
                        name="autor"
                        id="autor"
                        class="form-control"
                        value="{{ old('autor', 'Comisión de Comunicaciones') }}"
                        placeholder="Ej. Dirección Institucional"
                    >
                    @error('autor') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="extracto" class="form-label">Extracto breve * <span>(resumen corto para vistas previas)</span></label>
                <textarea
                    name="extracto"
                    id="extracto"
                    rows="2"
                    class="form-control"
                    required
                    placeholder="Breve resumen de 1 a 2 oraciones..."
                >{{ old('extracto') }}</textarea>
                @error('extracto') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="contenido" class="form-label">Contenido completo * <span>(párrafos de la noticia)</span></label>
                <textarea
                    name="contenido"
                    id="contenido"
                    rows="8"
                    class="form-control"
                    required
                    placeholder="Escribe el cuerpo de la noticia..."
                >{{ old('contenido') }}</textarea>
                @error('contenido') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="imagen_file" class="form-label">Subir imagen <span>(JPG, PNG, WebP)</span></label>
                    <input
                        type="file"
                        name="imagen_file"
                        id="imagen_file"
                        class="form-control"
                        accept="image/*"
                    >
                    @error('imagen_file') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="imagen" class="form-label">O ruta relativa de imagen existente</label>
                    <input
                        type="text"
                        name="imagen"
                        id="imagen"
                        class="form-control"
                        value="{{ old('imagen', 'images/galeria_1.jpg') }}"
                        placeholder="images/galeria_1.jpg"
                    >
                    @error('imagen') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="orden" class="form-label">Orden de visualización <span>(0 = principal)</span></label>
                    <input
                        type="number"
                        name="orden"
                        id="orden"
                        class="form-control"
                        value="{{ old('orden', 0) }}"
                    >
                </div>

                <div class="form-group" style="display: flex; align-items: center; padding-top: 22px;">
                    <label class="form-checkbox-label">
                        <input type="checkbox" name="destacada" value="1" {{ old('destacada') ? 'checked' : '' }}>
                        Destacar como noticia principal en portada
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg class="icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Publicar Noticia
                </button>
                <a href="{{ route('admin.noticias.index') }}" class="btn-outline">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
