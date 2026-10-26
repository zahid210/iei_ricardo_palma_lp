import React, { useState, useRef, useEffect } from 'react';
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
    Eye,
    RefreshCw,
    FileCheck
} from 'lucide-react';

export default function Index({ fotos = [] }) {
    const [uploadModalOpen, setUploadModalOpen] = useState(false);
    const [previewImage, setPreviewImage] = useState(null);
    const [fileDetails, setFileDetails] = useState(null);
    const [isDragging, setIsDragging] = useState(false);
    const [clientError, setClientError] = useState('');
    const [deleteModal, setDeleteModal] = useState({ open: false, id: null, title: '' });

    const fileInputRef = useRef(null);

    const { data, setData, post, processing, errors, reset, clearErrors } = useForm({
        titulo: '',
        imagen_file: null,
    });

    // Limpiar blob URLs para evitar fugas de memoria
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

    const processSelectedFile = (file) => {
        setClientError('');

        if (!file) return;

        // Validar tipo de archivo
        const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (!validTypes.includes(file.type) && !file.name.match(/\.(jpe?g|png|webp)$/i)) {
            setClientError('El archivo debe ser una imagen válida (JPG, PNG o WebP).');
            return;
        }

        // Validar tamaño máximo (10 MB)
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
        setData('imagen_file', file);
    };

    const handleFileChange = (e) => {
        const file = e.target.files?.[0];
        if (file) {
            processSelectedFile(file);
        }
    };

    const handleDragOver = (e) => {
        e.preventDefault();
        e.stopPropagation();
        setIsDragging(true);
    };

    const handleDragLeave = (e) => {
        e.preventDefault();
        e.stopPropagation();
        setIsDragging(false);
    };

    const handleDrop = (e) => {
        e.preventDefault();
        e.stopPropagation();
        setIsDragging(false);

        const file = e.dataTransfer.files?.[0];
        if (file) {
            processSelectedFile(file);
        }
    };

    const handleClearFile = () => {
        if (previewImage && previewImage.startsWith('blob:')) {
            URL.revokeObjectURL(previewImage);
        }
        setPreviewImage(null);
        setFileDetails(null);
        setClientError('');
        setData('imagen_file', null);
        if (fileInputRef.current) {
            fileInputRef.current.value = '';
        }
    };

    const closeModal = () => {
        handleClearFile();
        reset();
        clearErrors();
        setUploadModalOpen(false);
    };

    const handleUploadSubmit = (e) => {
        e.preventDefault();
        setClientError('');

        if (!data.imagen_file) {
            setClientError('Por favor selecciona una imagen para subir.');
            return;
        }

        post('/admin/galeria', {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
            },
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
        <AdminLayout title="Galería de Fotos">
            <div className="space-y-6">
                
                {/* Encabezado y Botón Principal */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-neutral-200/80 shadow-2xs">
                    <div className="space-y-1">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Registro Visual Escolar
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Galería de Fotos
                        </h1>
                        <p className="text-xs sm:text-sm text-neutral-500 font-literata">
                            Fotos de actividades, ceremonias, concursos y vivencias de la comunidad educativa.
                        </p>
                    </div>

                    <button
                        type="button"
                        onClick={() => {
                            clearErrors();
                            setUploadModalOpen(true);
                        }}
                        className="btn-admin-primary shrink-0 self-start sm:self-auto cursor-pointer"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Subir Foto</span>
                    </button>
                </div>

                {/* Cuadrícula de Fotografías */}
                {fotos.length > 0 ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        {fotos.map((foto) => {
                            // Resolver ruta de imagen correctamente evitando dominios hardcodeados
                            const rawPath = foto.imagen_path || '';
                            const imgSrc = foto.url || (rawPath.startsWith('/') ? rawPath : (rawPath.startsWith('images/') || rawPath.startsWith('storage/') ? `/${rawPath}` : `/storage/${rawPath}`));

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
                                        />
                                        <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-start p-3">
                                            <a
                                                href={imgSrc}
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

                                    {/* Pie con Título, Fecha y Único Botón de Eliminar */}
                                    <div className="p-4 flex-1 flex flex-col justify-between space-y-3">
                                        <h3 className="font-mate text-sm font-bold text-neutral-900 line-clamp-2 leading-snug">
                                            {foto.titulo}
                                        </h3>

                                        <div className="flex items-center justify-between text-[11px] text-neutral-400 font-literata pt-2 border-t border-neutral-100">
                                            <span className="flex items-center gap-1">
                                                <Calendar className="w-3 h-3 text-neutral-400" />
                                                {foto.created_at ? new Date(foto.created_at).toLocaleDateString('es-PE') : '-'}
                                            </span>

                                            <button
                                                type="button"
                                                onClick={() => handleDelete(foto.id, foto.titulo)}
                                                className="inline-flex items-center gap-1 text-xs text-neutral-400 hover:text-ricardo-red hover:bg-red-50 px-2 py-1 rounded-lg transition-colors cursor-pointer"
                                                title="Eliminar foto"
                                            >
                                                <Trash2 className="w-3.5 h-3.5" />
                                                <span>Eliminar</span>
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
                            Comienza subiendo fotos escolares de actividades, escolta, desfiles o eventos institucionales.
                        </p>
                    </div>
                )}

            </div>

            {/* Modal para Subir Nueva Fotografía */}
            {uploadModalOpen && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/50 backdrop-blur-xs">
                    <div className="bg-white rounded-3xl border border-neutral-200/90 shadow-2xl max-w-lg w-full p-6 sm:p-8 space-y-6 max-h-[90vh] overflow-y-auto">
                        
                        <div className="flex items-center justify-between border-b border-neutral-200/80 pb-4">
                            <div>
                                <h3 className="font-mate text-lg font-bold text-neutral-900 uppercase tracking-tight">
                                    Subir Nueva Fotografía
                                </h3>
                                <span className="text-xs text-neutral-500 font-literata">
                                    I.E.I. N° 31756 Ricardo Palma
                                </span>
                            </div>
                            <button
                                type="button"
                                onClick={closeModal}
                                className="text-neutral-400 hover:text-neutral-700 p-1.5 rounded-xl hover:bg-neutral-100 transition-colors cursor-pointer"
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
                                    placeholder="Ej. Estudiantes en desfile cívico escolar"
                                    required
                                    className="admin-input"
                                />
                                {errors.titulo && <p className="text-xs text-ricardo-red font-medium">{errors.titulo}</p>}
                            </div>

                            {/* Dropzone Archivo */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Archivo de Imagen *
                                </label>

                                {/* Input file siempre disponible vía ref */}
                                <input
                                    ref={fileInputRef}
                                    type="file"
                                    accept="image/jpeg,image/png,image/webp,image/jpg"
                                    onChange={handleFileChange}
                                    className="hidden"
                                />

                                {previewImage ? (
                                    <div className="space-y-3">
                                        {/* Contenedor de Vista Previa */}
                                        <div className="relative rounded-2xl overflow-hidden border border-neutral-200 bg-neutral-950/5 flex items-center justify-center min-h-[220px] max-h-[300px]">
                                            <img 
                                                src={previewImage} 
                                                alt="Vista previa" 
                                                className="w-full max-h-[300px] object-contain rounded-2xl" 
                                            />
                                            <button
                                                type="button"
                                                onClick={handleClearFile}
                                                className="absolute top-3 right-3 p-1.5 rounded-xl bg-neutral-900/70 text-white hover:bg-neutral-950 transition-colors shadow-sm cursor-pointer"
                                                title="Quitar imagen"
                                            >
                                                <X className="w-4 h-4" />
                                            </button>
                                        </div>

                                        {/* Barra de información del archivo con acción de cambiar */}
                                        <div className="flex items-center justify-between p-3 rounded-2xl bg-neutral-50 border border-neutral-200/80 text-xs">
                                            <div className="flex items-center gap-2 overflow-hidden mr-2">
                                                <div className="w-8 h-8 rounded-xl bg-teal-50 text-ricardo-teal flex items-center justify-center shrink-0 border border-teal-100">
                                                    <FileCheck className="w-4 h-4" />
                                                </div>
                                                <div className="overflow-hidden">
                                                    <p className="font-mate font-bold text-neutral-800 truncate" title={fileDetails?.name}>
                                                        {fileDetails?.name || 'Imagen seleccionada'}
                                                    </p>
                                                    <p className="text-neutral-400 font-literata text-[11px]">
                                                        {fileDetails?.size || ''}
                                                    </p>
                                                </div>
                                            </div>

                                            <button
                                                type="button"
                                                onClick={() => fileInputRef.current?.click()}
                                                className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-neutral-200 bg-white hover:bg-neutral-100 text-neutral-700 font-mate text-xs font-semibold shrink-0 transition-colors cursor-pointer"
                                            >
                                                <RefreshCw className="w-3.5 h-3.5" />
                                                <span>Cambiar</span>
                                            </button>
                                        </div>
                                    </div>
                                ) : (
                                    <div
                                        onDragOver={handleDragOver}
                                        onDragLeave={handleDragLeave}
                                        onDrop={handleDrop}
                                        onClick={() => fileInputRef.current?.click()}
                                        className={`flex flex-col items-center justify-center p-8 border-2 border-dashed rounded-2xl cursor-pointer transition-all ${
                                            isDragging 
                                                ? 'border-ricardo-teal bg-teal-50/50 scale-[0.99]' 
                                                : 'border-neutral-200 hover:border-ricardo-teal hover:bg-neutral-50/60 bg-[#FBFBFA]'
                                        }`}
                                    >
                                        <div className={`w-12 h-12 rounded-2xl flex items-center justify-center mb-3 transition-colors ${
                                            isDragging
                                                ? 'bg-teal-100 text-ricardo-teal'
                                                : 'bg-neutral-100 text-neutral-400 group-hover:text-ricardo-teal group-hover:bg-teal-50'
                                        }`}>
                                            <Upload className="w-6 h-6" />
                                        </div>
                                        <span className="text-xs font-mate uppercase tracking-wider font-bold text-neutral-700 text-center">
                                            {isDragging ? 'Suelta la fotografía aquí' : 'Haz clic o arrastra una fotografía'}
                                        </span>
                                        <span className="text-[11px] text-neutral-400 font-literata text-center mt-1">
                                            PNG, JPG o WebP hasta 10 MB
                                        </span>
                                    </div>
                                )}

                                {clientError && (
                                    <p className="text-xs text-ricardo-red font-medium mt-1">{clientError}</p>
                                )}
                                {errors.imagen_file && (
                                    <p className="text-xs text-ricardo-red font-medium mt-1">{errors.imagen_file}</p>
                                )}
                            </div>

                            {/* Botones */}
                            <div className="pt-2 flex items-center justify-end gap-3 border-t border-neutral-200/80">
                                <button
                                    type="button"
                                    onClick={closeModal}
                                    className="btn-admin-secondary cursor-pointer"
                                >
                                    Cancelar
                                </button>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="btn-admin-primary disabled:opacity-60 cursor-pointer"
                                >
                                    <Upload className="w-4 h-4" />
                                    <span>{processing ? 'Subiendo fotografía...' : 'Publicar Fotografía'}</span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            )}

            {/* Modal de Confirmación de Eliminación */}
            {deleteModal.open && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-neutral-900/50 backdrop-blur-xs">
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
                            ¿Estás seguro de que deseas eliminar permanentemente la fotografía <strong className="text-neutral-900 font-semibold">"{deleteModal.title}"</strong> de la galería escolar?
                        </p>

                        <div className="pt-2 flex items-center justify-end gap-3">
                            <button
                                type="button"
                                onClick={() => setDeleteModal({ open: false, id: null, title: '' })}
                                className="btn-admin-secondary cursor-pointer"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                onClick={confirmDelete}
                                className="btn-admin-danger cursor-pointer"
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