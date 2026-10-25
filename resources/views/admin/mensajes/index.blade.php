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

    .table-admin tr:hover td {
        background-color: #fafbfc;
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

    .btn-action-sm.danger {
        color: var(--danger-btn);
        border-color: #fca5a5;
    }

    .btn-action-sm.danger:hover {
        background: #fee2e2;
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
            <p>Consultas, solicitudes y mensajes enviados a través del formulario de contacto.</p>
        </div>
    </div>

    <div class="messages-table-container">
        <table class="table-admin">
            <thead>
                <tr>
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
                    <tr>
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
                                Ver
                            </a>
                            <form action="{{ route('admin.mensajes.destroy', $msg->id) }}" method="POST" data-confirm="¿Eliminar este mensaje permanentemente?" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-sm danger">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-secondary);">
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
