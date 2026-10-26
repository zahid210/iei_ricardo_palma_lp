import React, { useState, useRef, useEffect } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { ArrowLeft, Save, Upload, Star, Calendar, User, FileText, Image as ImageIcon, X, RefreshCw, FileCheck } from 'lucide-react';

export default function Create() {
    const today = new Date().toISOString().split('T')[0];

    const { data, setData, post, processing, errors, clearErrors } = useForm({
        titulo: '',
        extracto: '',
        contenido: '',
        autor: 'Colegio Ricardo Palma',
        fecha_publicacion: today,
        destacada: false,
        orden: 0,
        imagen_file: null,
    });

    const [previewUrl, setPreviewUrl] = useState(null);
    const [fileDetails, setFileDetails] = useState(null);
    const [isDragging, setIsDragging] = useState(false);
    const [clientError, setClientError] = useState('');
    const fileInputRef = useRef(null);

    // Limpiar URLs blob
    useEffect(() => {
        return () => {
            if (previewUrl && previewUrl.startsWith('blob:')) {
                URL.revokeObjectURL(previewUrl);
            }
        };
    }, [previewUrl]);

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

        if (previewUrl && previewUrl.startsWith('blob:')) {
            URL.revokeObjectURL(previewUrl);
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            setPreviewUrl(event.target?.result);
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

    const handleRemoveImage = () => {
        if (previewUrl && previewUrl.startsWith('blob:')) {
            URL.revokeObjectURL(previewUrl);
        }
        setData('imagen_file', null);
        setPreviewUrl(null);
        setFileDetails(null);
        setClientError('');
        if (fileInputRef.current) {
            fileInputRef.current.value = '';
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setClientError('');
        post('/admin/noticias', {
            forceFormData: true,
            preserveScroll: true,
        });
    };

    return (
        <AdminLayout title="Nueva Noticia">
            <div className="max-w-5xl mx-auto space-y-6">
                
                {/* Cabecera de navegación */}
                <div className="flex items-center justify-between gap-4">
                    <Link
                        href="/admin/noticias"
                        className="inline-flex items-center gap-2 text-xs font-mate uppercase tracking-wider text-neutral-500 hover:text-neutral-900 transition-colors font-semibold"
                    >
                        <ArrowLeft className="w-4 h-4" />
                        <span>Volver a las noticias</span>
                    </Link>
                </div>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        
                        {/* Columna Principal de Contenido (8 columnas) */}
                        <div className="lg:col-span-8 bg-white rounded-3xl border border-neutral-200/80 p-6 sm:p-8 shadow-2xs space-y-6">
                            <div className="border-b border-neutral-200/70 pb-4 space-y-1">
                                <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                                    Redacción Escolar
                                </span>
                                <h1 className="font-mate text-2xl font-bold text-neutral-900 uppercase tracking-tight">
                                    Nueva Noticia
                                </h1>
                            </div>

                            {/* Título */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Título de la Noticia *
                                </label>
                                <input
                                    type="text"
                                    value={data.titulo}
                                    onChange={(e) => setData('titulo', e.target.value)}
                                    placeholder="Ej. Ceremonia de bienvenida al año escolar 2026"
                                    required
                                    className="admin-input text-base font-medium"
                                />
                                {errors.titulo && <p className="text-xs text-ricardo-red font-medium">{errors.titulo}</p>}
                            </div>

                            {/* Extracto / Resumen */}
                            <div className="space-y-1.5">
                                <div className="flex items-center justify-between">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Resumen o Extracto Breve *
                                    </label>
                                    <span className="text-[11px] text-neutral-400 font-literata">
                                        {data.extracto.length} / 500 caracteres
                                    </span>
                                </div>
                                <textarea
                                    value={data.extracto}
                                    onChange={(e) => setData('extracto', e.target.value)}
                                    rows={3}
                                    required
                                    maxLength={500}
                                    placeholder="Breve resumen visible en el listado y tarjetas de noticias..."
                                    className="admin-input resize-y"
                                />
                                {errors.extracto && <p className="text-xs text-ricardo-red font-medium">{errors.extracto}</p>}
                            </div>

                            {/* Contenido Completo */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Contenido Completo de la Noticia *
                                </label>
                                <textarea
                                    value={data.contenido}
                                    onChange={(e) => setData('contenido', e.target.value)}
                                    rows={10}
                                    required
                                    placeholder="Escribe aquí el relato completo de la noticia, actividades o comunicado escolar..."
                                    className="admin-input resize-y"
                                />
                                {errors.contenido && <p className="text-xs text-ricardo-red font-medium">{errors.contenido}</p>}
                            </div>
                        </div>

                        {/* Columna Lateral de Configuración (4 columnas) */}
                        <div className="lg:col-span-4 space-y-6">
                            
                            {/* Panel Portada / Imagen */}
                            <div className="bg-white rounded-3xl border border-neutral-200/80 p-6 shadow-2xs space-y-4">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Fotografía de Portada
                                </label>

                                <input
                                    ref={fileInputRef}
                                    type="file"
                                    accept="image/jpeg,image/png,image/webp,image/jpg"
                                    onChange={handleFileChange}
                                    className="hidden"
                                />

                                {previewUrl ? (
                                    <div className="space-y-3">
                                        <div className="relative rounded-2xl overflow-hidden border border-neutral-200 bg-neutral-950/5 flex items-center justify-center min-h-[180px] max-h-[240px]">
                                            <img 
                                                src={previewUrl} 
                                                alt="Vista previa" 
                                                className="w-full max-h-[240px] object-contain rounded-2xl"
                                            />
                                            <button
                                                type="button"
                                                onClick={handleRemoveImage}
                                                className="absolute top-2.5 right-2.5 p-1.5 rounded-xl bg-neutral-900/70 text-white hover:bg-neutral-950 transition-colors shadow-sm cursor-pointer"
                                                title="Quitar imagen"
                                            >
                                                <X className="w-4 h-4" />
                                            </button>
                                        </div>

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
                                        className={`flex flex-col items-center justify-center p-6 border-2 border-dashed rounded-2xl cursor-pointer transition-all ${
                                            isDragging 
                                                ? 'border-ricardo-teal bg-teal-50/50 scale-[0.99]' 
                                                : 'border-neutral-200 hover:border-ricardo-teal hover:bg-neutral-50/60 bg-[#FBFBFA]'
                                        }`}
                                    >
                                        <div className={`w-10 h-10 rounded-xl flex items-center justify-center mb-2 transition-colors ${
                                            isDragging ? 'bg-teal-100 text-ricardo-teal' : 'bg-neutral-100 text-neutral-400'
                                        }`}>
                                            <Upload className="w-5 h-5" />
                                        </div>
                                        <span className="text-xs font-mate uppercase tracking-wider font-bold text-neutral-700 text-center">
                                            {isDragging ? 'Suelta la fotografía aquí' : 'Subir Fotografía'}
                                        </span>
                                        <span className="text-[11px] text-neutral-400 font-literata text-center mt-1">
                                            PNG, JPG o WebP hasta 10 MB
                                        </span>
                                    </div>
                                )}

                                {clientError && <p className="text-xs text-ricardo-red font-medium mt-1">{clientError}</p>}
                                {errors.imagen_file && <p className="text-xs text-ricardo-red font-medium mt-1">{errors.imagen_file}</p>}
                            </div>

                            {/* Metadatos y Publicación */}
                            <div className="bg-white rounded-3xl border border-neutral-200/80 p-6 shadow-2xs space-y-4">
                                
                                {/* Fecha */}
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Fecha de Publicación *
                                    </label>
                                    <input
                                        type="date"
                                        value={data.fecha_publicacion}
                                        onChange={(e) => setData('fecha_publicacion', e.target.value)}
                                        required
                                        className="admin-input"
                                    />
                                    {errors.fecha_publicacion && <p className="text-xs text-ricardo-red font-medium">{errors.fecha_publicacion}</p>}
                                </div>

                                {/* Autor */}
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Autor o Emisor
                                    </label>
                                    <input
                                        type="text"
                                        value={data.autor}
                                        onChange={(e) => setData('autor', e.target.value)}
                                        placeholder="Ej. Dirección del Colegio"
                                        className="admin-input"
                                    />
                                </div>

                                {/* Destacada Toggle */}
                                <div className="pt-2">
                                    <label className="flex items-center gap-3 cursor-pointer p-3 rounded-2xl bg-amber-50/60 border border-amber-200/70 select-none">
                                        <input
                                            type="checkbox"
                                            checked={data.destacada}
                                            onChange={(e) => setData('destacada', e.target.checked)}
                                            className="rounded border-amber-300 text-amber-500 focus:ring-amber-400 h-4 w-4"
                                        />
                                        <div>
                                            <span className="font-mate text-xs uppercase tracking-wider font-bold text-amber-900 block">
                                                Noticia Destacada
                                            </span>
                                            <span className="text-[11px] text-amber-800/80 font-literata block">
                                                Aparecerá en el encabezado principal de la sección de noticias.
                                            </span>
                                        </div>
                                    </label>
                                </div>

                                {/* Orden */}
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Orden de Prioridad
                                    </label>
                                    <input
                                        type="number"
                                        value={data.orden}
                                        onChange={(e) => setData('orden', parseInt(e.target.value) || 0)}
                                        className="admin-input"
                                    />
                                </div>
                            </div>

                            {/* Botones de Acción */}
                            <div className="flex items-center gap-3">
                                <Link
                                    href="/admin/noticias"
                                    className="btn-admin-secondary flex-1 cursor-pointer"
                                >
                                    Cancelar
                                </Link>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="btn-admin-primary flex-1 disabled:opacity-60 cursor-pointer"
                                >
                                    <Save className="w-4 h-4" />
                                    <span>{processing ? 'Publicando...' : 'Publicar Noticia'}</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </AdminLayout>
    );
}
