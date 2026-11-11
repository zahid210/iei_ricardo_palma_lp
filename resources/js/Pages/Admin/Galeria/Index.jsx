import React, { useState, useRef, useEffect } from 'react';
import { useForm, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { 
    Plus, 
    Trash2, 
    Upload, 
    X, 
    Image as ImageIcon, 
    Calendar,
    AlertTriangle,
    Eye,
    Tag,
    Edit3,
    Check,
    Star
} from 'lucide-react';

export default function Index({ fotos = [], etiquetas = [] }) {
    const [uploadModalOpen, setUploadModalOpen] = useState(false);
    const [editModalOpen, setEditModalOpen] = useState(false);
    const [tagManagerOpen, setTagManagerOpen] = useState(false);
    const [editingFoto, setEditingFoto] = useState(null);

    const [previewImage, setPreviewImage] = useState(null);
    const [fileDetails, setFileDetails] = useState(null);
    const [isDragging, setIsDragging] = useState(false);
    const [clientError, setClientError] = useState('');
    const [deleteModal, setDeleteModal] = useState({ open: false, id: null, title: '' });
    const [deleteTagModal, setDeleteTagModal] = useState({ open: false, id: null, name: '' });

    const fileInputRef = useRef(null);
    const editFileInputRef = useRef(null);

    // Formulario de Creación
    const { 
        data: createData, 
        setData: setCreateData, 
        post: postCreate, 
        processing: processingCreate, 
        errors: createErrors, 
        reset: resetCreate, 
        clearErrors: clearCreateErrors 
    } = useForm({
        titulo: '',
        etiqueta_id: '',
        es_portada: false,
        imagen_file: null,
    });

    // Formulario de Edición
    const { 
        data: editData, 
        setData: setEditData, 
        post: postEdit, 
        processing: processingEdit, 
        errors: editErrors, 
        reset: resetEdit, 
        clearErrors: clearEditErrors 
    } = useForm({
        _method: 'PUT',
        titulo: '',
        etiqueta_id: '',
        es_portada: false,
        imagen_file: null,
    });

    // Formulario de Nueva Etiqueta
    const { 
        data: tagData, 
        setData: setTagData, 
        post: postTag, 
        processing: processingTag, 
        errors: tagErrors, 
        reset: resetTag 
    } = useForm({
        nombre: '',
    });

    // Limpiar preview en desmontaje
    useEffect(() => {
        return () => {
            if (previewImage && previewImage.startsWith('blob:')) {
                URL.revokeObjectURL(previewImage);
            }
        };
    }, [previewImage]);

    const formatFileSize = (bytes) => {
        if (!bytes || bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    };

    const processSelectedFile = (file, isEdit = false) => {
        setClientError('');
        if (!file) return;

        const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (!validTypes.includes(file.type) && !file.name.match(/\.(jpe?g|png|webp)$/i)) {
            setClientError('El archivo debe ser una imagen válida (JPG, PNG o WebP).');
            return;
        }

        const maxBytes = 10 * 1024 * 1024;
        if (file.size > maxBytes) {
            setClientError('La imagen no debe superar los 10 MB.');
            return;
        }

        if (previewImage && previewImage.startsWith('blob:')) {
            URL.revokeObjectURL(previewImage);
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            setPreviewImage(event.target?.result);
        };
        reader.readAsDataURL(file);

        setFileDetails({
            name: file.name,
            size: formatFileSize(file.size),
        });

        if (isEdit) {
            setEditData('imagen_file', file);
        } else {
            setCreateData('imagen_file', file);
        }
    };

    const openCreateModal = () => {
        resetCreate();
        setPreviewImage(null);
        setFileDetails(null);
        setClientError('');
        clearCreateErrors();
        setUploadModalOpen(true);
    };

    const openEditModal = (foto) => {
        setEditingFoto(foto);
        setEditData({
            _method: 'PUT',
            titulo: foto.titulo || '',
            etiqueta_id: foto.etiqueta_id || '',
            es_portada: Boolean(foto.es_portada),
            imagen_file: null,
        });
        setPreviewImage(foto.url);
        setFileDetails(null);
        setClientError('');
        clearEditErrors();
        setEditModalOpen(true);
    };

    const handleCreateSubmit = (e) => {
        e.preventDefault();
        setClientError('');

        if (!createData.imagen_file) {
            setClientError('Es necesario seleccionar una imagen para subir.');
            return;
        }

        postCreate('/admin/galeria', {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                setUploadModalOpen(false);
                resetCreate();
                setPreviewImage(null);
                setFileDetails(null);
            },
        });
    };

    const handleEditSubmit = (e) => {
        e.preventDefault();
        setClientError('');

        postEdit(`/admin/galeria/${editingFoto.id}`, {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                setEditModalOpen(false);
                setEditingFoto(null);
                setPreviewImage(null);
                setFileDetails(null);
            },
        });
    };

    const handleTogglePortada = (fotoId) => {
        router.patch(`/admin/galeria/${fotoId}/portada`, {}, {
            preserveScroll: true,
        });
    };

    const handleAddTagSubmit = (e) => {
        e.preventDefault();
        postTag('/admin/galeria/etiquetas', {
            preserveScroll: true,
            onSuccess: () => {
                resetTag();
            },
        });
    };

    const confirmDeleteTag = () => {
        if (!deleteTagModal.id) return;
        router.delete(`/admin/galeria/etiquetas/${deleteTagModal.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                setDeleteTagModal({ open: false, id: null, name: '' });
            },
        });
    };

    const confirmDeleteFoto = () => {
        if (!deleteModal.id) return;
        router.delete(`/admin/galeria/${deleteModal.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                setDeleteModal({ open: false, id: null, title: '' });
            },
        });
    };

    const formatDate = (dateVal) => {
        if (!dateVal) return '-';
        const d = new Date(dateVal);
        if (isNaN(d.getTime())) return String(dateVal);
        return d.toLocaleDateString('es-PE', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });
    };

    return (
        <AdminLayout title="Gestión de Galería">
            <div className="space-y-6">
                
                {/* Encabezado */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-neutral-200/80 shadow-2xs">
                    <div className="space-y-1">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Registro Audiovisual
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Galería Fotográfica
                        </h1>
                        <p className="text-xs sm:text-sm text-neutral-500 font-literata">
                            Gestiona las imágenes escolares, define la foto de portada para cada categoría y administra etiquetas.
                        </p>
                    </div>

                    <div className="flex flex-wrap items-center gap-2.5">
                        <button
                            type="button"
                            onClick={() => setTagManagerOpen(true)}
                            className="btn-admin-secondary text-xs flex items-center gap-1.5"
                        >
                            <Tag className="w-3.5 h-3.5" />
                            <span>Etiquetas ({etiquetas.length})</span>
                        </button>

                        <button
                            type="button"
                            onClick={openCreateModal}
                            className="btn-admin-primary text-xs flex items-center gap-1.5"
                        >
                            <Plus className="w-4 h-4" />
                            <span>Nueva Fotografía</span>
                        </button>
                    </div>
                </div>

                {/* Etiquetas Rápidas Disponibles */}
                {etiquetas.length > 0 && (
                    <div className="flex items-center gap-2 flex-wrap bg-white px-5 py-3 rounded-2xl border border-neutral-200/80">
                        <span className="font-mate text-xs uppercase tracking-wider font-bold text-neutral-400 mr-1 flex items-center gap-1">
                            <Tag className="w-3.5 h-3.5 text-neutral-400" />
                            Etiquetas:
                        </span>
                        {etiquetas.map((tag) => (
                            <span 
                                key={tag.id}
                                className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mate font-semibold bg-teal-50 text-ricardo-teal border border-teal-100"
                            >
                                <span>{tag.nombre}</span>
                                <span className="text-[10px] bg-teal-200/60 text-ricardo-teal px-1.5 py-0.2 rounded-full">
                                    {tag.fotos_count ?? 0}
                                </span>
                            </span>
                        ))}
                    </div>
                )}

                {/* Cuadrícula de Fotografías */}
                {fotos.length > 0 ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        {fotos.map((foto) => (
                            <div 
                                key={foto.id}
                                className={`group bg-white rounded-3xl border overflow-hidden shadow-2xs hover:shadow-md transition-all flex flex-col justify-between ${
                                    foto.es_portada ? 'border-amber-400 ring-2 ring-amber-400/20' : 'border-neutral-200/80'
                                }`}
                            >
                                <div>
                                    {/* Contenedor de la Imagen */}
                                    <div className="relative aspect-[4/3] bg-neutral-100 overflow-hidden">
                                        <img 
                                            src={foto.url} 
                                            alt={foto.titulo}
                                            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            loading="lazy"
                                        />
                                        
                                        {/* Badges de Etiqueta y Portada */}
                                        <div className="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                                            {foto.etiqueta && (
                                                <span className="font-mate text-[11px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-black/60 text-white backdrop-blur-md self-start">
                                                    {foto.etiqueta.nombre}
                                                </span>
                                            )}
                                            {foto.es_portada && (
                                                <span className="inline-flex items-center gap-1 font-mate text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-amber-500 text-white shadow-xs self-start">
                                                    <Star className="w-3 h-3 fill-white" />
                                                    Portada de categoría
                                                </span>
                                            )}
                                        </div>

                                        {/* Botón Ver tamaño completo en hover */}
                                        <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-start p-3 z-10">
                                            <a
                                                href={foto.url}
                                                target="_blank"
                                                rel="noreferrer"
                                                className="px-2.5 py-1.5 rounded-xl bg-white/95 text-neutral-800 hover:bg-white text-xs font-semibold backdrop-blur-xs transition-colors flex items-center gap-1.5 shadow-sm"
                                                title="Ver imagen en tamaño completo"
                                            >
                                                <Eye className="w-3.5 h-3.5" />
                                                <span>Ver tamaño completo</span>
                                            </a>
                                        </div>
                                    </div>

                                    {/* Título de la Foto */}
                                    <div className="p-4">
                                        <h3 className="font-mate text-sm font-bold text-neutral-900 leading-snug line-clamp-2" title={foto.titulo}>
                                            {foto.titulo}
                                        </h3>
                                    </div>
                                </div>

                                {/* Pie con Fecha y Botones */}
                                <div className="px-4 pb-4 pt-2 border-t border-neutral-100 flex items-center justify-between text-[11px] text-neutral-400 font-literata">
                                    <span className="flex items-center gap-1">
                                        <Calendar className="w-3 h-3 text-neutral-400" />
                                        {formatDate(foto.created_at)}
                                    </span>

                                    <div className="flex items-center gap-1">
                                        {/* Botón Asignar / Desmarcar como Portada (solo si tiene etiqueta) */}
                                        {foto.etiqueta_id && (
                                            <button
                                                type="button"
                                                onClick={() => handleTogglePortada(foto.id)}
                                                className={`p-1.5 rounded-lg transition-colors cursor-pointer ${
                                                    foto.es_portada
                                                        ? 'text-amber-600 bg-amber-50 hover:bg-amber-100'
                                                        : 'text-neutral-400 hover:text-amber-600 hover:bg-amber-50'
                                                }`}
                                                title={foto.es_portada ? 'Quitar como portada de categoría' : 'Marcar como portada de la categoría'}
                                            >
                                                <Star className={`w-3.5 h-3.5 ${foto.es_portada ? 'fill-amber-500' : ''}`} />
                                            </button>
                                        )}

                                        {/* Botón Editar: gris por defecto, verde al pasar el cursor */}
                                        <button
                                            type="button"
                                            onClick={() => openEditModal(foto)}
                                            className="inline-flex items-center gap-1 text-xs text-neutral-400 hover:text-emerald-700 hover:bg-emerald-50 px-2 py-1 rounded-lg transition-colors cursor-pointer"
                                            title="Editar fotografía"
                                        >
                                            <Edit3 className="w-3.5 h-3.5" />
                                            <span>Editar</span>
                                        </button>

                                        {/* Botón Eliminar: gris por defecto, rojo al pasar el cursor */}
                                        <button
                                            type="button"
                                            onClick={() => setDeleteModal({ open: true, id: foto.id, title: foto.titulo })}
                                            className="inline-flex items-center gap-1 text-xs text-neutral-400 hover:text-ricardo-red hover:bg-red-50 px-2 py-1 rounded-lg transition-colors cursor-pointer"
                                            title="Eliminar fotografía"
                                        >
                                            <Trash2 className="w-3.5 h-3.5" />
                                            <span>Eliminar</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="bg-white rounded-3xl border border-dashed border-neutral-300 p-16 text-center space-y-3">
                        <div className="w-12 h-12 rounded-2xl bg-neutral-100 text-neutral-400 flex items-center justify-center mx-auto">
                            <ImageIcon className="w-6 h-6" />
                        </div>
                        <h3 className="font-mate text-base font-bold text-neutral-800 uppercase tracking-tight">
                            No hay fotografías en la galería
                        </h3>
                        <p className="text-xs text-neutral-500 font-literata max-w-sm mx-auto">
                            Haz clic en el botón superior para subir la primera imagen con su etiqueta.
                        </p>
                    </div>
                )}

            </div>

            {/* Modal de Subida de Fotografía */}
            {uploadModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/40 backdrop-blur-xs overflow-y-auto">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-lg w-full p-6 sm:p-7 space-y-5 my-8">
                        <div className="flex items-center justify-between border-b border-neutral-200/80 pb-4">
                            <div>
                                <h3 className="font-mate text-lg font-bold text-neutral-900 uppercase tracking-tight">
                                    Subir Nueva Fotografía
                                </h3>
                                <span className="text-xs text-neutral-400 font-literata">Formatos admitidos: JPG, PNG o WebP (máx. 10MB)</span>
                            </div>
                            <button
                                type="button"
                                onClick={() => setUploadModalOpen(false)}
                                className="text-neutral-400 hover:text-neutral-700 p-1"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        {clientError && (
                            <div className="p-3.5 rounded-2xl bg-red-50 border border-red-200 text-xs text-ricardo-red font-medium flex items-center gap-2">
                                <AlertTriangle className="w-4 h-4 shrink-0" />
                                <span>{clientError}</span>
                            </div>
                        )}

                        <form onSubmit={handleCreateSubmit} className="space-y-4">
                            {/* Dropzone para Imagen */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Archivo de Imagen *
                                </label>

                                <input 
                                    ref={fileInputRef}
                                    type="file" 
                                    accept="image/jpeg,image/png,image/webp"
                                    onChange={(e) => {
                                        const file = e.target.files?.[0];
                                        if (file) processSelectedFile(file, false);
                                    }}
                                    className="hidden"
                                />

                                {previewImage ? (
                                    <div className="relative aspect-[16/10] bg-neutral-100 rounded-2xl overflow-hidden border border-neutral-200 group">
                                        <img src={previewImage} alt="Previsualización" className="w-full h-full object-cover" />
                                        <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                            <button
                                                type="button"
                                                onClick={() => fileInputRef.current?.click()}
                                                className="btn-admin-secondary text-xs"
                                            >
                                                Cambiar
                                            </button>
                                        </div>
                                    </div>
                                ) : (
                                    <div 
                                        onClick={() => fileInputRef.current?.click()}
                                        onDragOver={(e) => { e.preventDefault(); setIsDragging(true); }}
                                        onDragLeave={(e) => { e.preventDefault(); setIsDragging(false); }}
                                        onDrop={(e) => {
                                            e.preventDefault();
                                            setIsDragging(false);
                                            const file = e.dataTransfer.files?.[0];
                                            if (file) processSelectedFile(file, false);
                                        }}
                                        className={`border-2 border-dashed rounded-2xl p-6 text-center cursor-pointer transition-colors ${
                                            isDragging ? 'border-ricardo-teal bg-teal-50/50' : 'border-neutral-200 hover:border-neutral-300 bg-neutral-50/50'
                                        }`}
                                    >
                                        <Upload className="w-8 h-8 text-neutral-400 mx-auto mb-2" />
                                        <p className="text-xs font-semibold text-neutral-700 font-mate uppercase tracking-wider">
                                            Haz clic o arrastra una imagen aquí
                                        </p>
                                        <p className="text-[11px] text-neutral-400 font-literata mt-0.5">
                                            JPG, PNG o WebP hasta 10 MB
                                        </p>
                                    </div>
                                )}
                                {createErrors.imagen_file && <span className="text-xs text-ricardo-red">{createErrors.imagen_file}</span>}
                            </div>

                            {/* Título */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Título de la Fotografía *
                                </label>
                                <input
                                    type="text"
                                    value={createData.titulo}
                                    onChange={(e) => setCreateData('titulo', e.target.value)}
                                    placeholder="Ej. Ceremonia Cívica del Aniversario Escolar"
                                    className="admin-input"
                                    required
                                />
                                {createErrors.titulo && <span className="text-xs text-ricardo-red">{createErrors.titulo}</span>}
                            </div>

                            {/* Etiqueta */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Etiqueta / Categoría
                                </label>
                                <select
                                    value={createData.etiqueta_id}
                                    onChange={(e) => setCreateData('etiqueta_id', e.target.value)}
                                    className="admin-input"
                                >
                                    <option value="">Sin etiqueta</option>
                                    {etiquetas.map((t) => (
                                        <option key={t.id} value={t.id}>
                                            {t.nombre}
                                        </option>
                                    ))}
                                </select>
                                {createErrors.etiqueta_id && <span className="text-xs text-ricardo-red">{createErrors.etiqueta_id}</span>}
                            </div>

                            {/* Portada checkbox */}
                            {createData.etiqueta_id && (
                                <label className="flex items-center gap-2 cursor-pointer pt-1">
                                    <input
                                        type="checkbox"
                                        checked={createData.es_portada}
                                        onChange={(e) => setCreateData('es_portada', e.target.checked)}
                                        className="rounded border-neutral-300 text-ricardo-teal focus:ring-ricardo-teal"
                                    />
                                    <span className="text-xs font-literata text-neutral-700">
                                        Definir como foto de portada para esta etiqueta
                                    </span>
                                </label>
                            )}

                            <div className="pt-3 flex items-center justify-end gap-3 border-t border-neutral-200/80">
                                <button
                                    type="button"
                                    onClick={() => setUploadModalOpen(false)}
                                    className="btn-admin-secondary"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={processingCreate}
                                    className="btn-admin-primary"
                                >
                                    {processingCreate ? 'Publicando...' : 'Publicar Fotografía'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Modal de Edición de Fotografía */}
            {editModalOpen && editingFoto && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/40 backdrop-blur-xs overflow-y-auto">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-lg w-full p-6 sm:p-7 space-y-5 my-8">
                        <div className="flex items-center justify-between border-b border-neutral-200/80 pb-4">
                            <div>
                                <h3 className="font-mate text-lg font-bold text-neutral-900 uppercase tracking-tight">
                                    Editar Fotografía
                                </h3>
                                <span className="text-xs text-neutral-400 font-literata">Modifica el título, etiqueta o reemplaza la imagen</span>
                            </div>
                            <button
                                type="button"
                                onClick={() => setEditModalOpen(false)}
                                className="text-neutral-400 hover:text-neutral-700 p-1"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        {clientError && (
                            <div className="p-3.5 rounded-2xl bg-red-50 border border-red-200 text-xs text-ricardo-red font-medium flex items-center gap-2">
                                <AlertTriangle className="w-4 h-4 shrink-0" />
                                <span>{clientError}</span>
                            </div>
                        )}

                        <form onSubmit={handleEditSubmit} className="space-y-4">
                            {/* Previsualización y Reemplazo */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Imagen Actual / Nueva
                                </label>
                                <input 
                                    ref={editFileInputRef}
                                    type="file" 
                                    accept="image/jpeg,image/png,image/webp"
                                    onChange={(e) => {
                                        const file = e.target.files?.[0];
                                        if (file) processSelectedFile(file, true);
                                    }}
                                    className="hidden"
                                />

                                <div className="relative aspect-[16/10] bg-neutral-100 rounded-2xl overflow-hidden border border-neutral-200 group">
                                    <img src={previewImage} alt="Foto" className="w-full h-full object-cover" />
                                    <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                        <button
                                            type="button"
                                            onClick={() => editFileInputRef.current?.click()}
                                            className="btn-admin-secondary text-xs"
                                        >
                                            Reemplazar Imagen
                                        </button>
                                    </div>
                                </div>
                                {fileDetails && (
                                    <span className="text-[11px] text-teal-700 font-literata block">
                                        Nueva imagen seleccionada: {fileDetails.name} ({fileDetails.size})
                                    </span>
                                )}
                                {editErrors.imagen_file && <span className="text-xs text-ricardo-red">{editErrors.imagen_file}</span>}
                            </div>

                            {/* Título */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Título *
                                </label>
                                <input
                                    type="text"
                                    value={editData.titulo}
                                    onChange={(e) => setEditData('titulo', e.target.value)}
                                    className="admin-input"
                                    required
                                />
                                {editErrors.titulo && <span className="text-xs text-ricardo-red">{editErrors.titulo}</span>}
                            </div>

                            {/* Etiqueta */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Etiqueta / Categoría
                                </label>
                                <select
                                    value={editData.etiqueta_id}
                                    onChange={(e) => setEditData('etiqueta_id', e.target.value)}
                                    className="admin-input"
                                >
                                    <option value="">Sin etiqueta</option>
                                    {etiquetas.map((t) => (
                                        <option key={t.id} value={t.id}>
                                            {t.nombre}
                                        </option>
                                    ))}
                                </select>
                                {editErrors.etiqueta_id && <span className="text-xs text-ricardo-red">{editErrors.etiqueta_id}</span>}
                            </div>

                            {/* Portada checkbox */}
                            {editData.etiqueta_id && (
                                <label className="flex items-center gap-2 cursor-pointer pt-1">
                                    <input
                                        type="checkbox"
                                        checked={editData.es_portada}
                                        onChange={(e) => setEditData('es_portada', e.target.checked)}
                                        className="rounded border-neutral-300 text-ricardo-teal focus:ring-ricardo-teal"
                                    />
                                    <span className="text-xs font-literata text-neutral-700">
                                        Definir como foto de portada para esta etiqueta
                                    </span>
                                </label>
                            )}

                            <div className="pt-3 flex items-center justify-end gap-3 border-t border-neutral-200/80">
                                <button
                                    type="button"
                                    onClick={() => setEditModalOpen(false)}
                                    className="btn-admin-secondary"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={processingEdit}
                                    className="btn-admin-primary"
                                >
                                    {processingEdit ? 'Guardando...' : 'Guardar Cambios'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Modal de Gestión de Etiquetas */}
            {tagManagerOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/40 backdrop-blur-xs">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-md w-full p-6 sm:p-7 space-y-5">
                        <div className="flex items-center justify-between border-b border-neutral-200/80 pb-3">
                            <div className="flex items-center gap-2.5">
                                <Tag className="w-5 h-5 text-ricardo-teal" />
                                <h3 className="font-mate text-base font-bold text-neutral-900 uppercase tracking-tight">
                                    Administrar Etiquetas
                                </h3>
                            </div>
                            <button
                                type="button"
                                onClick={() => setTagManagerOpen(false)}
                                className="text-neutral-400 hover:text-neutral-700 p-1"
                            >
                                <X className="w-5 h-5" />
                            </button>
                        </div>

                        {/* Formulario Agregar Etiqueta */}
                        <form onSubmit={handleAddTagSubmit} className="flex items-center gap-2">
                            <input
                                type="text"
                                value={tagData.nombre}
                                onChange={(e) => setTagData('nombre', e.target.value)}
                                placeholder="Nueva etiqueta (Ej. Ferias)..."
                                className="admin-input flex-1"
                                required
                            />
                            <button
                                type="submit"
                                disabled={processingTag}
                                className="btn-admin-primary text-xs shrink-0"
                            >
                                <Plus className="w-4 h-4" />
                                <span>Agregar</span>
                            </button>
                        </form>
                        {tagErrors.nombre && <span className="text-xs text-ricardo-red block">{tagErrors.nombre}</span>}

                        {/* Lista de Etiquetas Existentes */}
                        <div className="space-y-2 max-h-60 overflow-y-auto pr-1">
                            <span className="font-mate text-xs uppercase tracking-wider font-semibold text-neutral-400 block">
                                Etiquetas Activas ({etiquetas.length})
                            </span>
                            {etiquetas.length > 0 ? (
                                <div className="divide-y divide-neutral-100">
                                    {etiquetas.map((t) => (
                                        <div key={t.id} className="py-2.5 flex items-center justify-between">
                                            <div className="space-x-2">
                                                <span className="font-mate text-sm font-semibold text-neutral-800">
                                                    {t.nombre}
                                                </span>
                                                <span className="text-[11px] text-neutral-400 font-literata">
                                                    ({t.fotos_count ?? 0} fotos)
                                                </span>
                                            </div>
                                            <button
                                                type="button"
                                                onClick={() => setDeleteTagModal({ open: true, id: t.id, name: t.nombre })}
                                                className="p-1.5 rounded-lg text-neutral-400 hover:text-ricardo-red hover:bg-red-50 transition-colors cursor-pointer"
                                                title="Eliminar etiqueta"
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </button>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-xs text-neutral-400 font-literata py-4 text-center">
                                    No hay etiquetas creadas todavía.
                                </p>
                            )}
                        </div>

                        <div className="pt-2 border-t border-neutral-100 flex justify-end">
                            <button
                                type="button"
                                onClick={() => setTagManagerOpen(false)}
                                className="btn-admin-secondary text-xs"
                            >
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Modal de Eliminación de Fotografía */}
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
                                <span className="text-xs text-neutral-400 font-literata">Esta acción retirará la imagen de la galería pública</span>
                            </div>
                        </div>

                        <p className="text-sm text-neutral-600 font-literata leading-relaxed">
                            ¿Estás seguro de que deseas retirar la fotografía <strong className="text-neutral-900 font-semibold">"{deleteModal.title}"</strong>?
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
                                onClick={confirmDeleteFoto}
                                className="btn-admin-danger"
                            >
                                Sí, Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* Modal de Eliminación de Etiqueta */}
            {deleteTagModal.open && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/40 backdrop-blur-xs">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-md w-full p-6 sm:p-7 space-y-5">
                        <div className="flex items-center gap-3.5">
                            <div className="w-11 h-11 rounded-2xl bg-red-50 text-ricardo-red border border-red-100 flex items-center justify-center shrink-0">
                                <AlertTriangle className="w-5 h-5" />
                            </div>
                            <div>
                                <h3 className="font-mate text-base font-bold text-neutral-900 uppercase tracking-tight">
                                    Eliminar Etiqueta
                                </h3>
                                <span className="text-xs text-neutral-400 font-literata">Las fotografías conservarán su archivo pero quedarán sin esta etiqueta</span>
                            </div>
                        </div>

                        <p className="text-sm text-neutral-600 font-literata leading-relaxed">
                            ¿Estás seguro de que deseas eliminar la etiqueta <strong className="text-neutral-900 font-semibold">"{deleteTagModal.name}"</strong>?
                        </p>

                        <div className="pt-2 flex items-center justify-end gap-3">
                            <button
                                type="button"
                                onClick={() => setDeleteTagModal({ open: false, id: null, name: '' })}
                                className="btn-admin-secondary"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                onClick={confirmDeleteTag}
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
