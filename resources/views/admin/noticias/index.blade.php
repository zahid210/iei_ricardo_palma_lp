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
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Noticias</h2>
            <p>Publica, edita y organiza las noticias y comunicados del colegio.</p>
        </div>
        <a href="{{ route('admin.noticias.create') }}" class="btn-primary">
            <svg class="icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Nueva noticia
        </a>
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
                    <a href="{{ route('noticias.show', $item->slug) }}" target="_blank" class="btn-icon-admin" title="Ver en el sitio">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </a>
                    <a href="{{ route('admin.noticias.edit', $item->id) }}" class="btn-icon-admin" title="Editar noticia">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </a>
                    <form action="{{ route('admin.noticias.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta noticia?');" style="display:inline;">
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
                    <a href="{{ route('admin.noticias.create') }}" class="btn-primary" style="display: inline-flex;">
                        Crear la primera noticia
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
