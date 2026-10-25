import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { Calendar, ArrowRight } from 'lucide-react';

export default function Noticias({ destacada, secundarias = [], otrasNoticias = [] }) {
    return (
        <AppLayout>
            <Head title="Noticias Institucionales | I.E.I. N° 31756 Ricardo Palma" />

            {/* Banner Institucional */}
            <section className="bg-[#0C3831] text-white py-16 sm:py-20 border-b border-white/10">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-4">
                    <span className="font-mate text-xs uppercase tracking-widest text-ricardo-yellow font-semibold">
                        Actualidad y Comunicados
                    </span>
                    <h1 className="font-mate text-3xl sm:text-5xl uppercase font-bold tracking-tight">
                        Noticias Institucionales
                    </h1>
                    <div className="flex h-1 w-20">
                        <span className="w-2/3 bg-ricardo-teal"></span>
                        <span className="w-1/3 bg-ricardo-red"></span>
                    </div>
                    <p className="font-literata text-base sm:text-lg text-neutral-200 max-w-2xl leading-relaxed pt-1 font-light">
                        Mantente informado sobre los proyectos pedagógicos, logros estudiantiles, eventos cívicos y comunicados oficiales de la familia ricardina.
                    </p>
                </div>
            </section>

            {/* Mosaico de Noticias */}
            <section className="bg-white py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    
                    {destacada ? (
                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                            
                            {/* Noticia Principal */}
                            <div className="lg:col-span-7">
                                <Link
                                    href={`/noticias/${destacada.slug}`}
                                    className="group block rounded-3xl overflow-hidden border border-neutral-200/90 bg-[#FBFBFA] shadow-xs hover:shadow-lg transition-all duration-300"
                                >
                                    <div className="aspect-[16/10] overflow-hidden bg-neutral-100">
                                        <img
                                            src={destacada.imagen ? `/${destacada.imagen}` : '/images/banners/fachada_colegio.jpg'}
                                            alt={destacada.titulo}
                                            className="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                            onError={(e) => { e.currentTarget.src = '/images/banners/fachada_colegio.jpg'; }}
                                        />
                                    </div>
                                    <div className="p-7 sm:p-8 space-y-3">
                                        <div className="flex items-center gap-2 text-xs font-mate text-ricardo-teal font-semibold">
                                            <Calendar className="w-3.5 h-3.5" />
                                            <span>{destacada.fecha_publicacion ? new Date(destacada.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'long', year: 'numeric' }) : ''}</span>
                                        </div>
                                        <h2 className="font-mate text-2xl sm:text-3xl font-bold uppercase text-neutral-900 group-hover:text-ricardo-teal transition-colors tracking-tight leading-tight">
                                            {destacada.titulo}
                                        </h2>
                                        <p className="font-literata text-sm text-neutral-600 line-clamp-3 leading-relaxed">
                                            {destacada.extracto || destacada.contenido?.replace(/<[^>]+>/g, '').substring(0, 160) + '...'}
                                        </p>
                                        <div className="pt-2 inline-flex items-center gap-2 font-mate text-xs uppercase tracking-wider font-bold text-ricardo-teal">
                                            <span>Leer noticia completa</span>
                                            <ArrowRight className="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" />
                                        </div>
                                    </div>
                                </Link>
                            </div>

                            {/* Noticias Secundarias */}
                            <div className="lg:col-span-5 space-y-5">
                                {secundarias.map((item) => (
                                    <Link
                                        key={item.id}
                                        href={`/noticias/${item.slug}`}
                                        className="group flex gap-4 p-4 rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] hover:bg-white hover:border-ricardo-teal/40 hover:shadow-sm transition-all duration-300"
                                    >
                                        <div className="w-28 h-24 rounded-xl overflow-hidden shrink-0 bg-neutral-100">
                                            <img
                                                src={item.imagen ? `/${item.imagen}` : '/images/banners/fachada_colegio.jpg'}
                                                alt={item.titulo}
                                                className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                onError={(e) => { e.currentTarget.src = '/images/banners/fachada_colegio.jpg'; }}
                                            />
                                        </div>
                                        <div className="min-w-0 flex-grow space-y-1.5">
                                            <span className="font-mate text-[11px] uppercase tracking-wider text-neutral-500 font-semibold block">
                                                {item.fecha_publicacion ? new Date(item.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'short', year: 'numeric' }) : ''}
                                            </span>
                                            <h3 className="font-mate text-sm sm:text-base font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors leading-snug line-clamp-2">
                                                {item.titulo}
                                            </h3>
                                        </div>
                                    </Link>
                                ))}
                            </div>

                        </div>
                    ) : (
                        <div className="rounded-2xl border border-neutral-200 bg-[#FBFBFA] p-12 text-center text-neutral-500 font-literata">
                            No hay noticias publicadas por el momento.
                        </div>
                    )}

                    {/* Otras Noticias */}
                    {otrasNoticias.length > 0 && (
                        <div className="pt-8 space-y-8 border-t border-neutral-200">
                            <h2 className="font-mate text-2xl font-bold uppercase text-neutral-900 tracking-tight">
                                Más Publicaciones
                            </h2>
                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                {otrasNoticias.map((item) => (
                                    <Link
                                        key={item.id}
                                        href={`/noticias/${item.slug}`}
                                        className="group rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col justify-between"
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
                                            <span className="font-mate text-[11px] uppercase tracking-wider text-neutral-500 font-semibold block">
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
                    )}

                </div>
            </section>
        </AppLayout>
    );
}
