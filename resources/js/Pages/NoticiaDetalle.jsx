import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { Calendar, ArrowLeft } from 'lucide-react';

export default function NoticiaDetalle({ noticia, anterior, relacionadas = [] }) {
    return (
        <AppLayout>
            <Head title={`${noticia.titulo} | I.E.I. N° 31756 Ricardo Palma`} />

            {/* Encabezado de Noticia */}
            <section className="bg-[#0C3831] text-white py-14 sm:py-18 border-b border-white/10">
                <div className="mx-auto max-w-4xl px-5 sm:px-8 space-y-4">
                    <Link
                        href="/noticias"
                        className="inline-flex items-center gap-2 font-mate text-xs uppercase tracking-wider text-ricardo-yellow hover:text-white transition-colors"
                    >
                        <ArrowLeft className="w-3.5 h-3.5" />
                        <span>Volver a Noticias</span>
                    </Link>
                    
                    <div className="flex items-center gap-2 text-xs font-mate text-neutral-300">
                        <Calendar className="w-3.5 h-3.5 text-ricardo-teal" />
                        <span>{noticia.fecha_publicacion ? new Date(noticia.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'long', year: 'numeric' }) : ''}</span>
                    </div>

                    <h1 className="font-mate text-3xl sm:text-5xl uppercase font-bold tracking-tight leading-tight">
                        {noticia.titulo}
                    </h1>
                </div>
            </section>

            {/* Contenido Editorial */}
            <article className="bg-white py-16 sm:py-20 border-b border-neutral-200">
                <div className="mx-auto max-w-4xl px-5 sm:px-8 space-y-10">
                    
                    {noticia.imagen && (
                        <div className="rounded-3xl overflow-hidden border border-neutral-200/90 shadow-md">
                            <img
                                src={`/${noticia.imagen}`}
                                alt={noticia.titulo}
                                className="w-full h-auto object-cover max-h-[500px]"
                                onError={(e) => { e.currentTarget.style.display = 'none'; }}
                            />
                        </div>
                    )}

                    <div 
                        className="font-literata text-base sm:text-lg text-neutral-800 leading-relaxed space-y-6 pt-2"
                        dangerouslySetInnerHTML={{ __html: noticia.contenido }}
                    />

                    {/* Noticia Anterior / Siguiente Navegación */}
                    {anterior && (
                        <div className="pt-8 border-t border-neutral-200">
                            <span className="font-mate text-xs uppercase tracking-widest text-neutral-400 block mb-2">Publicación anterior</span>
                            <Link
                                href={`/noticias/${anterior.slug}`}
                                className="font-mate text-lg font-bold text-neutral-900 hover:text-ricardo-teal transition-colors"
                            >
                                ← {anterior.titulo}
                            </Link>
                        </div>
                    )}

                </div>
            </article>

            {/* Noticias Relacionadas */}
            {relacionadas.length > 0 && (
                <section className="bg-[#FBFBFA] py-16 sm:py-20">
                    <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-8">
                        <h2 className="font-mate text-2xl font-bold uppercase text-neutral-900 tracking-tight">
                            Noticias Relacionadas
                        </h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            {relacionadas.map((item) => (
                                <Link
                                    key={item.id}
                                    href={`/noticias/${item.slug}`}
                                    className="group rounded-2xl border border-neutral-200/80 bg-white overflow-hidden hover:shadow-md transition-all duration-300"
                                >
                                    <div className="aspect-[16/9] overflow-hidden bg-neutral-100">
                                        <img
                                            src={item.imagen ? `/${item.imagen}` : '/images/banners/fachada_colegio.jpg'}
                                            alt={item.titulo}
                                            className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            onError={(e) => { e.currentTarget.src = '/images/banners/fachada_colegio.jpg'; }}
                                        />
                                    </div>
                                    <div className="p-5 space-y-2">
                                        <span className="font-mate text-[11px] uppercase tracking-wider text-neutral-400 font-semibold block">
                                            {item.fecha_publicacion ? new Date(item.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'short', year: 'numeric' }) : ''}
                                        </span>
                                        <h3 className="font-mate text-base font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors leading-snug line-clamp-2">
                                            {item.titulo}
                                        </h3>
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
