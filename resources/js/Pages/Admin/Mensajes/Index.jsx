import React, { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { 
    Mail, 
    MailOpen, 
    Eye, 
    CheckCircle, 
    Clock, 
    Search, 
    Phone, 
    Inbox
} from 'lucide-react';

export default function Index({ mensajes = { data: [] }, noLeidos = 0 }) {
    const [filterStatus, setFilterStatus] = useState('todos');
    const [searchTerm, setSearchTerm] = useState('');

    const messagesList = mensajes.data || [];

    const filtered = messagesList.filter((msg) => {
        const matchesStatus = 
            filterStatus === 'todos' ||
            (filterStatus === 'no_leidos' && !msg.leido) ||
            (filterStatus === 'leidos' && msg.leido);

        const matchesSearch = 
            msg.nombre.toLowerCase().includes(searchTerm.toLowerCase()) ||
            msg.correo.toLowerCase().includes(searchTerm.toLowerCase()) ||
            (msg.telefono && msg.telefono.includes(searchTerm)) ||
            (msg.mensaje && msg.mensaje.toLowerCase().includes(searchTerm.toLowerCase()));

        return matchesStatus && matchesSearch;
    });

    const handleToggleLeido = (id) => {
        router.patch(`/admin/mensajes/${id}/toggle-leido`, {}, {
            preserveScroll: true,
        });
    };

    return (
        <AdminLayout title="Bandeja de Mensajes">
            <div className="space-y-6">
                
                {/* Encabezado */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-neutral-200/80 shadow-2xs">
                    <div className="space-y-1">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Buzón Institucional
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Consultas de la Comunidad
                        </h1>
                        <p className="text-xs sm:text-sm text-neutral-500 font-literata">
                            Historial oficial de mensajes enviados por padres y visitantes desde el formulario de contacto.
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
                    
                    {/* Tabs */}
                    <div className="flex items-center gap-1.5 p-1 bg-white rounded-2xl border border-neutral-200/80 shadow-2xs">
                        <button
                            onClick={() => setFilterStatus('todos')}
                            className={`px-4 py-2 rounded-xl text-xs font-mate uppercase tracking-wider font-bold transition-all cursor-pointer ${
                                filterStatus === 'todos'
                                    ? 'bg-ricardo-teal text-white shadow-xs'
                                    : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'
                            }`}
                        >
                            Todos ({messagesList.length})
                        </button>

                        <button
                            onClick={() => setFilterStatus('no_leidos')}
                            className={`px-4 py-2 rounded-xl text-xs font-mate uppercase tracking-wider font-bold transition-all cursor-pointer flex items-center gap-2 ${
                                filterStatus === 'no_leidos'
                                    ? 'bg-ricardo-red text-white shadow-xs'
                                    : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'
                            }`}
                        >
                            <span>No leídos</span>
                            {noLeidos > 0 && (
                                <span className={`text-[10px] px-1.5 py-0.2 rounded-full ${filterStatus === 'no_leidos' ? 'bg-white/20 text-white' : 'bg-red-100 text-ricardo-red'}`}>
                                    {noLeidos}
                                </span>
                            )}
                        </button>

                        <button
                            onClick={() => setFilterStatus('leidos')}
                            className={`px-4 py-2 rounded-xl text-xs font-mate uppercase tracking-wider font-bold transition-all cursor-pointer ${
                                filterStatus === 'leidos'
                                    ? 'bg-neutral-800 text-white shadow-xs'
                                    : 'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-50'
                            }`}
                        >
                            Leídos
                        </button>
                    </div>

                    {/* Buscador */}
                    <div className="flex items-center gap-2.5 bg-white px-3.5 py-2.5 rounded-2xl border border-neutral-200/80 shadow-2xs sm:w-72">
                        <Search className="w-4 h-4 text-neutral-400 shrink-0" />
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            placeholder="Buscar por nombre, correo..."
                            className="w-full text-xs text-neutral-900 placeholder-neutral-400 outline-none bg-transparent"
                        />
                    </div>
                </div>

                {/* Tabla de Mensajes */}
                <div className="bg-white rounded-3xl border border-neutral-200/80 shadow-2xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left text-xs sm:text-sm border-collapse">
                            <thead>
                                <tr className="border-b border-neutral-200/80 bg-[#FBFBFA] font-mate text-xs uppercase tracking-wider text-neutral-500">
                                    <th className="py-3.5 px-5 font-bold">Estado</th>
                                    <th className="py-3.5 px-5 font-bold">Fecha</th>
                                    <th className="py-3.5 px-5 font-bold">Remitente</th>
                                    <th className="py-3.5 px-5 font-bold">Contacto</th>
                                    <th className="py-3.5 px-5 font-bold">Nivel</th>
                                    <th className="py-3.5 px-5 font-bold">Mensaje</th>
                                    <th className="py-3.5 px-5 font-bold text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-neutral-200/60 font-literata">
                                {filtered.length > 0 ? (
                                    filtered.map((msg) => (
                                        <tr 
                                            key={msg.id} 
                                            className={`transition-colors ${
                                                !msg.leido ? 'bg-teal-50/30 hover:bg-teal-50/60' : 'hover:bg-neutral-50/70'
                                            }`}
                                        >
                                            <td className="py-4 px-5 whitespace-nowrap">
                                                {!msg.leido ? (
                                                    <span className="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 font-mate text-[10px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full">
                                                        <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                        Nuevo
                                                    </span>
                                                ) : (
                                                    <span className="inline-flex items-center gap-1 bg-neutral-100 text-neutral-600 font-mate text-[10px] font-semibold uppercase tracking-wider px-2.5 py-0.5 rounded-full">
                                                        Leído
                                                    </span>
                                                )}
                                            </td>

                                            <td className="py-4 px-5 whitespace-nowrap text-xs text-neutral-400">
                                                {msg.created_at ? new Date(msg.created_at).toLocaleDateString('es-PE', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '-'}
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
                                                    <div className="text-[11px] text-neutral-400 flex items-center gap-1">
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

                                                    <button
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
                                                </div>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan={7} className="py-12 text-center text-neutral-400">
                                            No se encontraron mensajes en esta vista.
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* Paginación si corresponde */}
                {mensajes.links && mensajes.links.length > 3 && (
                    <div className="flex items-center justify-center gap-1.5 pt-2">
                        {mensajes.links.map((link, idx) => (
                            <Link
                                key={idx}
                                href={link.url || '#'}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                                className={`px-3.5 py-1.5 rounded-xl text-xs font-mate font-semibold transition-all ${
                                    link.active
                                        ? 'bg-ricardo-teal text-white shadow-xs'
                                        : link.url
                                            ? 'bg-white border border-neutral-200 text-neutral-700 hover:bg-neutral-50'
                                            : 'bg-neutral-100 text-neutral-400 cursor-not-allowed'
                                }`}
                            />
                        ))}
                    </div>
                )}

            </div>
        </AdminLayout>
    );
}
