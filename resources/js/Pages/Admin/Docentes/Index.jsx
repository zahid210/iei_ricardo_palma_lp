import React, { useState } from 'react';
import { Link, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { 
    Plus, 
    Edit3, 
    Trash2, 
    Search, 
    GraduationCap, 
    X, 
    Save, 
    AlertTriangle,
    Users
} from 'lucide-react';

export default function Index({ docentes = [], porNivel = {} }) {
    const [activeTab, setActiveTab] = useState('Todos');
    const [searchTerm, setSearchTerm] = useState('');
    
    // Modal state
    const [formModalOpen, setFormModalOpen] = useState(false);
    const [editingDocente, setEditingDocente] = useState(null);
    const [deleteModal, setDeleteModal] = useState({ open: false, id: null, name: '' });

    const { data, setData, post, put, processing, errors, reset } = useForm({
        nivel: 'Primaria',
        nombres_apellidos: '',
        cargo: '',
        dni: '',
        orden: 0,
    });

    const openCreateModal = () => {
        setEditingDocente(null);
        reset();
        setData({
            nivel: activeTab === 'Todos' ? 'Primaria' : activeTab,
            nombres_apellidos: '',
            cargo: '',
            dni: '',
            orden: 0,
        });
        setFormModalOpen(true);
    };

    const openEditModal = (docente) => {
        setEditingDocente(docente);
        setData({
            nivel: docente.nivel,
            nombres_apellidos: docente.nombres_apellidos,
            cargo: docente.cargo,
            dni: docente.dni || '',
            orden: docente.orden || 0,
        });
        setFormModalOpen(true);
    };

    const handleFormSubmit = (e) => {
        e.preventDefault();
        if (editingDocente) {
            put(`/admin/docentes/${editingDocente.id}`, {
                onSuccess: () => {
                    setFormModalOpen(false);
                    reset();
                }
            });
        } else {
            post('/admin/docentes', {
                onSuccess: () => {
                    setFormModalOpen(false);
                    reset();
                }
            });
        }
    };

    const handleDelete = (id, name) => {
        setDeleteModal({ open: true, id, name });
    };

    const confirmDelete = () => {
        if (!deleteModal.id) return;
        router.delete(`/admin/docentes/${deleteModal.id}`, {
            onFinish: () => setDeleteModal({ open: false, id: null, name: '' })
        });
    };

    const displayedDocentes = docentes.filter((d) => {
        const matchesTab = activeTab === 'Todos' || d.nivel === activeTab;
        const matchesSearch = 
            d.nombres_apellidos.toLowerCase().includes(searchTerm.toLowerCase()) ||
            d.cargo.toLowerCase().includes(searchTerm.toLowerCase()) ||
            (d.dni && d.dni.includes(searchTerm));
        return matchesTab && matchesSearch;
    });

    const levelBadgeClass = (nivel) => {
        switch (nivel) {
            case 'Inicial':
                return 'bg-amber-50 text-amber-800 border-amber-200/80';
            case 'Primaria':
                return 'bg-teal-50 text-ricardo-teal border-teal-200/80';
            case 'Secundaria':
                return 'bg-indigo-50 text-indigo-800 border-indigo-200/80';
            default:
                return 'bg-neutral-50 text-neutral-700 border-neutral-200/80';
        }
    };

    return (
        <AdminLayout title="Plana de Profesores">
            <div className="space-y-6">
                
                {/* Encabezado y Botón Principal */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-neutral-200/80 shadow-2xs">
                    <div className="space-y-1">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Equipo Pedagógico
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Profesores del Colegio
                        </h1>
                        <p className="text-xs sm:text-sm text-neutral-500 font-literata">
                            Profesores y personal auxiliar organizados por nivel: Inicial, Primaria y Secundaria.
                        </p>
                    </div>

                    <button
                        type="button"
                        onClick={openCreateModal}
                        className="btn-admin-primary shrink-0 self-start sm:self-auto"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Nuevo Profesor</span>
                    </button>
                </div>

                {/* Filtros por Nivel y Buscador */}
                <div className="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                    
                    {/* Tabs de Nivel con color institucional rojo en activo */}
                    <div className="flex items-center gap-1.5 p-1 bg-white rounded-2xl border border-neutral-200/80 shadow-2xs overflow-x-auto">
                        {['Todos', 'Inicial', 'Primaria', 'Secundaria'].map((tab) => {
                            const count = tab === 'Todos' ? docentes.length : (porNivel[tab]?.length || 0);
                            const isActive = activeTab === tab;
                            return (
                                <button
                                    key={tab}
                                    type="button"
                                    onClick={() => setActiveTab(tab)}
                                    className={`px-4 py-2 rounded-xl text-xs font-mate uppercase tracking-wider font-bold transition-all whitespace-nowrap cursor-pointer flex items-center gap-2 ${
                                        isActive
                                            ? 'bg-ricardo-red text-white shadow-xs'
                                            : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'
                                    }`}
                                >
                                    <span>{tab}</span>
                                    <span className={`text-[10px] px-1.5 py-0.2 rounded-full ${isActive ? 'bg-white/20 text-white' : 'bg-neutral-100 text-neutral-500'}`}>
                                        {count}
                                    </span>
                                </button>
                            );
                        })}
                    </div>

                    {/* Buscador Rápido */}
                    <div className="flex items-center gap-2.5 bg-white px-3.5 py-2.5 rounded-2xl border border-neutral-200/80 shadow-2xs sm:w-72">
                        <Search className="w-4 h-4 text-neutral-400 shrink-0" />
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder="Buscar profesor o cargo..."
                            className="w-full text-xs text-neutral-900 placeholder-neutral-400 outline-none bg-transparent font-literata"
                        />
                        {searchTerm && (
                            <button onClick={() => setSearchTerm('')} className="text-xs text-neutral-400 hover:text-neutral-700">
                                <X className="w-3.5 h-3.5" />
                            </button>
                        )}
                    </div>
                </div>

                {/* Tabla de Profesores */}
                <div className="bg-white rounded-3xl border border-neutral-200/80 shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs sm:text-sm border-collapse">
                            <thead>
                                <tr className="border-b border-neutral-200/80 bg-[#FBFBFA] font-mate text-xs uppercase tracking-wider text-neutral-500">
                                    <th className="py-3.5 px-5 font-bold">Nombres y Apellidos</th>
                                    <th className="py-3.5 px-5 font-bold">Cargo / Especialidad</th>
                                    <th className="py-3.5 px-5 font-bold">Nivel</th>
                                    <th className="py-3.5 px-5 font-bold">DNI</th>
                                    <th className="py-3.5 px-5 font-bold text-center">Orden</th>
                                    <th className="py-3.5 px-5 font-bold text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-neutral-200/60 font-literata">
                                {displayedDocentes.length > 0 ? (
                                    displayedDocentes.map((docente) => (
                                        <tr key={docente.id} className="hover:bg-neutral-50/70 transition-colors">
                                            <td className="py-4 px-5 font-medium text-neutral-900">
                                                <div className="flex items-center gap-3">
                                                    <div className="w-8 h-8 rounded-xl bg-teal-50 text-ricardo-teal border border-teal-100/80 flex items-center justify-center font-mate font-bold text-xs shrink-0">
                                                        {docente.nombres_apellidos.charAt(0).toUpperCase()}
                                                    </div>
                                                    <span className="font-semibold">{docente.nombres_apellidos}</span>
                                                </div>
                                            </td>
                                            <td className="py-4 px-5 text-neutral-600">
                                                {docente.cargo}
                                            </td>
                                            <td className="py-4 px-5">
                                                <span className={`inline-block font-mate text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full border ${levelBadgeClass(docente.nivel)}`}>
                                                    {docente.nivel}
                                                </span>
                                            </td>
                                            <td className="py-4 px-5 text-neutral-500 font-mono text-xs">
                                                {docente.dni || '-'}
                                            </td>
                                            <td className="py-4 px-5 text-center text-neutral-400 font-mono text-xs">
                                                {docente.orden || 0}
                                            </td>
                                            <td className="py-4 px-5 text-right">
                                                <div className="flex items-center justify-end gap-2">
                                                    <button
                                                        type="button"
                                                        onClick={() => openEditModal(docente)}
                                                        className="p-2 rounded-xl text-neutral-500 hover:text-ricardo-teal hover:bg-teal-50 transition-colors cursor-pointer"
                                                        title="Editar datos del profesor"
                                                    >
                                                        <Edit3 className="w-4 h-4" />
                                                    </button>
                                                    <button
                                                        type="button"
                                                        onClick={() => handleDelete(docente.id, docente.nombres_apellidos)}
                                                        className="p-2 rounded-xl text-neutral-400 hover:text-ricardo-red hover:bg-red-50 transition-colors cursor-pointer"
                                                        title="Eliminar de la lista"
                                                    >
                                                        <Trash2 className="w-4 h-4" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan={6} className="py-12 text-center text-neutral-400">
                                            No se encontraron profesores con los criterios seleccionados.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {/* Modal de Crear / Editar Profesor */}
            {formModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/40 backdrop-blur-xs">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6">
                        
                        <div className="flex items-center justify-between border-b border-neutral-200/80 pb-4">
                            <div>
                                <h3 className="font-mate text-lg font-bold text-neutral-900 uppercase tracking-tight">
                                    {editingDocente ? 'Editar Profesor' : 'Registrar Nuevo Profesor'}
                                </h3>
                                <span className="text-xs text-neutral-500 font-literata">
                                    I.E.I. N° 31756 Ricardo Palma
                                </span>
                            </div>
                            <button
                                type="button"
                                onClick={() => setFormModalOpen(false)}
                                className="text-neutral-400 hover:text-neutral-700 p-1.5 rounded-xl hover:bg-neutral-100"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={handleFormSubmit} className="space-y-4">
                            {/* Nombres y Apellidos */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Nombres y Apellidos *
                                </label>
                                <input
                                    type="text"
                                    value={data.nombres_apellidos}
                                    onChange={(e) => setData('nombres_apellidos', e.target.value)}
                                    placeholder="Ej. RAMOS QUISPE, Maria Elena"
                                    required
                                    className="admin-input"
                                />
                                {errors.nombres_apellidos && <span className="text-xs text-ricardo-red">{errors.nombres_apellidos}</span>}
                            </div>

                            {/* Cargo */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Cargo o Especialidad *
                                </label>
                                <input
                                    type="text"
                                    value={data.cargo}
                                    onChange={(e) => setData('cargo', e.target.value)}
                                    placeholder="Ej. PROF. DE AULA / MATEMÁTICA"
                                    required
                                    className="admin-input"
                                />
                                {errors.cargo && <span className="text-xs text-ricardo-red">{errors.cargo}</span>}
                            </div>

                            {/* Nivel y DNI */}
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Nivel Educativo *
                                    </label>
                                    <select
                                        value={data.nivel}
                                        onChange={(e) => setData('nivel', e.target.value)}
                                        className="admin-input"
                                        required
                                    >
                                        <option value="Inicial">Inicial</option>
                                        <option value="Primaria">Primaria</option>
                                        <option value="Secundaria">Secundaria</option>
                                    </select>
                                    {errors.nivel && <span className="text-xs text-ricardo-red">{errors.nivel}</span>}
                                </div>

                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        DNI (Opcional)
                                    </label>
                                    <input
                                        type="text"
                                        value={data.dni}
                                        onChange={(e) => setData('dni', e.target.value)}
                                        placeholder="04021234"
                                        className="admin-input"
                                    />
                                    {errors.dni && <span className="text-xs text-ricardo-red">{errors.dni}</span>}
                                </div>
                            </div>

                            {/* Orden */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Orden de Visualización
                                </label>
                                <input
                                    type="number"
                                    value={data.orden}
                                    onChange={(e) => setData('orden', parseInt(e.target.value) || 0)}
                                    className="admin-input"
                                />
                                {errors.orden && <span className="text-xs text-ricardo-red">{errors.orden}</span>}
                            </div>

                            {/* Botones Únicos */}
                            <div className="pt-3 flex items-center justify-end gap-3 border-t border-neutral-200/80">
                                <button
                                    type="button"
                                    onClick={() => setFormModalOpen(false)}
                                    className="btn-admin-secondary"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="btn-admin-primary disabled:opacity-60"
                                >
                                    <Save className="w-4 h-4" />
                                    <span>{processing ? 'Guardando...' : (editingDocente ? 'Actualizar Profesor' : 'Registrar Profesor')}</span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            )}

            {/* Modal de Confirmación de Eliminación */}
            {deleteModal.open && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/40 backdrop-blur-xs">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-md w-full p-6 sm:p-7 space-y-5">
                        <div className="flex items-center gap-3.5">
                            <div className="w-11 h-11 rounded-2xl bg-red-50 text-ricardo-red border border-red-100 flex items-center justify-center shrink-0">
                                <AlertTriangle className="w-5 h-5" />
                            </div>
                            <div>
                                <h3 className="font-mate text-base font-bold text-neutral-900 uppercase tracking-tight">
                                    Eliminar Profesor
                                </h3>
                                <span className="text-xs text-neutral-400 font-literata">Esta acción no se puede deshacer</span>
                            </div>
                        </div>

                        <p className="text-sm text-neutral-600 font-literata leading-relaxed">
                            ¿Estás seguro de que deseas retirar de la lista de profesores a <strong className="text-neutral-900 font-semibold">"{deleteModal.name}"</strong>?
                        </p>

                        <div className="pt-2 flex items-center justify-end gap-3">
                            <button
                                type="button"
                                onClick={() => setDeleteModal({ open: false, id: null, name: '' })}
                                className="btn-admin-secondary"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                onClick={confirmDelete}
                                className="btn-admin-danger"
                            >
                                Sí, Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
