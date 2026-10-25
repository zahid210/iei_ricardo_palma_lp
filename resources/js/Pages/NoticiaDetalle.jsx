import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { Calendar, ArrowLeft, ArrowRight, Clock, Share2 } from 'lucide-react';

export default function NoticiaDetalle({ noticia, anterior, relacionadas = [] }) {
    const fechaFormateada = noticia.fecha_publicacion 
        ? new Date(noticia.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'long', year: 'numeric' }) 
        : '';

    return (
        <AppLayout>
            <Head title={`${noticia.titulo} | I.E.I. N° 31756 Ricardo Palma`} />

            {/* =========================================================================
                1. ENCABEZADO EDITORIAL DE LA CRÓNICA
               ========================================================================= */}
            <section className="bg-[#FBFBFA] border-b border-neutral-200/80 pt-10 sm:pt-14 pb-12 sm:pb-16">
                <div className="mx-auto max-w-4xl px-5 sm:px-8 space-y-6">
                    
                    {/* Botón de Retorno Minimalista */}
                    <div className="flex items-center justify-between">
                        <Link
                            href="/noticias"
                            className="inline-flex items-center gap-2 font-mate text-xs uppercase tracking-wider font-bold text-ricardo-teal hover:text-neutral-900 transition-colors"
                        >
                            <ArrowLeft className="w-4 h-4" />
                            <span>Volver a Sala de Prensa</span>
                        </Link>

                        <span className="font-mate text-xs uppercase tracking-wider text-neutral-400 font-semibold">
                            Crónica Institucional
                        </span>
                    </div>

                    {/* Fecha y Metadatos */}
                    <div className="flex items-center gap-2 text-xs font-mate text-neutral-500 font-semibold">
                        <Calendar className="w-3.5 h-3.5 text-ricardo-teal" />
                        <span>{fechaFormateada}</span>
                        {noticia.autor && (
                            <>
                                <span>•</span>
                                <span>Por {noticia.autor}</span>
                            </>
                        )}
                    </div>

                    {/* Título Principal */}
                    <h1 className="font-mate text-2xl sm:text-4xl lg:text-5xl uppercase font-bold text-neutral-900 tracking-tight leading-[1.18]">
                        {noticia.titulo}
                    </h1>

                    {/* Acento Institucional Ricardino */}
                    <div className="flex h-1 w-20">
                        <span className="w-2/3 bg-ricardo-teal"></span>
                        <span className="w-1/3 bg-ricardo-red"></span>
                    </div>

                </div>
            </section>

            {/* =========================================================================
                2. CUERPO DE LA NOTICIA
               ========================================================================= */}
            <article className="bg-white py-12 sm:py-16 border-b border-neutral-200/80">
                <div className="mx-auto max-w-4xl px-5 sm:px-8 space-y-10">
                    
                    {/* Fotografía Principal de la Crónica */}
                    {noticia.imagen && (
                        <div className="rounded-2xl overflow-hidden border border-neutral-200/80 shadow-2xs">
                            <img
                                src={`/${noticia.imagen}`}
                                alt={noticia.titulo}
                                className="w-full h-auto object-cover max-h-[520px]"
                                onError={(e) => { e.currentTarget.style.display = 'none'; }}
                            />
                        </div>
                    )}

                    {/* Contenido Editorial */}
                    <div 
                        className="font-literata text-base sm:text-lg text-neutral-800 leading-relaxed space-y-6 pt-2"
                        dangerouslySetInnerHTML={{ __html: noticia.contenido }}
                    />

                    {/* Navegación a Crónica Anterior */}
                    {anterior && (
                        <div className="pt-8 mt-12 border-t border-neutral-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div className="space-y-1">
                                <span className="font-mate text-xs uppercase tracking-widest text-neutral-400 font-semibold block">
                                    Publicación Anterior
                                </span>
                                <Link
                                    href={`/noticias/${anterior.slug}`}
                                    className="font-mate text-base sm:text-lg font-bold text-neutral-900 hover:text-ricardo-teal transition-colors line-clamp-1"
                                >
                                    ← {anterior.titulo}
                                </Link>
                            </div>

                            <Link
                                href="/noticias"
                                className="inline-flex items-center gap-1.5 font-mate text-xs uppercase tracking-wider font-bold text-ricardo-teal hover:underline shrink-0"
                            >
                                <span>Ver todas</span>
                                <ArrowRight className="w-3.5 h-3.5" />
                            </Link>
                        </div>
                    )}

                </div>
            </article>

            {/* =========================================================================
                3. CRÓNICAS RELACIONADAS
               ========================================================================= */}
            {relacionadas.length > 0 && (
                <section className="bg-[#FBFBFA] py-14 sm:py-18">
                    <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-8">
                        <div className="border-l-2 border-ricardo-teal pl-4 space-y-1">
                            <h2 className="font-mate text-xl sm:text-2xl font-bold uppercase text-neutral-900 tracking-tight">
                                Otras Crónicas Recientes
                            </h2>
                            <p className="font-literata text-xs sm:text-sm text-neutral-500">
                                Sigue descubriendo las novedades de nuestra comunidad escolar.
                            </p>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            {relacionadas.map((item) => (
                                <Link
                                    key={item.id}
                                    href={`/noticias/${item.slug}`}
                                    className="group rounded-2xl border border-neutral-200/80 bg-white hover:border-ricardo-teal/40 overflow-hidden transition-all duration-200 shadow-2xs hover:shadow-xs flex flex-col justify-between"
                                >
                                    <div className="aspect-[16/10] overflow-hidden bg-neutral-100">
                                        <img
                                            src={item.imagen ? `/${item.imagen}` : '/images/banners/fachada_colegio.jpg'}
                                            alt={item.titulo}
                                            className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            onError={(e) => { e.currentTarget.src = '/images/banners/fachada_colegio.jpg'; }}
                                        />
                                    </div>
                                    <div className="p-5 space-y-2 flex-1 flex flex-col justify-between">
                                        <div className="space-y-1.5">
                                            <span className="font-mate text-[11px] uppercase tracking-wider text-neutral-400 font-semibold block">
                                                {item.fecha_publicacion 
                                                    ? new Date(item.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'short', year: 'numeric' }) 
                                                    : ''}
                                            </span>
                                            <h3 className="font-mate text-base font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors leading-snug line-clamp-2">
                                                {item.titulo}
                                            </h3>
                                        </div>
                                        <div className="pt-2 inline-flex items-center gap-1.5 font-mate text-xs uppercase tracking-wider font-bold text-ricardo-teal group-hover:translate-x-1 transition-transform">
                                            <span>Leer más</span>
                                            <ArrowRight className="w-3.5 h-3.5" />
                                        </div>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </div>
                </section>
            )}
        </AppLayout>
    );
}
