@extends('admin.layout')

@section('title', 'Bandeja de Mensajes')

@push('styles')
<style>
    .messages-table-container {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        overflow-x: auto;
    }

    .table-admin {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .table-admin th {
        background-color: #f8fafc;
        padding: 12px 16px;
        font-weight: 600;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        white-space: nowrap;
    }

    .table-admin td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        vertical-align: top;
    }

    .table-admin tr:last-child td {
        border-bottom: none;
    }

    .table-admin tr.row-unread {
        background-color: #f0fdf4;
    }

    .table-admin tr.row-unread:hover td {
        background-color: #e6f9ed;
    }

    .table-admin tr:hover td {
        background-color: #fafbfc;
    }

    .badge-estado {
        display: inline-block;
        padding: 2px 7px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .badge-unread {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .badge-read {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .badge-nivel {
        display: inline-block;
        padding: 2px 8px;
        background: #e0f2fe;
        color: #0369a1;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .message-excerpt {
        color: var(--text-secondary);
        font-size: 12px;
        max-width: 320px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .btn-action-sm {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid var(--border-color);
        background: #ffffff;
        color: var(--text-primary);
        cursor: pointer;
        text-decoration: none;
    }

    .btn-action-sm:hover {
        background: #f1f5f9;
    }

    .pagination-bar {
        margin-top: 20px;
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Mensajes de Contacto</h2>
            <p>
                Historial institucional de consultas recibidas. 
                @if($noLeidos > 0)
                    <strong style="color: var(--brand-green);">({{ $noLeidos }} pendientes de revisión)</strong>
                @else
                    <span style="color: var(--text-secondary);">(Todos los mensajes han sido revisados)</span>
                @endif
            </p>
        </div>
    </div>

    <div class="messages-table-container">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Remitente</th>
                    <th>Contacto</th>
                    <th>Nivel de Interés</th>
                    <th>Mensaje</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mensajes as $msg)
                    <tr class="{{ ! $msg->leido ? 'row-unread' : '' }}">
                        <td style="white-space: nowrap;">
                            @if(! $msg->leido)
                                <span class="badge-estado badge-unread">Nuevo</span>
                            @else
                                <span class="badge-estado badge-read">Leído</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap; color: var(--text-secondary); font-size: 12px;">
                            {{ $msg->created_at ? $msg->created_at->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td>
                            <strong>{{ $msg->nombre }}</strong>
                        </td>
                        <td>
                            <div><a href="mailto:{{ $msg->correo }}" style="color: var(--brand-green); text-decoration: none;">{{ $msg->correo }}</a></div>
                            @if($msg->telefono)
                                <div style="color: var(--text-secondary); font-size: 12px;">Tel: {{ $msg->telefono }}</div>
                            @endif
                        </td>
                        <td>
                            @if($msg->nivel)
                                <span class="badge-nivel">{{ $msg->nivel }}</span>
                            @else
                                <span style="color: var(--text-secondary);">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="message-excerpt" title="{{ $msg->mensaje }}">
                                {{ $msg->mensaje }}
                            </div>
                        </td>
                        <td style="text-align: right; white-space: nowrap;">
                            <a href="{{ route('admin.mensajes.show', $msg->id) }}" class="btn-action-sm">
                                <svg class="icon" viewBox="0 0 24 24" style="width: 14px; height: 14px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                Ver
                            </a>

                            <form action="{{ route('admin.mensajes.toggle', $msg->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-action-sm" title="{{ $msg->leido ? 'Marcar como no leído' : 'Marcar como leído' }}">
                                    @if($msg->leido)
                                        <svg class="icon" viewBox="0 0 24 24" style="width: 14px; height: 14px; color: var(--text-secondary);"><circle cx="12" cy="12" r="10"/></svg>
                                        No leído
                                    @else
                                        <svg class="icon" viewBox="0 0 24 24" style="width: 14px; height: 14px; color: var(--primary-btn);"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                        Marcar leído
                                    @endif
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                            No hay mensajes registrados hasta el momento.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($mensajes->hasPages())
        <div class="pagination-bar">
            {{ $mensajes->links() }}
        </div>
    @endif
@endsection
