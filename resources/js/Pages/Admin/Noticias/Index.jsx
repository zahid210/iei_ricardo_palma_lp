import React, { useState } from 'react';
import { Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { 
    Plus, 
    Edit3, 
    Trash2, 
    ExternalLink, 
    Star, 
    Calendar, 
    User, 
    Search,
    AlertTriangle
} from 'lucide-react';

export default function Index({ noticias = [] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [deleteModal, setDeleteModal] = useState({ open: false, id: null, title: '' });

    const filteredNoticias = noticias.filter((n) => 
        n.titulo.toLowerCase().includes(searchTerm.toLowerCase()) ||
        (n.extracto && n.extracto.toLowerCase().includes(searchTerm.toLowerCase()))
    );

    const handleDelete = (id, title) => {
        setDeleteModal({ open: true, id, title });
    };

    const confirmDelete = () => {
        if (!deleteModal.id) return;
        router.delete(`/admin/noticias/${deleteModal.id}`, {
            onFinish: () => setDeleteModal({ open: false, id: null, title: '' })
        });
    };

    return (
        <AdminLayout title="Gestión de Noticias">
            <div className="space-y-6">
                
                {/* Encabezado y Botón Principal */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-neutral-200/80 shadow-2xs">
                    <div className="space-y-1">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Contenido Editorial
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Noticias Institucionales
                        </h1>
                        <p className="text-xs sm:text-sm text-neutral-500 font-literata">
                            Publicaciones, logros y comunicados oficiales mostrados en la sección de noticias.
                        </p>
                    </div>

                    <Link
                        href="/admin/noticias/create"
                        className="btn-admin-primary shrink-0 self-start sm:self-auto"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Nueva Noticia</span>
                    </Link>
                </div>

                {/* Buscador Rápido */}
                <div className="flex items-center gap-3 bg-white px-4 py-3 rounded-2xl border border-neutral-200/80 shadow-2xs">
                    <Search className="w-4 h-4 text-neutral-400 shrink-0" />
                    <input
                        type="text"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        placeholder="Buscar por título o contenido de la noticia..."
                        className="w-full text-xs sm:text-sm text-neutral-900 placeholder-neutral-400 outline-none bg-transparent"
                    />
                    {searchTerm && (
                        <button 
                            onClick={() => setSearchTerm('')}
                            className="text-xs text-neutral-400 hover:text-neutral-700 px-2"
                        >
                            Limpiar
                        </button>
                    )}
                </div>

                {/* Lista de Noticias */}
                <div className="bg-white rounded-3xl border border-neutral-200/80 shadow-2xs overflow-hidden">
                    {filteredNoticias.length > 0 ? (
                        <div className="divide-y divide-neutral-200/70">
                            {filteredNoticias.map((noticia) => {
                                const imgSrc = noticia.imagen
                                    ? (noticia.imagen.startsWith('http') || noticia.imagen.startsWith('/') ? noticia.imagen : `/${noticia.imagen}`)
                                    : '/images/galeria_1.jpg';

                                return (
                                    <div 
                                        key={noticia.id} 
                                        className="p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-5 hover:bg-neutral-50/60 transition-colors group"
                                    >
                                        <div className="flex items-start sm:items-center gap-4 sm:gap-5 min-w-0">
                                            {/* Miniatura */}
                                            <div className="relative w-20 h-20 sm:w-28 sm:h-20 rounded-2xl overflow-hidden border border-neutral-200/80 bg-neutral-100 shrink-0">
                                                <img 
                                                    src={imgSrc} 
                                                    alt={noticia.titulo} 
                                                    className="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                    onError={(e) => { e.currentTarget.src = '/images/galeria_1.jpg'; }}
                                                />
                                                {noticia.destacada && (
                                                    <span className="absolute top-1.5 left-1.5 bg-amber-400 text-neutral-950 p-1 rounded-lg shadow-xs" title="Noticia destacada">
                                                        <Star className="w-3 h-3 fill-current" />
                                                    </span>
                                                )}
                                            </div>

                                            {/* Información */}
                                            <div className="space-y-1.5 min-w-0">
                                                <div className="flex items-center gap-2 flex-wrap">
                                                    {noticia.destacada && (
                                                        <span className="bg-amber-50 text-amber-800 border border-amber-200/80 font-mate text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full">
                                                            Destacada
                                                        </span>
                                                    )}
                                                    <span className="text-xs text-neutral-400 flex items-center gap-1 font-literata">
                                                        <Calendar className="w-3 h-3 text-neutral-400" />
                                                        {noticia.fecha_publicacion ? new Date(noticia.fecha_publicacion).toLocaleDateString('es-PE', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'}
                                                    </span>
                                                    {noticia.autor && (
                                                        <span className="text-xs text-neutral-400 flex items-center gap-1 font-literata hidden sm:inline-flex">
                                                            <User className="w-3 h-3 text-neutral-400" />
                                                            {noticia.autor}
                                                        </span>
                                                    )}
                                                </div>

                                                <h3 className="font-mate text-base sm:text-lg font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors truncate">
                                                    {noticia.titulo}
                                                </h3>

                                                {noticia.extracto && (
                                                    <p className="text-xs text-neutral-500 font-literata line-clamp-1 max-w-2xl">
                                                        {noticia.extracto}
                                                    </p>
                                                )}
                                            </div>
                                        </div>

                                        {/* Acciones */}
                                        <div className="flex items-center gap-2 shrink-0 self-end md:self-center border-t md:border-t-0 pt-3 md:pt-0 border-neutral-100 w-full md:w-auto justify-end">
                                            <a
                                                href={`/noticias/${noticia.slug}`}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="btn-admin-secondary text-xs px-3 py-2"
                                                title="Ver noticia en la web pública"
                                            >
                                                <ExternalLink className="w-3.5 h-3.5" />
                                                <span className="hidden sm:inline">Ver</span>
                                            </a>

                                            <Link
                                                href={`/admin/noticias/${noticia.id}/edit`}
                                                className="btn-admin-secondary text-xs px-3 py-2 text-ricardo-teal hover:border-ricardo-teal"
                                                title="Editar contenido"
                                            >
                                                <Edit3 className="w-3.5 h-3.5" />
                                                <span>Editar</span>
                                            </Link>

                                            <button
                                                onClick={() => handleDelete(noticia.id, noticia.titulo)}
                                                className="p-2 rounded-xl text-neutral-400 hover:text-ricardo-red hover:bg-red-50 border border-transparent hover:border-red-200 transition-all cursor-pointer"
                                                title="Eliminar noticia"
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </button>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    ) : (
                        <div className="p-12 text-center space-y-3">
                            <div className="w-12 h-12 rounded-2xl bg-neutral-50 text-neutral-400 flex items-center justify-center mx-auto border border-neutral-200/80">
                                <Search className="w-5 h-5" />
                            </div>
                            <h3 className="font-mate text-base font-bold text-neutral-800 uppercase tracking-tight">
                                No se encontraron noticias
                            </h3>
                            <p className="text-xs text-neutral-500 font-literata max-w-sm mx-auto">
                                {searchTerm ? 'No hay resultados que coincidan con tu búsqueda.' : 'Aún no se han registrado noticias escolares.'}
                            </p>
                        </div>
                    )}
                </div>

            </div>

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
                                    Eliminar Noticia
                                </h3>
                                <span className="text-xs text-neutral-400 font-literata">Esta acción no se puede deshacer</span>
                            </div>
                        </div>

                        <p className="text-sm text-neutral-600 font-literata leading-relaxed">
                            ¿Estás seguro de que deseas eliminar permanentemente la noticia <strong className="text-neutral-900 font-semibold">"{deleteModal.title}"</strong>?
                        </p>

                        <div className="pt-2 flex items-center justify-end gap-3">
                            <button
                                type="button"
                                onClick={() => setDeleteModal({ open: false, id: null, title: '' })}
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
