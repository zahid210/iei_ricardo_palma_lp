@extends('admin.layout')

@section('title', 'Gestión de Docentes y Personal')

@push('styles')
<style>
    .level-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 12px;
        flex-wrap: wrap;
    }

    .level-tab-btn {
        background: transparent;
        border: 1px solid var(--border-color);
        padding: 8px 16px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.15s;
    }

    .level-tab-btn:hover {
        background: #f1f5f9;
        color: var(--text-primary);
    }

    .level-tab-btn.active {
        background: var(--brand-green);
        border-color: var(--brand-green);
        color: #ffffff;
    }

    .level-badge-count {
        background: rgba(0, 0, 0, 0.08);
        padding: 2px 6px;
        font-size: 11px;
    }

    .level-tab-btn.active .level-badge-count {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    .table-container {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .admin-table th {
        background: #f8fafc;
        padding: 12px 16px;
        font-weight: 600;
        color: var(--text-secondary);
        border-bottom: 1px solid var(--border-color);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .admin-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        vertical-align: middle;
    }

    .admin-table tr:hover td {
        background-color: #fbfcfd;
    }

    .btn-icon-admin {
        background-color: transparent;
        border: 1px solid var(--border-color);
        width: 32px;
        height: 32px;
        display: inline-flex;
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

    /* MODAL FLOTANTE */
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
        max-width: 580px;
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

    .form-group {
        margin-bottom: 16px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
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

    .modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        background: #fafbfc;
    }

    @media (max-width: 640px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <div class="section-header">
        <div class="section-title">
            <h2>Plana Docente y Personal</h2>
            <p>Gestiona los docentes y personal educativo organizados por nivel académico.</p>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('docentes') }}" target="_blank" class="btn-outline">
                Ver página pública →
            </a>
            <button type="button" class="btn-primary" id="btnOpenCreateDocente">
                <svg class="icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Nuevo Docente
            </button>
        </div>
    </div>

    <!-- PESTAÑAS POR NIVEL -->
    <div class="level-tabs">
        <button type="button" class="level-tab-btn active" data-tab="todos">
            Todos
            <span class="level-badge-count">{{ $docentes->count() }}</span>
        </button>
        <button type="button" class="level-tab-btn" data-tab="Inicial">
            Nivel Inicial
            <span class="level-badge-count">{{ count($porNivel['Inicial']) }}</span>
        </button>
        <button type="button" class="level-tab-btn" data-tab="Primaria">
            Nivel Primaria
            <span class="level-badge-count">{{ count($porNivel['Primaria']) }}</span>
        </button>
        <button type="button" class="level-tab-btn" data-tab="Secundaria">
            Nivel Secundaria
            <span class="level-badge-count">{{ count($porNivel['Secundaria']) }}</span>
        </button>
    </div>

    <!-- TABLA DE DOCENTES -->
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Nombres y Apellidos</th>
                    <th style="width: 140px;">Nivel</th>
                    <th>Cargo / Especialidad</th>
                    <th style="width: 120px;">DNI</th>
                    <th style="width: 100px; text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docentes as $index => $doc)
                    <tr class="docente-row" data-nivel="{{ $doc->nivel }}">
                        <td style="color: var(--text-secondary); font-size: 12px;">{{ $index + 1 }}</td>
                        <td>
                            <strong style="color: var(--text-primary);">{{ $doc->nombres_apellidos }}</strong>
                        </td>
                        <td>
                            @if($doc->nivel === 'Inicial')
                                <span style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: 2px 8px; font-size: 11.5px; font-weight: 600;">Inicial</span>
                            @elseif($doc->nivel === 'Primaria')
                                <span style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; padding: 2px 8px; font-size: 11.5px; font-weight: 600;">Primaria</span>
                            @else
                                <span style="background: #f0f9ff; color: #075985; border: 1px solid #bae6fd; padding: 2px 8px; font-size: 11.5px; font-weight: 600;">Secundaria</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-size: 12.5px; font-weight: 500; color: #475569;">{{ $doc->cargo }}</span>
                        </td>
                        <td style="color: var(--text-secondary); font-family: monospace; font-size: 12.5px;">
                            {{ $doc->dni ?: '—' }}
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 4px;">
                                <button
                                    type="button"
                                    class="btn-icon-admin btn-edit-docente"
                                    title="Editar docente"
                                    data-action="{{ route('admin.docentes.update', $doc->id) }}"
                                    data-nivel="{{ $doc->nivel }}"
                                    data-nombre="{{ $doc->nombres_apellidos }}"
                                    data-cargo="{{ $doc->cargo }}"
                                    data-dni="{{ $doc->dni }}"
                                    data-orden="{{ $doc->orden }}"
                                >
                                    <svg class="icon" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>

                                <form action="{{ route('admin.docentes.destroy', $doc->id) }}" method="POST" data-confirm="¿Estás seguro de eliminar al docente {{ $doc->nombres_apellidos }}?" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon-admin danger" title="Eliminar docente">
                                        <svg class="icon" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                            No hay docentes registrados. Haz clic en "Nuevo Docente" para agregar el primero.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL CREAR DOCENTE -->
    <div id="createDocenteModal" class="admin-modal-backdrop" aria-hidden="true">
        <div class="admin-modal">
            <div class="modal-header">
                <h3>Nuevo Docente o Personal</h3>
                <button type="button" class="btn-close-modal" id="closeCreateDocenteBtn" aria-label="Cerrar modal">✕</button>
            </div>

            <form action="{{ route('admin.docentes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="create_nivel" class="form-label">Nivel Educativo *</label>
                        <select name="nivel" id="create_nivel" class="form-control" required>
                            <option value="Inicial">Nivel Inicial</option>
                            <option value="Primaria">Nivel Primaria</option>
                            <option value="Secundaria" selected>Nivel Secundaria</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="create_nombre" class="form-label">Apellidos y Nombres *</label>
                        <input type="text" name="nombres_apellidos" id="create_nombre" class="form-control" required placeholder="Ej: PÉREZ LÓPEZ, Juan Carlos">
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="create_cargo" class="form-label">Cargo / Función *</label>
                            <input type="text" name="cargo" id="create_cargo" class="form-control" value="DOCENTE DE AULA" required placeholder="Ej: DOCENTE DE AULA">
                        </div>

                        <div class="form-group">
                            <label for="create_dni" class="form-label">DNI <span>(Opcional)</span></label>
                            <input type="text" name="dni" id="create_dni" class="form-control" placeholder="Ej: 4071040">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="create_orden" class="form-label">Orden de Visualización</label>
                        <input type="number" name="orden" id="create_orden" class="form-control" value="0">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" id="cancelCreateDocenteBtn">Cancelar</button>
                    <button type="submit" class="btn-primary">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Guardar Docente
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDITAR DOCENTE -->
    <div id="editDocenteModal" class="admin-modal-backdrop" aria-hidden="true">
        <div class="admin-modal">
            <div class="modal-header">
                <h3>Editar Información de Docente</h3>
                <button type="button" class="btn-close-modal" id="closeEditDocenteBtn" aria-label="Cerrar modal">✕</button>
            </div>

            <form id="editDocenteForm" action="" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_nivel" class="form-label">Nivel Educativo *</label>
                        <select name="nivel" id="edit_nivel" class="form-control" required>
                            <option value="Inicial">Nivel Inicial</option>
                            <option value="Primaria">Nivel Primaria</option>
                            <option value="Secundaria">Nivel Secundaria</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_nombre" class="form-label">Apellidos y Nombres *</label>
                        <input type="text" name="nombres_apellidos" id="edit_nombre" class="form-control" required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="edit_cargo" class="form-label">Cargo / Función *</label>
                            <input type="text" name="cargo" id="edit_cargo" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_dni" class="form-label">DNI <span>(Opcional)</span></label>
                            <input type="text" name="dni" id="edit_dni" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_orden" class="form-label">Orden de Visualización</label>
                        <input type="number" name="orden" id="edit_orden" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-outline" id="cancelEditDocenteBtn">Cancelar</button>
                    <button type="submit" class="btn-primary">
                        <svg class="icon" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function() {
        // Filtrado por pestañas de nivel
        const tabBtns = document.querySelectorAll('.level-tab-btn');
        const rows = document.querySelectorAll('.docente-row');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const level = btn.dataset.tab;
                rows.forEach(row => {
                    if (level === 'todos' || row.dataset.nivel === level) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });

        // Modal Crear Docente
        const createModal = document.getElementById('createDocenteModal');
        const btnOpenCreate = document.getElementById('btnOpenCreateDocente');
        const closeCreateBtn = document.getElementById('closeCreateDocenteBtn');
        const cancelCreateBtn = document.getElementById('cancelCreateDocenteBtn');

        function openCreate() {
            createModal.classList.add('active');
            createModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeCreate() {
            createModal.classList.remove('active');
            createModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        if (btnOpenCreate) btnOpenCreate.addEventListener('click', openCreate);
        if (closeCreateBtn) closeCreateBtn.addEventListener('click', closeCreate);
        if (cancelCreateBtn) cancelCreateBtn.addEventListener('click', closeCreate);

        // Modal Editar Docente
        const editModal = document.getElementById('editDocenteModal');
        const editForm = document.getElementById('editDocenteForm');
        const closeEditBtn = document.getElementById('closeEditDocenteBtn');
        const cancelEditBtn = document.getElementById('cancelEditDocenteBtn');
        const editBtns = document.querySelectorAll('.btn-edit-docente');

        function openEdit(btn) {
            editForm.action = btn.dataset.action;
            document.getElementById('edit_nivel').value = btn.dataset.nivel || 'Secundaria';
            document.getElementById('edit_nombre').value = btn.dataset.nombre || '';
            document.getElementById('edit_cargo').value = btn.dataset.cargo || '';
            document.getElementById('edit_dni').value = btn.dataset.dni || '';
            document.getElementById('edit_orden').value = btn.dataset.orden || '0';

            editModal.classList.add('active');
            editModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeEdit() {
            editModal.classList.remove('active');
            editModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        editBtns.forEach(btn => {
            btn.addEventListener('click', () => openEdit(btn));
        });

        if (closeEditBtn) closeEditBtn.addEventListener('click', closeEdit);
        if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEdit);

        // Cerrar con Escape o clic en backdrop
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

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (createModal && createModal.classList.contains('active')) closeCreate();
                if (editModal && editModal.classList.contains('active')) closeEdit();
            }
        });
    })();
</script>
@endpush
