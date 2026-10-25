import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';

export default function Galeria({ imagenes = { data: [] } }) {
    const items = imagenes?.data || [];
    const links = imagenes?.links || [];

    return (
        <AppLayout>
            <Head title="Galería | I.E.I. N° 31756 Ricardo Palma" />

            {/* Banner Institucional */}
            <section className="bg-[#0C3831] text-white py-16 sm:py-20 border-b border-white/10">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-4">
                    <span className="font-mate text-xs uppercase tracking-widest text-ricardo-yellow font-semibold">
                        Archivo Fotográfico
                    </span>
                    <h1 className="font-mate text-3xl sm:text-5xl uppercase font-bold tracking-tight">
                        Galería Institucional
                    </h1>
                    <div className="flex h-1 w-20">
                        <span className="w-2/3 bg-ricardo-teal"></span>
                        <span className="w-1/3 bg-ricardo-red"></span>
                    </div>
                    <p className="font-literata text-base sm:text-lg text-neutral-200 max-w-2xl leading-relaxed pt-1 font-light">
                        Momentos memorables, actividades académicas, ceremonias cívicas y logros de nuestra comunidad educativa.
                    </p>
                </div>
            </section>

            {/* Mosaico Bento / Columnas Limpias */}
            <section className="bg-white py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    {items.length === 0 ? (
                        <div className="rounded-2xl border border-neutral-200 bg-[#FBFBFA] p-12 text-center text-neutral-500 font-literata">
                            Aún no se han cargado fotografías en la galería institucional.
                        </div>
                    ) : (
                        <div className="columns-1 sm:columns-2 lg:columns-3 gap-6 space-y-6">
                            {items.map((item) => (
                                <article
                                    key={item.id}
                                    className="break-inside-avoid group relative overflow-hidden rounded-2xl border border-neutral-200/90 bg-[#FBFBFA] shadow-xs hover:shadow-md transition-all duration-300"
                                >
                                    <img
                                        src={item.url}
                                        alt={item.titulo || 'Fotografía de la Galería'}
                                        className="w-full h-auto block transition-transform duration-500 ease-out group-hover:scale-105"
                                        loading="lazy"
                                        onError={(e) => { e.currentTarget.src = '/images/logo_color.png'; }}
                                    />
                                    {item.titulo && (
                                        <div className="p-4 border-t border-neutral-100 bg-white">
                                            <p className="font-mate text-xs font-semibold uppercase text-neutral-800 tracking-wider">
                                                {item.titulo}
                                            </p>
                                        </div>
                                    )}
                                </article>
                            ))}
                        </div>
                    )}

                    {/* Paginación */}
                    {links.length > 3 && (
                        <div className="flex items-center justify-center gap-2 pt-6">
                            {links.map((link, idx) => {
                                if (!link.url) {
                                    return (
                                        <span
                                            key={idx}
                                            className="px-3.5 py-2 text-xs font-mate text-neutral-400 select-none"
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    );
                                }
                                return (
                                    <Link
                                        key={idx}
                                        href={link.url}
                                        className={`px-3.5 py-2 text-xs font-mate rounded-xl border transition-colors ${
                                            link.active
                                                ? 'bg-ricardo-teal text-white border-ricardo-teal'
                                                : 'border-neutral-200 bg-white text-neutral-700 hover:border-ricardo-teal hover:text-ricardo-teal'
                                        }`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                );
                            })}
                        </div>
                    )}
                </div>
            </section>
        </AppLayout>
    );
}
