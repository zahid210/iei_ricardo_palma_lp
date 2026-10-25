import React, { useState } from 'react';
import { Head, Link, useForm, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { ArrowLeft, Save, Upload, Star, Calendar, User, FileText, Image as ImageIcon } from 'lucide-react';

export default function Edit({ noticia }) {
    const formattedDate = noticia.fecha_publicacion 
        ? new Date(noticia.fecha_publicacion).toISOString().split('T')[0]
        : '';

    const { data, setData, processing, errors } = useForm({
        titulo: noticia.titulo || '',
        extracto: noticia.extracto || '',
        contenido: noticia.contenido || '',
        autor: noticia.autor || 'Comisión de Comunicaciones',
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
            <div className="max-w-4xl mx-auto space-y-6">
                
                {/* Cabecera */}
                <div className="flex items-center justify-between gap-4">
                    <Link
                        href="/admin/noticias"
                        className="inline-flex items-center gap-2 text-xs font-mate uppercase tracking-wider text-neutral-500 hover:text-neutral-900 transition-colors font-semibold"
                    >
                        <ArrowLeft className="w-4 h-4" />
                        <span>Volver al listado</span>
                    </Link>

                    <a
                        href={`/noticias/${noticia.slug}`}
                        target="_blank"
                        rel="noreferrer"
                        className="btn-admin-secondary text-xs"
                    >
                        <span>Ver en la web pública</span>
                    </a>
                </div>

                <form onSubmit={handleSubmit} className="bg-white rounded-3xl border border-neutral-200/80 p-6 sm:p-10 shadow-2xs space-y-8">
                    
                    <div className="border-b border-neutral-200/70 pb-5 space-y-1">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Edición de Contenido
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Editar Noticia
                        </h1>
                        <p className="text-xs sm:text-sm text-neutral-500 font-literata">
                            Modifica la información, el estado destacado o la fotografía de la noticia.
                        </p>
                    </div>

                    <div className="space-y-6">
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

                        {/* Metadatos: Autor, Fecha, Orden */}
                        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Autor / Comisión
                                </label>
                                <input
                                    type="text"
                                    value={data.autor}
                                    onChange={(e) => setData('autor', e.target.value)}
                                    className="admin-input"
                                />
                                {errors.autor && <span className="text-xs text-ricardo-red">{errors.autor}</span>}
                            </div>

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

                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Orden Visual
                                </label>
                                <input
                                    type="number"
                                    value={data.orden}
                                    onChange={(e) => setData('orden', parseInt(e.target.value) || 0)}
                                    className="admin-input"
                                />
                                {errors.orden && <span className="text-xs text-ricardo-red">{errors.orden}</span>}
                            </div>
                        </div>

                        {/* Checkbox Noticia Destacada */}
                        <div className="rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] p-4 flex items-center justify-between">
                            <div className="flex items-center gap-3">
                                <div className="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center border border-amber-200/60">
                                    <Star className="w-4 h-4 fill-current" />
                                </div>
                                <div>
                                    <h4 className="font-mate text-xs font-bold uppercase tracking-wider text-neutral-900">
                                        Destacar en Portada
                                    </h4>
                                    <span className="text-xs text-neutral-500 font-literata">
                                        Se mostrará como la noticia principal en la sección de noticias.
                                    </span>
                                </div>
                            </div>
                            <input
                                type="checkbox"
                                checked={data.destacada}
                                onChange={(e) => setData('destacada', e.target.checked)}
                                className="h-5 w-5 rounded border-neutral-300 text-ricardo-teal focus:ring-ricardo-teal cursor-pointer"
                            />
                        </div>

                        {/* Imagen Principal */}
                        <div className="space-y-2">
                            <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                Fotografía de Portada
                            </label>
                            <div className="border-2 border-dashed border-neutral-200 hover:border-ricardo-teal rounded-2xl p-6 text-center transition-colors bg-[#FBFBFA]">
                                {previewUrl ? (
                                    <div className="space-y-3">
                                        <img 
                                            src={previewUrl} 
                                            alt="Previsualización" 
                                            className="h-48 w-full max-w-md mx-auto object-cover rounded-xl border border-neutral-200"
                                            onError={(e) => { e.currentTarget.src = '/images/galeria_1.jpg'; }}
                                        />
                                        <div className="flex justify-center gap-2">
                                            <label className="cursor-pointer font-mate text-xs text-ricardo-teal font-bold uppercase tracking-wider hover:underline">
                                                Reemplazar fotografía
                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    onChange={handleFileChange}
                                                    className="hidden"
                                                />
                                            </label>
                                        </div>
                                    </div>
                                ) : (
                                    <label className="cursor-pointer space-y-2 block">
                                        <div className="w-12 h-12 rounded-2xl bg-teal-50 text-ricardo-teal flex items-center justify-center mx-auto border border-teal-100">
                                            <Upload className="w-5 h-5" />
                                        </div>
                                        <div className="text-xs font-semibold text-neutral-800 font-mate uppercase tracking-wider">
                                            Subir Fotografía
                                        </div>
                                        <p className="text-xs text-neutral-400 font-literata">
                                            Formatos recomendados: JPG, PNG o WebP (Máx. 5 MB).
                                        </p>
                                        <input
                                            type="file"
                                            accept="image/*"
                                            onChange={handleFileChange}
                                            className="hidden"
                                        />
                                    </label>
                                )}
                            </div>
                            {errors.imagen_file && <span className="text-xs text-ricardo-red">{errors.imagen_file}</span>}
                        </div>

                        {/* Extracto */}
                        <div className="space-y-1.5">
                            <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                Extracto Corto *
                            </label>
                            <textarea
                                value={data.extracto}
                                onChange={(e) => setData('extracto', e.target.value)}
                                rows={2}
                                required
                                className="admin-input resize-y"
                            />
                            {errors.extracto && <span className="text-xs text-ricardo-red">{errors.extracto}</span>}
                        </div>

                        {/* Contenido Completo */}
                        <div className="space-y-1.5">
                            <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                Contenido de la Noticia *
                            </label>
                            <textarea
                                value={data.contenido}
                                onChange={(e) => setData('contenido', e.target.value)}
                                rows={8}
                                required
                                className="admin-input resize-y"
                            />
                            {errors.contenido && <span className="text-xs text-ricardo-red">{errors.contenido}</span>}
                        </div>

                    </div>

                    {/* Botones de Acción */}
                    <div className="pt-4 border-t border-neutral-200/80 flex items-center justify-end gap-3">
                        <Link
                            href="/admin/noticias"
                            className="btn-admin-secondary"
                        >
                            Cancelar
                        </Link>
                        <button
                            type="submit"
                            disabled={processing}
                            className="btn-admin-primary disabled:opacity-60"
                        >
                            <Save className="w-4 h-4" />
                            <span>{processing ? 'Actualizando...' : 'Actualizar Noticia'}</span>
                        </button>
                    </div>

                </form>

            </div>
        </AdminLayout>
    );
}
