import React, { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { 
    Mail, 
    MailOpen, 
    Eye, 
    Search, 
    Phone, 
    Archive,
    ArchiveRestore,
    Trash2,
    AlertTriangle,
    X
} from 'lucide-react';

export default function Index({ 
    mensajes = { data: [], links: [] }, 
    noLeidos = 0, 
    leidos = 0, 
    archivados = 0,
    totalCount = 0,
    filters = { filtro: 'todos', q: '' }
}) {
    const [searchTerm, setSearchTerm] = useState(filters.q || '');
    const [deleteModal, setDeleteModal] = useState({ open: false, id: null, name: '' });
    const currentFiltro = filters.filtro || 'todos';

    const handleFilterChange = (nuevoFiltro) => {
        router.get('/admin/mensajes', {
            filtro: nuevoFiltro,
            q: searchTerm
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleSearchSubmit = (e) => {
        e.preventDefault();
        router.get('/admin/mensajes', {
            filtro: currentFiltro,
            q: searchTerm
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleClearSearch = () => {
        setSearchTerm('');
        router.get('/admin/mensajes', {
            filtro: currentFiltro,
            q: ''
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const handleToggleLeido = (id) => {
        router.patch(`/admin/mensajes/${id}/toggle-leido`, {}, {
            preserveScroll: true,
        });
    };

    const handleToggleArchivado = (id) => {
        router.patch(`/admin/mensajes/${id}/toggle-archivado`, {}, {
            preserveScroll: true,
        });
    };

    const openDeleteModal = (msg) => {
        setDeleteModal({
            open: true,
            id: msg.id,
            name: msg.nombre
        });
    };

    const confirmDelete = () => {
        if (!deleteModal.id) return;
        router.delete(`/admin/mensajes/${deleteModal.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                setDeleteModal({ open: false, id: null, name: '' });
            }
        });
    };

    const messagesList = mensajes.data || [];

    const formatMessageDate = (dateVal) => {
        if (!dateVal) return '-';
        if (typeof dateVal === 'string' && /^\d{2}\/\d{2}\/\d{4}/.test(dateVal)) {
            return dateVal;
        }
        const d = new Date(dateVal);
        if (isNaN(d.getTime())) return String(dateVal);
        return d.toLocaleDateString('es-PE', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    return (
        <AdminLayout title="Buzón de Mensajes">
            <div className="space-y-6">
                
                {/* Encabezado */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-neutral-200/80 shadow-2xs">
                    <div className="space-y-1">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Buzón del Colegio
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Mensajes y Consultas
                        </h1>
                        <p className="text-xs sm:text-sm text-neutral-500 font-literata">
                            Mensajes enviados por padres de familia y vecinos desde la página de contacto.
                        </p>
                    </div>

                    <div className="flex items-center gap-2 self-start sm:self-auto">
                        <div className="px-4 py-2.5 rounded-2xl bg-teal-50 border border-teal-100/80 flex items-center gap-2.5">
                            <Mail className="w-4 h-4 text-ricardo-teal" />
                            <span className="text-xs font-mate uppercase tracking-wider font-bold text-ricardo-teal">
                                {noLeidos} Pendientes
                            </span>
                        </div>
                    </div>
                </div>

                {/* Filtros de Estado y Buscador */}
                <div className="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                    
                    {/* Tabs con conteos reales de la base de datos */}
                    <div className="flex flex-wrap items-center gap-1.5 p-1 bg-white rounded-2xl border border-neutral-200/80 shadow-2xs">
                        <button
                            type="button"
                            onClick={() => handleFilterChange('todos')}
                            className={`px-4 py-2 rounded-xl text-xs font-mate uppercase tracking-wider font-bold transition-all cursor-pointer ${
                                currentFiltro === 'todos'
                                    ? 'bg-ricardo-teal text-white shadow-xs'
                                    : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'
                            }`}
                        >
                            Bandeja ({totalCount})
                        </button>

                        <button
                            type="button"
                            onClick={() => handleFilterChange('no_leidos')}
                            className={`px-4 py-2 rounded-xl text-xs font-mate uppercase tracking-wider font-bold transition-all cursor-pointer flex items-center gap-2 ${
                                currentFiltro === 'no_leidos'
                                    ? 'bg-ricardo-red text-white shadow-xs'
                                    : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'
                            }`}
                        >
                            <span>No leídos</span>
                            {noLeidos > 0 && (
                                <span className={`text-[10px] px-1.5 py-0.2 rounded-full ${currentFiltro === 'no_leidos' ? 'bg-white/20 text-white' : 'bg-red-100 text-ricardo-red'}`}>
                                    {noLeidos}
                                </span>
                            )}
                        </button>

                        <button
                            type="button"
                            onClick={() => handleFilterChange('leidos')}
                            className={`px-4 py-2 rounded-xl text-xs font-mate uppercase tracking-wider font-bold transition-all cursor-pointer ${
                                currentFiltro === 'leidos'
                                    ? 'bg-neutral-800 text-white shadow-xs'
                                    : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'
                            }`}
                        >
                            Leídos ({leidos})
                        </button>

                        <button
                            type="button"
                            onClick={() => handleFilterChange('archivados')}
                            className={`px-4 py-2 rounded-xl text-xs font-mate uppercase tracking-wider font-bold transition-all cursor-pointer ${
                                currentFiltro === 'archivados'
                                    ? 'bg-amber-700 text-white shadow-xs'
                                    : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'
                            }`}
                        >
                            Archivados ({archivados})
                        </button>
                    </div>

                    {/* Buscador Rápido con Submit */}
                    <form onSubmit={handleSearchSubmit} className="flex items-center gap-2.5 bg-white px-3.5 py-2.5 rounded-2xl border border-neutral-200/80 shadow-2xs sm:w-80">
                        <Search className="w-4 h-4 text-neutral-400 shrink-0" />
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder="Buscar por nombre, correo..."
                            className="w-full text-xs text-neutral-900 placeholder-neutral-400 outline-none bg-transparent font-literata"
                        />
                        {searchTerm && (
                            <button type="button" onClick={handleClearSearch} className="text-xs text-neutral-400 hover:text-neutral-700">
                                <X className="w-3.5 h-3.5" />
                            </button>
                        )}
                    </form>
                </div>

                {/* Tabla de Mensajes */}
                <div className="bg-white rounded-3xl border border-neutral-200/80 shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs sm:text-sm border-collapse">
                            <thead>
                                <tr className="border-b border-neutral-200/80 bg-[#FBFBFA] font-mate text-xs uppercase tracking-wider text-neutral-500">
                                    <th className="py-3.5 px-5 font-bold w-12 text-center">Estado</th>
                                    <th className="py-3.5 px-5 font-bold">Fecha</th>
                                    <th className="py-3.5 px-5 font-bold">Remitente</th>
                                    <th className="py-3.5 px-5 font-bold">Contacto</th>
                                    <th className="py-3.5 px-5 font-bold">Nivel</th>
                                    <th className="py-3.5 px-5 font-bold">Mensaje</th>
                                    <th className="py-3.5 px-5 font-bold text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-neutral-200/60 font-literata">
                                {messagesList.length > 0 ? (
                                    messagesList.map((msg) => (
                                        <tr 
                                            key={msg.id} 
                                            className={`transition-colors ${
                                                !msg.leido ? 'bg-amber-50/25 font-medium' : 'hover:bg-neutral-50/70'
                                            }`}
                                        >
                                            <td className="py-4 px-5 text-center">
                                                {msg.archivado ? (
                                                    <span className="inline-block w-2.5 h-2.5 rounded-full bg-amber-500" title="Mensaje archivado" />
                                                ) : !msg.leido ? (
                                                    <span className="inline-block w-2.5 h-2.5 rounded-full bg-ricardo-red" title="Mensaje no leído" />
                                                ) : (
                                                    <span className="inline-block w-2 h-2 rounded-full bg-neutral-300" title="Mensaje leído" />
                                                )}
                                            </td>

                                            <td className="py-4 px-5 whitespace-nowrap text-xs text-neutral-400">
                                                {formatMessageDate(msg.created_at)}
                                            </td>

                                            <td className="py-4 px-5 font-medium text-neutral-900 whitespace-nowrap">
                                                <span className="font-semibold">{msg.nombre}</span>
                                            </td>

                                            <td className="py-4 px-5 text-neutral-600 whitespace-nowrap space-y-0.5">
                                                <div>
                                                    <a href={`mailto:${msg.correo}`} className="text-ricardo-teal hover:underline text-xs">
                                                        {msg.correo}
                                                    </a>
                                                </div>
                                                {msg.telefono && (
                                                    <div className="text-[11px] text-neutral-400 flex items-center gap-1 font-mono">
                                                        <Phone className="w-3 h-3 text-neutral-400" />
                                                        <span>{msg.telefono}</span>
                                                    </div>
                                                )}
                                            </td>

                                            <td className="py-4 px-5 whitespace-nowrap">
                                                {msg.nivel ? (
                                                    <span className="inline-block font-mate text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-lg bg-neutral-100 text-neutral-700">
                                                        {msg.nivel}
                                                    </span>
                                                ) : (
                                                    <span className="text-neutral-400">-</span>
                                                )}
                                            </td>

                                            <td className="py-4 px-5 max-w-xs">
                                                <p className="truncate text-xs text-neutral-600" title={msg.mensaje}>
                                                    {msg.mensaje}
                                                </p>
                                            </td>

                                            <td className="py-4 px-5 text-right whitespace-nowrap">
                                                <div className="flex items-center justify-end gap-2">
                                                    <Link
                                                        href={`/admin/mensajes/${msg.id}`}
                                                        className="btn-admin-secondary text-xs px-3 py-1.5"
                                                        title="Ver detalle del mensaje"
                                                    >
                                                        <Eye className="w-3.5 h-3.5" />
                                                        <span>Ver</span>
                                                    </Link>

                                                    {/* Botón Marcar leído/no leído: solo si NO está archivado */}
                                                    {!msg.archivado && (
                                                        <button
                                                            type="button"
                                                            onClick={() => handleToggleLeido(msg.id)}
                                                            className={`p-1.5 rounded-xl border transition-colors cursor-pointer ${
                                                                msg.leido
                                                                    ? 'text-neutral-400 hover:text-neutral-700 border-neutral-200 hover:bg-neutral-100'
                                                                    : 'text-ricardo-teal hover:bg-teal-50 border-teal-200'
                                                            }`}
                                                            title={msg.leido ? 'Marcar como no leído' : 'Marcar como leído'}
                                                        >
                                                            {msg.leido ? <Mail className="w-3.5 h-3.5" /> : <MailOpen className="w-3.5 h-3.5" />}
                                                        </button>
                                                    )}

                                                    {/* Botón Archivar / Desarchivar */}
                                                    <button
                                                        type="button"
                                                        onClick={() => handleToggleArchivado(msg.id)}
                                                        className={`p-1.5 rounded-xl border transition-colors cursor-pointer ${
                                                            msg.archivado
                                                                ? 'text-amber-700 hover:bg-amber-50 border-amber-300'
                                                                : 'text-neutral-400 hover:text-neutral-700 border-neutral-200 hover:bg-neutral-100'
                                                        }`}
                                                        title={msg.archivado ? 'Desarchivar (devolver a bandeja)' : 'Archivar consulta'}
                                                    >
                                                        {msg.archivado ? <ArchiveRestore className="w-3.5 h-3.5" /> : <Archive className="w-3.5 h-3.5" />}
                                                    </button>

                                                    {/* Botón Eliminar: solo visible cuando el mensaje está archivado */}
                                                    {msg.archivado && (
                                                        <button
                                                            type="button"
                                                            onClick={() => openDeleteModal(msg)}
                                                            className="p-1.5 rounded-xl border border-red-200 text-ricardo-red hover:bg-red-50 transition-colors cursor-pointer"
                                                            title="Eliminar mensaje permanentemente"
                                                        >
                                                            <Trash2 className="w-3.5 h-3.5" />
                                                        </button>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan={7} className="py-12 text-center text-neutral-400">
                                            {currentFiltro === 'archivados'
                                                ? 'No hay consultas archivadas.'
                                                : 'No se encontraron mensajes en esta vista.'}
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* Paginación Segura */}
                {mensajes.links && mensajes.links.length > 3 && (
                    <div className="flex items-center justify-center gap-1.5 pt-2">
                        {mensajes.links.map((link, idx) => {
                            if (!link.url) {
                                return (
                                    <span
                                        key={idx}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                        className="px-3.5 py-1.5 rounded-xl text-xs font-mate font-semibold bg-neutral-100 text-neutral-400 cursor-not-allowed select-none"
                                    />
                                );
                            }

                            return (
                                <Link
                                    key={idx}
                                    href={link.url}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                    className={`px-3.5 py-1.5 rounded-xl text-xs font-mate font-semibold transition-all ${
                                        link.active
                                            ? 'bg-ricardo-teal text-white shadow-xs'
                                            : 'bg-white border border-neutral-200 text-neutral-700 hover:bg-neutral-50'
                                    }`}
                                />
                            );
                        })}
                    </div>
                )}

            </div>

            {/* Modal de Confirmación de Eliminación en Pantalla */}
            {deleteModal.open && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/40 backdrop-blur-xs">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-md w-full p-6 sm:p-7 space-y-5">
                        <div className="flex items-center gap-3.5">
                            <div className="w-11 h-11 rounded-2xl bg-red-50 text-ricardo-red border border-red-100 flex items-center justify-center shrink-0">
                                <AlertTriangle className="w-5 h-5" />
                            </div>
                            <div>
                                <h3 className="font-mate text-base font-bold text-neutral-900 uppercase tracking-tight">
                                    Eliminar Consulta
                                </h3>
                                <span className="text-xs text-neutral-400 font-literata">Esta acción no se puede deshacer</span>
                            </div>
                        </div>

                        <p className="text-sm text-neutral-600 font-literata leading-relaxed">
                            ¿Estás seguro de que deseas eliminar permanentemente la consulta de <strong className="text-neutral-900 font-semibold">"{deleteModal.name}"</strong>?
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
