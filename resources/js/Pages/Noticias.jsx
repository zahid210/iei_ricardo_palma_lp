import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { 
    Calendar, 
    ArrowRight, 
    ExternalLink 
} from 'lucide-react';

export default function Noticias({ destacada, secundarias = [], otrasNoticias = [] }) {
    return (
        <AppLayout>
            <Head title="Noticias & Prensa | I.E.I. N° 31756 Ricardo Palma" />

            {/* =========================================================================
                1. CABECERA EDITORIAL INSTITUCIONAL (FONDO MARFIL, TIPOGRAFÍA NOBLE)
               ========================================================================= */}
            <section className="relative bg-[#FBFBFA] border-b border-neutral-200/80 pt-10 sm:pt-14 pb-14 sm:pb-18">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-6">
                    
                    {/* Migas de pan institucionales */}
                    <div className="flex items-center gap-2 font-mate text-xs text-neutral-400 uppercase tracking-wider font-semibold">
                        <Link href="/" className="hover:text-ricardo-teal transition-colors">Inicio</Link>
                        <span>/</span>
                        <span className="text-neutral-700">Comunidad Ricardina</span>
                        <span>/</span>
                        <span className="text-ricardo-teal">Noticias & Sala de Prensa</span>
                    </div>

                    {/* Presentación */}
                    <div className="max-w-3xl space-y-4">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-bold block">
                            Noticias y Actividades
                        </span>
                        <h1 className="font-mate text-3xl sm:text-5xl lg:text-[46px] text-neutral-900 uppercase font-bold tracking-tight leading-[1.15]">
                            Noticias del Colegio
                        </h1>
                        <div className="flex h-1 w-24">
                            <span className="w-2/3 bg-ricardo-teal"></span>
                            <span className="w-1/3 bg-ricardo-red"></span>
                        </div>
                        <p className="font-literata text-base sm:text-lg text-neutral-700 leading-relaxed font-light pt-1">
                            Actividades escolares, eventos cívicos, logros de nuestros alumnos y comunicados para los padres de familia en Cerro de Pasco.
                        </p>
                    </div>

                </div>
            </section>

            {/* =========================================================================
                2. CONTENIDO PRINCIPAL: GACETA EDITORIAL
               ========================================================================= */}
            <section className="bg-white py-12 sm:py-16">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-16">
                    
                    {destacada ? (
                        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                            
                            {/* Noticia Principal Destacada (Gran Formato Asimétrico) */}
                            <div className="lg:col-span-7">
                                <Link
                                    href={`/noticias/${destacada.slug}`}
                                    className="group block rounded-2xl overflow-hidden border border-neutral-200/80 bg-[#FBFBFA] hover:bg-white hover:border-ricardo-teal/40 transition-all duration-300 shadow-2xs hover:shadow-xs"
                                >
                                    <div className="aspect-[16/10] overflow-hidden bg-neutral-100 relative">
                                        <img
                                            src={destacada.imagen ? `/${destacada.imagen}` : '/images/banners/fachada_colegio.jpg'}
                                            alt={destacada.titulo}
                                            className="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105"
                                            onError={(e) => { e.currentTarget.src = '/images/banners/fachada_colegio.jpg'; }}
                                        />
                                        <div className="absolute top-4 left-4">
                                            <span className="px-3 py-1 rounded-md text-[11px] font-mate uppercase font-bold tracking-wider bg-ricardo-red text-white shadow-xs">
                                                Noticia Destacada
                                            </span>
                                        </div>
                                    </div>

                                    <div className="p-6 sm:p-8 space-y-4">
                                        <div className="flex items-center gap-1.5 text-xs font-mate text-ricardo-teal font-semibold">
                                            <Calendar className="w-3.5 h-3.5" />
                                            <span>
                                                {destacada.fecha_publicacion 
                                                    ? new Date(destacada.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'long', year: 'numeric' }) 
                                                    : 'Fecha institucional'}
                                            </span>
                                        </div>

                                        <h2 className="font-mate text-2xl sm:text-3xl font-bold uppercase text-neutral-900 group-hover:text-ricardo-teal transition-colors tracking-tight leading-tight">
                                            {destacada.titulo}
                                        </h2>

                                        <p className="font-literata text-base text-neutral-600 line-clamp-3 leading-relaxed">
                                            {destacada.extracto || destacada.contenido?.replace(/<[^>]+>/g, '').substring(0, 180) + '...'}
                                        </p>

                                        <div className="pt-2 inline-flex items-center gap-2 font-mate text-xs uppercase tracking-wider font-bold text-ricardo-teal group-hover:translate-x-1 transition-transform">
                                            <span>Leer noticia completa</span>
                                            <ArrowRight className="w-3.5 h-3.5" />
                                        </div>
                                    </div>
                                </Link>
                            </div>

                            {/* Noticias Secundarias (Columna Derecha) */}
                            <div className="lg:col-span-5 space-y-4">
                                <div className="border-b border-neutral-200/80 pb-3">
                                    <span className="font-mate text-xs uppercase tracking-widest text-neutral-400 font-bold">
                                        Noticias Recientes
                                    </span>
                                </div>

                                <div className="space-y-3.5">
                                    {secundarias.map((item) => (
                                        <Link
                                            key={item.id}
                                            href={`/noticias/${item.slug}`}
                                            className="group flex gap-4 p-3.5 rounded-xl border border-neutral-200/80 bg-[#FBFBFA] hover:bg-white hover:border-ricardo-teal/40 transition-all duration-200 shadow-2xs hover:shadow-xs"
                                        >
                                            <div className="w-24 sm:w-28 h-20 rounded-lg overflow-hidden shrink-0 bg-neutral-100">
                                                <img
                                                    src={item.imagen ? `/${item.imagen}` : '/images/banners/fachada_colegio.jpg'}
                                                    alt={item.titulo}
                                                    className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                                    onError={(e) => { e.currentTarget.src = '/images/banners/fachada_colegio.jpg'; }}
                                                />
                                            </div>

                                            <div className="min-w-0 flex-1 space-y-1">
                                                <span className="font-mate text-[11px] uppercase tracking-wider text-neutral-400 font-semibold block">
                                                    {item.fecha_publicacion 
                                                        ? new Date(item.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'short', year: 'numeric' }) 
                                                        : ''}
                                                </span>
                                                <h3 className="font-mate text-sm sm:text-base font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors leading-snug line-clamp-2">
                                                    {item.titulo}
                                                </h3>
                                            </div>
                                        </Link>
                                    ))}
                                </div>
                            </div>

                        </div>
                    ) : (
                        <div className="rounded-2xl border border-neutral-200 bg-[#FBFBFA] p-12 text-center text-neutral-500 font-literata">
                            No hay publicaciones registradas por el momento.
                        </div>
                    )}

                    {/* Archivo / Más Noticias */}
                    {otrasNoticias.length > 0 && (
                        <div className="pt-10 border-t border-neutral-200/80 space-y-8">
                            <div className="border-l-2 border-ricardo-teal pl-4 space-y-1">
                                <h2 className="font-mate text-xl sm:text-2xl font-bold uppercase text-neutral-900 tracking-tight">
                                    Más Noticias y Actividades
                                </h2>
                                <p className="font-literata text-xs sm:text-sm text-neutral-500">
                                    Otras actividades y publicaciones de nuestro colegio.
                                </p>
                            </div>

                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                {otrasNoticias.map((item) => (
                                    <NoticiaCard key={item.id} noticia={item} />
                                ))}
                            </div>
                        </div>
                    )}

                </div>
            </section>

            {/* =========================================================================
                3. CANAL DE COMUNICACIÓN EN REDES SOCIALES (FACEBOOK INSTITUCIONAL)
               ========================================================================= */}
            <section className="bg-[#FBFBFA] border-t border-neutral-200/80 py-12">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="rounded-2xl border border-neutral-200/80 bg-white p-6 sm:p-8 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 shadow-2xs">
                        <div className="space-y-1.5 max-w-2xl">
                            <span className="font-mate text-xs uppercase tracking-widest text-[#1877F2] font-bold block">
                                Transmisiones & Cobertura en Vivo
                            </span>
                            <h3 className="font-mate text-lg sm:text-xl font-bold text-neutral-900">
                                Sigue el día a día en nuestra página oficial de Facebook
                            </h3>
                            <p className="font-literata text-xs sm:text-sm text-neutral-600 leading-relaxed font-light">
                                Actos cívicos de los lunes, desfiles escolares, campeonatos deportivos y comunicados urgentes para padres de familia.
                            </p>
                        </div>

                        {/* Botón Estilo Facebook Oficial */}
                        <a
                            href="https://www.facebook.com/ricardinosemprendeores"
                            target="_blank"
                            rel="noopener noreferrer"
                            className="inline-flex items-center gap-2.5 px-5 py-3 rounded-xl bg-[#1877F2] hover:bg-[#166FE5] text-white font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-xs hover:shadow-sm shrink-0 cursor-pointer"
                        >
                            <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            <span>Seguir en Facebook</span>
                            <ExternalLink className="w-3.5 h-3.5 opacity-80" />
                        </a>
                    </div>
                </div>
            </section>
        </AppLayout>
    );
}

// Tarjeta editorial para noticias en rejilla
function NoticiaCard({ noticia }) {
    return (
        <Link
            href={`/noticias/${noticia.slug}`}
            className="group flex flex-col rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] hover:bg-white hover:border-ricardo-teal/40 overflow-hidden transition-all duration-200 shadow-2xs hover:shadow-xs"
        >
            <div className="aspect-[16/10] overflow-hidden bg-neutral-100">
                <img
                    src={noticia.imagen ? `/${noticia.imagen}` : '/images/banners/fachada_colegio.jpg'}
                    alt={noticia.titulo}
                    className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    onError={(e) => { e.currentTarget.src = '/images/banners/fachada_colegio.jpg'; }}
                />
            </div>

            <div className="p-5 flex-1 flex flex-col justify-between space-y-3">
                <div className="space-y-2">
                    <span className="font-mate text-[11px] uppercase tracking-wider text-neutral-400 font-semibold block">
                        {noticia.fecha_publicacion 
                            ? new Date(noticia.fecha_publicacion).toLocaleDateString('es-PE', { day: 'numeric', month: 'short', year: 'numeric' }) 
                            : ''}
                    </span>
                    <h3 className="font-mate text-base font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors leading-snug line-clamp-2">
                        {noticia.titulo}
                    </h3>
                    <p className="font-literata text-xs text-neutral-600 line-clamp-2 leading-relaxed">
                        {noticia.extracto || noticia.contenido?.replace(/<[^>]+>/g, '').substring(0, 100) + '...'}
                    </p>
                </div>

                <div className="pt-2 inline-flex items-center gap-1.5 font-mate text-xs uppercase tracking-wider font-bold text-ricardo-teal group-hover:translate-x-1 transition-transform">
                    <span>Leer más</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                </div>
            </div>
        </Link>
    );
}
