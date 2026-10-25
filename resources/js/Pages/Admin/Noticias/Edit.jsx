import React, { useState } from 'react';
import { Head, Link, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { ArrowLeft, Save, Upload, Star, Calendar, User, FileText, Image as ImageIcon, ExternalLink, X } from 'lucide-react';

export default function Edit({ noticia }) {
    const formattedDate = noticia.fecha_publicacion 
        ? new Date(noticia.fecha_publicacion).toISOString().split('T')[0]
        : '';

    const { data, setData, processing, errors } = useForm({
        titulo: noticia.titulo || '',
        extracto: noticia.extracto || '',
        contenido: noticia.contenido || '',
        autor: noticia.autor || 'Colegio Ricardo Palma',
        fecha_publicacion: formattedDate,
        destacada: Boolean(noticia.destacada),
        orden: noticia.orden || 0,
        imagen_file: null,
    });

    const [previewUrl, setPreviewUrl] = useState(
        noticia.imagen
            ? (noticia.imagen.startsWith('http') || noticia.imagen.startsWith('/') ? noticia.imagen : `/${noticia.imagen}`)
            : null
    );

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('imagen_file', file);
            setPreviewUrl(URL.createObjectURL(file));
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        
        // Laravel Inertia multipart PUT requiere usar router.post con _method: 'PUT'
        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('titulo', data.titulo);
        formData.append('extracto', data.extracto);
        formData.append('contenido', data.contenido);
        formData.append('autor', data.autor);
        formData.append('fecha_publicacion', data.fecha_publicacion);
        formData.append('destacada', data.destacada ? '1' : '0');
        formData.append('orden', String(data.orden));
        if (data.imagen_file) {
            formData.append('imagen_file', data.imagen_file);
        }

        router.post(`/admin/noticias/${noticia.id}`, formData);
    };

    return (
        <AdminLayout title={`Editar: ${noticia.titulo}`}>
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

                    {noticia.slug && (
                        <a
                            href={`/noticias/${noticia.slug}`}
                            target="_blank"
                            rel="noreferrer"
                            className="btn-admin-secondary text-xs"
                        >
                            <ExternalLink className="w-3.5 h-3.5 text-neutral-400" />
                            <span>Ver en la web pública</span>
                        </a>
                    )}
                </div>

                <form onSubmit={handleSubmit} className="space-y-6">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        
                        {/* Columna Principal de Contenido (8 columnas) */}
                        <div className="lg:col-span-8 bg-white rounded-3xl border border-neutral-200/80 p-6 sm:p-8 shadow-2xs space-y-6">
                            <div className="border-b border-neutral-200/70 pb-4 space-y-1">
                                <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                                    Edición Escolar
                                </span>
                                <h1 className="font-mate text-2xl font-bold text-neutral-900 uppercase tracking-tight">
                                    Editar Noticia
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
                                    required
                                    className="admin-input text-base font-medium"
                                />
                                {errors.titulo && <span className="text-xs text-ricardo-red">{errors.titulo}</span>}
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
                                    className="admin-input resize-y"
                                />
                                {errors.extracto && <span className="text-xs text-ricardo-red">{errors.extracto}</span>}
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
                                    className="admin-input resize-y"
                                />
                                {errors.contenido && <span className="text-xs text-ricardo-red">{errors.contenido}</span>}
                            </div>
                        </div>

                        {/* Columna Lateral de Configuración (4 columnas) */}
                        <div className="lg:col-span-4 space-y-6">
                            
                            {/* Panel Portada / Imagen */}
                            <div className="bg-white rounded-3xl border border-neutral-200/80 p-6 shadow-2xs space-y-4">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Fotografía de Portada
                                </label>

                                {previewUrl && (
                                    <div className="relative aspect-[16/10] rounded-2xl overflow-hidden border border-neutral-200 bg-neutral-100 group">
                                        <img 
                                            src={previewUrl} 
                                            alt="Vista previa" 
                                            className="w-full h-full object-cover"
                                            onError={(e) => { e.currentTarget.src = '/images/galeria_1.jpg'; }}
                                        />
                                    </div>
                                )}

                                <label className="flex flex-col items-center justify-center p-4 border-2 border-dashed border-neutral-200 hover:border-ricardo-teal rounded-2xl cursor-pointer bg-[#FBFBFA] transition-colors group">
                                    <div className="w-8 h-8 rounded-xl bg-neutral-100 text-neutral-400 group-hover:text-ricardo-teal group-hover:bg-teal-50 flex items-center justify-center mb-1.5 transition-colors">
                                        <Upload className="w-4 h-4" />
                                    </div>
                                    <span className="text-xs font-mate uppercase tracking-wider font-bold text-neutral-700 text-center">
                                        {previewUrl ? 'Cambiar Fotografía' : 'Subir Fotografía'}
                                    </span>
                                    <span className="text-[10px] text-neutral-400 font-literata text-center">
                                        PNG, JPG o WebP hasta 5 MB
                                    </span>
                                    <input
                                        type="file"
                                        accept="image/*"
                                        onChange={handleFileChange}
                                        className="hidden"
                                    />
                                </label>
                                {errors.imagen_file && <span className="text-xs text-ricardo-red">{errors.imagen_file}</span>}
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
                                    {errors.fecha_publicacion && <span className="text-xs text-ricardo-red">{errors.fecha_publicacion}</span>}
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

                            {/* Botones de Acción (Únicos) */}
                            <div className="flex items-center gap-3">
                                <Link
                                    href="/admin/noticias"
                                    className="btn-admin-secondary flex-1"
                                >
                                    Cancelar
                                </Link>
                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="btn-admin-primary flex-1 disabled:opacity-60"
                                >
                                    <Save className="w-4 h-4" />
                                    <span>{processing ? 'Guardando...' : 'Actualizar Noticia'}</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </AdminLayout>
    );
}
