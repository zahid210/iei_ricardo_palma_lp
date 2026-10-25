import React, { useState } from 'react';
import { Link, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { 
    Plus, 
    Trash2, 
    Upload, 
    X, 
    Image as ImageIcon, 
    Calendar,
    AlertTriangle,
    Eye
} from 'lucide-react';

export default function Index({ fotos = [] }) {
    const [uploadModalOpen, setUploadModalOpen] = useState(false);
    const [previewImage, setPreviewImage] = useState(null);
    const [deleteModal, setDeleteModal] = useState({ open: false, id: null, title: '' });

    const { data, setData, post, processing, errors, reset } = useForm({
        titulo: '',
        imagen_file: null,
    });

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('imagen_file', file);
            setPreviewImage(URL.createObjectURL(file));
        }
    };

    const handleUploadSubmit = (e) => {
        e.preventDefault();
        post('/admin/galeria', {
            onSuccess: () => {
                setUploadModalOpen(false);
                setPreviewImage(null);
                reset();
            }
        });
    };

    const handleDelete = (id, title) => {
        setDeleteModal({ open: true, id, title });
    };

    const confirmDelete = () => {
        if (!deleteModal.id) return;
        router.delete(`/admin/galeria/${deleteModal.id}`, {
            onFinish: () => setDeleteModal({ open: false, id: null, title: '' })
        });
    };

    return (
        <AdminLayout title="Galería Fotográfica">
            <div className="space-y-6">
                
                {/* Encabezado y Botón Principal */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-neutral-200/80 shadow-2xs">
                    <div className="space-y-1">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Registro Visual Institucional
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Fotografías de la Galería
                        </h1>
                        <p className="text-xs sm:text-sm text-neutral-500 font-literata">
                            Imágenes escolares mostradas en la página de inicio y en la sección de Galería.
                        </p>
                    </div>

                    <button
                        onClick={() => setUploadModalOpen(true)}
                        className="btn-admin-primary shrink-0 self-start sm:self-auto"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Subir Fotografía</span>
                    </button>
                </div>

                {/* Cuadrícula de Fotografías */}
                {fotos.length > 0 ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        {fotos.map((foto) => {
                            const imgSrc = foto.url || (foto.imagen_path?.startsWith('images/') ? `/${foto.imagen_path}` : `/storage/${foto.imagen_path}`);

                            return (
                                <div
                                    key={foto.id}
                                    className="group bg-white rounded-3xl border border-neutral-200/80 overflow-hidden shadow-2xs hover:shadow-md transition-all flex flex-col"
                                >
                                    {/* Contenedor Imagen */}
                                    <div className="relative aspect-[4/3] bg-neutral-100 overflow-hidden">
                                        <img
                                            src={imgSrc}
                                            alt={foto.titulo}
                                            className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            onError={(e) => { e.currentTarget.src = '/images/galeria_1.jpg'; }}
                                        />
                                        <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-between p-3">
                                            <a
                                                href={imgSrc}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="p-2 rounded-xl bg-white/90 text-neutral-800 hover:bg-white text-xs font-semibold backdrop-blur-xs transition-colors"
                                                title="Ver imagen en tamaño completo"
                                            >
                                                <Eye className="w-4 h-4" />
                                            </a>

                                            <button
                                                onClick={() => handleDelete(foto.id, foto.titulo)}
                                                className="p-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition-colors shadow-xs"
                                                title="Eliminar fotografía"
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </button>
                                        </div>
                                    </div>

                                    {/* Pie con Título y Fecha */}
                                    <div className="p-4 flex-1 flex flex-col justify-between space-y-2">
                                        <h3 className="font-mate text-sm font-bold text-neutral-900 line-clamp-2 leading-snug">
                                            {foto.titulo}
                                        </h3>
                                        <div className="flex items-center justify-between text-[11px] text-neutral-400 font-literata pt-2 border-t border-neutral-100">
                                            <span className="flex items-center gap-1">
                                                <Calendar className="w-3 h-3 text-neutral-400" />
                                                {foto.created_at ? new Date(foto.created_at).toLocaleDateString('es-PE') : '-'}
                                            </span>
                                            <button
                                                onClick={() => handleDelete(foto.id, foto.titulo)}
                                                className="text-neutral-400 hover:text-ricardo-red transition-colors"
                                                title="Eliminar"
                                            >
                                                <Trash2 className="w-3.5 h-3.5" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            );
                        })}
                    </div>
                ) : (
                    <div className="bg-white rounded-3xl border border-neutral-200/80 p-12 text-center space-y-3 shadow-2xs">
                        <div className="w-12 h-12 rounded-2xl bg-teal-50 text-ricardo-teal flex items-center justify-center mx-auto border border-teal-100">
                            <ImageIcon className="w-5 h-5" />
                        </div>
                        <h3 className="font-mate text-base font-bold text-neutral-800 uppercase tracking-tight">
                            No hay fotografías en la galería
                        </h3>
                        <p className="text-xs text-neutral-500 font-literata max-w-sm mx-auto">
                            Comienza subiendo fotos de campeonatos, desfiles, escolta o actividades académicas.
                        </p>
                    </div>
                )}

            </div>

            {/* Modal para Subir Nueva Fotografía */}
            {uploadModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/40 backdrop-blur-xs">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6">
                        
                        <div className="flex items-center justify-between border-b border-neutral-200/80 pb-4">
                            <div>
                                <h3 className="font-mate text-lg font-bold text-neutral-900 uppercase tracking-tight">
                                    Subir Nueva Fotografía
                                </h3>
                                <span className="text-xs text-neutral-500 font-literata">
                                    Añade una foto oficial a la galería del colegio
                                </span>
                            </div>
                            <button
                                onClick={() => { setUploadModalOpen(false); setPreviewImage(null); reset(); }}
                                className="text-neutral-400 hover:text-neutral-700 p-1.5 rounded-xl hover:bg-neutral-100"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        <form onSubmit={handleUploadSubmit} className="space-y-5">
                            {/* Título de la Foto */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Título o Descripción de la Fotografía *
                                </label>
                                <input
                                    type="text"
                                    value={data.titulo}
                                    onChange={(e) => setData('titulo', e.target.value)}
                                    placeholder="Ej. Premiación concurso de declamación 2026"
                                    required
                                    className="admin-input"
                                />
                                {errors.titulo && <span className="text-xs text-ricardo-red">{errors.titulo}</span>}
                            </div>

                            {/* Dropzone Archivo */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Archivo de Imagen *
                                </label>
                                <div className="border-2 border-dashed border-neutral-200 hover:border-ricardo-teal rounded-2xl p-6 text-center transition-colors bg-[#FBFBFA]">
                                    {previewImage ? (
                                        <div className="space-y-3">
                                            <img
                                                src={previewImage}
                                                alt="Previsualización"
                                                className="h-44 w-full object-cover rounded-xl border border-neutral-200"
                                            />
                                            <label className="cursor-pointer font-mate text-xs text-ricardo-teal font-bold uppercase tracking-wider hover:underline block">
                                                Cambiar archivo
                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    onChange={handleFileChange}
                                                    className="hidden"
                                                />
                                            </label>
                                        </div>
                                    ) : (
                                        <label className="cursor-pointer space-y-2 block">
                                            <div className="w-12 h-12 rounded-2xl bg-teal-50 text-ricardo-teal flex items-center justify-center mx-auto border border-teal-100">
                                                <Upload className="w-5 h-5" />
                                            </div>
                                            <div className="text-xs font-semibold text-neutral-800 font-mate uppercase tracking-wider">
                                                Seleccionar Imagen
                                            </div>
                                            <p className="text-xs text-neutral-400 font-literata">
                                                JPG, PNG, WebP hasta 5 MB.
                                            </p>
                                            <input
                                                type="file"
                                                accept="image/*"
                                                onChange={handleFileChange}
                                                required
                                                className="hidden"
                                            />
                                        </label>
                                    )}
                                </div>
                                {errors.imagen_file && <span className="text-xs text-ricardo-red">{errors.imagen_file}</span>}
                            </div>

                            {/* Botones de acción */}
                            <div className="pt-3 border-t border-neutral-200/80 flex items-center justify-end gap-3">
                                <button
                                    type="button"
                                    onClick={() => { setUploadModalOpen(false); setPreviewImage(null); reset(); }}
                                    className="btn-admin-secondary"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="btn-admin-primary disabled:opacity-60"
                                >
                                    <Upload className="w-4 h-4" />
                                    <span>{processing ? 'Subiendo...' : 'Publicar Fotografía'}</span>
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
                                    Eliminar Fotografía
                                </h3>
                                <span className="text-xs text-neutral-400 font-literata">Esta acción no se puede deshacer</span>
                            </div>
                        </div>

                        <p className="text-sm text-neutral-600 font-literata leading-relaxed">
                            ¿Estás seguro de que deseas eliminar de la galería <strong className="text-neutral-900 font-semibold">"{deleteModal.title}"</strong>?
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
