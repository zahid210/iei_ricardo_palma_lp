@extends('admin.layout')

@section('title', 'Cuentas de Acceso')

@push('styles')
<style>
    .users-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 28px;
        align-items: start;
    }

    .table-container {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        overflow-x: auto;
    }

    .table-admin {
        width: 100%;
        border-collapse: collapse;
        font-size: 13.5px;
        text-align: left;
    }

    .table-admin th {
        background-color: #f8fafc;
        padding: 12px 16px;
        font-weight: 600;
        border-bottom: 1px solid var(--border-color);
    }

    .table-admin td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .table-admin tr:last-child td {
        border-bottom: none;
    }

    .form-card {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        padding: 24px;
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

    .badge-current-user {
        display: inline-block;
        padding: 2px 6px;
        background: #dcfce7;
        color: #15803d;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        margin-left: 6px;
    }

    .btn-action-sm {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        font-size: 12px;
        border: 1px solid var(--border-color);
        background: #ffffff;
        cursor: pointer;
        color: var(--text-primary);
    }

    .btn-action-sm.danger {
        color: var(--danger-btn);
        border-color: #fca5a5;
    }

    .btn-action-sm.danger:hover {
        background: #fee2e2;
    }

    @media (max-width: 900px) {
        .users-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Cuentas de Acceso al Panel</h2>
            <p>Gestiona los administradores y colaboradores autorizados para acceder a este panel.</p>
        </div>
    </div>

    <div class="users-layout">
        <!-- TABLA DE USUARIOS EXISTENTES -->
        <div class="table-container">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Fecha de Registro</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usr)
                        <tr>
                            <td>
                                <strong>{{ $usr->name }}</strong>
                                @if($usr->id === auth()->id())
                                    <span class="badge-current-user">Tú (Sesión activa)</span>
                                @endif
                            </td>
                            <td>
                                <span style="color: var(--text-secondary);">{{ $usr->email }}</span>
                            </td>
                            <td style="color: var(--text-secondary); font-size: 12px;">
                                {{ $usr->created_at ? $usr->created_at->format('d/m/Y') : '-' }}
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                @if($usr->id !== auth()->id())
                                    <form action="{{ route('admin.usuarios.destroy', $usr->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas revocar el acceso a este usuario?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-sm danger">
                                            Eliminar
                                        </button>
                                    </form>
                                @else
                                    <span style="font-size: 11px; color: var(--text-secondary);">En uso</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- FORMULARIO PARA REGISTRAR NUEVO ACCESO -->
        <div class="form-card">
            <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 16px; color: var(--text-primary);">
                + Dar acceso a otro usuario
            </h3>

            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nombre del usuario / cargo *</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        required
                        placeholder="Ej: Prof. María Huamán"
                        value="{{ old('name') }}"
                    >
                    @error('name') <span style="color: var(--danger-btn); font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo institucional o personal *</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        required
                        placeholder="docente@rpalma.edu.pe"
                        value="{{ old('email') }}"
                    >
                    @error('email') <span style="color: var(--danger-btn); font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña inicial *</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        required
                        placeholder="Mínimo 6 caracteres"
                    >
                    @error('password') <span style="color: var(--danger-btn); font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                    <svg class="icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                    Crear Cuenta de Acceso
                </button>
            </form>
        </div>
    </div>
@endsection
