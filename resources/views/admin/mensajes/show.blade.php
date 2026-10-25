@extends('admin.layout')

@section('title', 'Detalle del Mensaje')

@push('styles')
<style>
    .message-detail-card {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        padding: 32px;
        max-width: 800px;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 140px 1fr;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .detail-row:last-of-type {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 13px;
    }

    .detail-value {
        color: var(--text-primary);
    }

    .message-body-box {
        margin-top: 24px;
        padding: 20px;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        line-height: 1.6;
        font-size: 14px;
        white-space: pre-line;
    }

    .detail-actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Mensaje de {{ $contacto->nombre }}</h2>
            <p>Recibido el {{ $contacto->created_at ? $contacto->created_at->format('d \d\e F \d\e Y \a \l\a\s H:i') : '-' }}</p>
        </div>
        <a href="{{ route('admin.mensajes.index') }}" class="btn-outline">
            ← Volver a la bandeja
        </a>
    </div>

    <div class="message-detail-card">
        <div class="detail-row">
            <span class="detail-label">Remitente:</span>
            <span class="detail-value"><strong>{{ $contacto->nombre }}</strong></span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Correo electrónico:</span>
            <span class="detail-value">
                <a href="mailto:{{ $contacto->correo }}" style="color: var(--brand-green); text-decoration: none;">
                    {{ $contacto->correo }}
                </a>
            </span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Teléfono:</span>
            <span class="detail-value">{{ $contacto->telefono ?? 'No especificado' }}</span>
        </div>

        <div class="detail-row">
            <span class="detail-label">Nivel Educativo:</span>
            <span class="detail-value">
                @if($contacto->nivel)
                    <strong style="color: #0369a1;">{{ $contacto->nivel }}</strong>
                @else
                    <span style="color: var(--text-secondary);">No especificado</span>
                @endif
            </span>
        </div>

        <div class="message-body-box">
            {{ $contacto->mensaje }}
        </div>

        <div class="detail-actions">
            <a href="mailto:{{ $contacto->correo }}?subject=Respuesta a su consulta - I.E.I. Ricardo Palma" class="btn-primary">
                <svg class="icon" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Responder por correo
            </a>

            <form action="{{ route('admin.mensajes.toggle', $contacto->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-outline">
                    @if($contacto->leido)
                        <svg class="icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                        Marcar como no leído
                    @else
                        <svg class="icon" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Marcar como leído
                    @endif
                </button>
            </form>
        </div>
    </div>
@endsection
