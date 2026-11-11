import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { 
    X, 
    ChevronLeft, 
    ChevronRight, 
    ZoomIn, 
    Image as ImageIcon,
    Camera,
    ArrowLeft,
    Sparkles,
    Grid
} from 'lucide-react';

export default function Galeria({ 
    imagenes = { data: [] }, 
    categorias = [], 
    etiquetaActual = null 
}) {
    const items = imagenes?.data || [];
    const links = imagenes?.links || [];
    const totalFotos = imagenes?.total || items.length;

    // Estado del Lightbox modal a pantalla completa
    const [lightboxIndex, setLightboxIndex] = useState(null);

    // Datos de la categoría activa si está filtrado
    const categoriaActivaObj = etiquetaActual 
        ? categorias.find(c => c.slug === etiquetaActual)
        : null;

    const openLightbox = (index) => {
        setLightboxIndex(index);
    };

    const closeLightbox = () => {
        setLightboxIndex(null);
    };

    const prevImage = (e) => {
        e?.stopPropagation();
        if (lightboxIndex !== null) {
            setLightboxIndex((prev) => (prev > 0 ? prev - 1 : items.length - 1));
        }
    };

    const nextImage = (e) => {
        e?.stopPropagation();
        if (lightboxIndex !== null) {
            setLightboxIndex((prev) => (prev < items.length - 1 ? prev + 1 : 0));
        }
    };

    // Navegación con teclado (Flechas y Escape)
    useEffect(() => {
        const handleKeyDown = (e) => {
            if (lightboxIndex === null) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
        };

        if (lightboxIndex !== null) {
            document.body.style.overflow = 'hidden';
            window.addEventListener('keydown', handleKeyDown);
        } else {
            document.body.style.overflow = 'unset';
        }

        return () => {
            document.body.style.overflow = 'unset';
            window.removeEventListener('keydown', handleKeyDown);
        };
    }, [lightboxIndex]);

    const getCleanTitle = (titulo) => {
        if (!titulo) return null;
        const trimmed = titulo.trim();
        if (/^foto:\s*galeria_[\w.-]+/i.test(trimmed)) return null;
        if (/^galeria_[\w.-]+\.(jpe?g|png|webp)$/i.test(trimmed)) return null;
        if (/\.(jpe?g|png|webp)$/i.test(trimmed)) return null;
        return trimmed;
    };

    const activeItem = lightboxIndex !== null ? items[lightboxIndex] : null;
    const activeTitle = activeItem ? getCleanTitle(activeItem.titulo) : null;
    const activeEtiqueta = activeItem?.etiqueta?.nombre || null;

    return (
        <AppLayout>
            <Head title="Galería de Fotos | I.E.I. N° 31756 Ricardo Palma" />

            {/* Cabecera Editorial */}
            <section className="relative bg-[#FBFBFA] border-b border-neutral-200/80 pt-10 sm:pt-14 pb-12 sm:pb-16">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-6">
                    
                    {/* Migas de pan */}
                    <div className="flex items-center gap-2 font-mate text-xs text-neutral-400 uppercase tracking-wider font-semibold">
                        <Link href="/" className="hover:text-ricardo-teal transition-colors">Inicio</Link>
                        <span>/</span>
                        <span className="text-neutral-700">Comunidad</span>
                        <span>/</span>
                        {etiquetaActual ? (
                            <>
                                <Link href="/galeria" className="hover:text-ricardo-teal transition-colors">Galería</Link>
                                <span>/</span>
                                <span className="text-ricardo-teal">{categoriaActivaObj?.nombre || etiquetaActual}</span>
                            </>
                        ) : (
                            <span className="text-ricardo-teal">Galería</span>
                        )}
                    </div>

                    {/* Presentación */}
                    <div className="flex flex-col md:flex-row md:items-end justify-between gap-6">
                        <div className="max-w-2xl space-y-3">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-bold block">
                                {etiquetaActual ? `Colección Fotográfica • ${categoriaActivaObj?.nombre || ''}` : 'Registro Visual Institucional'}
                            </span>
                            <h1 className="font-mate text-3xl sm:text-4xl lg:text-5xl text-neutral-900 uppercase font-bold tracking-tight leading-[1.15]">
                                {etiquetaActual ? (categoriaActivaObj?.nombre || 'Galería') : 'Galería de Fotos'}
                            </h1>
                            <div className="flex h-1 w-20">
                                <span className="w-2/3 bg-ricardo-teal"></span>
                                <span className="w-1/3 bg-ricardo-red"></span>
                            </div>
                            <p className="font-literata text-sm sm:text-base text-neutral-600 leading-relaxed font-light pt-1">
                                {etiquetaActual 
                                    ? `Explorando las fotografías y momentos destacados de la categoría "${categoriaActivaObj?.nombre || etiquetaActual}".`
                                    : 'Vivencias, ceremonias cívicas, logros deportivos y actividades de la comunidad educativa ricardina en Cerro de Pasco.'}
                            </p>
                        </div>

                        {/* Botón Volver / Contador */}
                        <div className="flex items-center gap-3 self-start md:self-auto shrink-0">
                            {etiquetaActual && (
                                <Link
                                    href="/galeria"
                                    className="btn-admin-secondary text-xs flex items-center gap-1.5 shadow-2xs"
                                >
                                    <ArrowLeft className="w-3.5 h-3.5" />
                                    <span>Ver todas las categorías</span>
                                </Link>
                            )}

                            {totalFotos > 0 && (
                                <div className="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white border border-neutral-200/80 shadow-2xs text-xs font-mate uppercase tracking-wider text-neutral-600">
                                    <Camera className="w-4 h-4 text-ricardo-teal" />
                                    <span>{totalFotos} {totalFotos === 1 ? 'Fotografía' : 'Fotografías'}</span>
                                </div>
                            )}
                        </div>
                    </div>

                </div>
            </section>

            {/* SECCIÓN 1: VISTA DE PORTADAS POR CATEGORÍA (MOSAICO PRINCIPAL) */}
            {!etiquetaActual && categorias.length > 0 && (
                <section className="bg-white py-12 sm:py-16 border-b border-neutral-200/80">
                    <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-8">
                        
                        <div className="space-y-1">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-bold block">
                                Explorar por Álbum
                            </span>
                            <h2 className="font-mate text-2xl sm:text-3xl text-neutral-900 font-bold uppercase tracking-tight">
                                Categorías Institucionales
                            </h2>
                            <p className="font-literata text-xs sm:text-sm text-neutral-500">
                                Haz clic en una categoría para abrir el mosaico de fotos de esa sección.
                            </p>
                        </div>

                        {/* Mosaico Asimétrico Dinámico de Portadas de Etiquetas */}
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 auto-rows-[240px]">
                            {categorias.map((cat, idx) => {
                                // Patrón de mosaico asimétrico tipo Pinterest / Editorial
                                const isFeatured = idx === 0 || (idx % 5 === 0);
                                const isWide = idx === 1 || (idx % 7 === 0);
                                const tileClass = isFeatured 
                                    ? 'sm:col-span-2 sm:row-span-2' 
                                    : isWide 
                                        ? 'lg:col-span-2 sm:row-span-1' 
                                        : 'col-span-1 row-span-1';

                                return (
                                    <Link
                                        key={cat.id}
                                        href={`/galeria?etiqueta=${cat.slug}`}
                                        className={`group relative h-full w-full rounded-3xl overflow-hidden border border-neutral-200/90 shadow-2xs hover:shadow-2xl transition-all duration-500 select-none block bg-neutral-900 ${tileClass}`}
                                    >
                                        {/* Imagen de Portada de la Etiqueta */}
                                        <img
                                            src={cat.portada_url}
                                            alt={cat.nombre}
                                            className="w-full h-full object-cover opacity-85 transition-transform duration-700 ease-out group-hover:scale-110 group-hover:opacity-100"
                                            loading="lazy"
                                        />

                                        {/* Capa de Opacidad Negra para contraste */}
                                        <div className="absolute inset-0 bg-black/45 group-hover:bg-black/30 transition-colors duration-500" />

                                        {/* Título en Blanco al Centro: se hace más grande y notorio en hover */}
                                        <div className="absolute inset-0 flex flex-col items-center justify-center p-6 text-center space-y-2 z-10">
                                            <h3 className="font-mate text-2xl sm:text-3xl lg:text-4xl font-bold uppercase tracking-wider text-white drop-shadow-md transition-all duration-300 transform group-hover:scale-115 group-hover:tracking-widest">
                                                {cat.nombre}
                                            </h3>
                                            <span className="inline-block px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-mate font-bold uppercase tracking-wider text-white shadow-xs transition-opacity duration-300">
                                                {cat.total_fotos} {cat.total_fotos === 1 ? 'Foto' : 'Fotos'}
                                            </span>
                                        </div>

                                        {/* Borde sutil animado al hover */}
                                        <div className="absolute inset-0 border-2 border-white/0 group-hover:border-white/30 rounded-3xl transition-colors duration-300 pointer-events-none" />
                                    </Link>
                                );
                            })}
                        </div>

                    </div>
                </section>
            )}

            {/* SECCIÓN 2: MOSAICO DE TODAS LAS FOTOS (O DE LA ETIQUETA SELECCIONADA CON ANIMACIÓN) */}
            <section className="bg-[#FBFBFA] py-12 sm:py-16 border-b border-neutral-200/80">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-8 animate-fadeIn">
                    
                    {/* Barra de Navegación de Categorías si estamos dentro de una categoría */}
                    {etiquetaActual && (
                        <div className="flex items-center justify-between gap-4 flex-wrap bg-white p-4 rounded-2xl border border-neutral-200/80 shadow-2xs">
                            <div className="flex items-center gap-2 flex-wrap">
                                <span className="font-mate text-xs uppercase tracking-wider font-bold text-neutral-400 mr-1">
                                    Otras categorías:
                                </span>

                                <Link
                                    href="/galeria"
                                    className="px-3.5 py-1.5 rounded-full text-xs font-mate uppercase tracking-wider font-bold transition-all bg-white border border-neutral-200 text-neutral-600 hover:border-neutral-300 hover:text-neutral-900"
                                >
                                    Ver Todo
                                </Link>

                                {categorias.map((cat) => (
                                    <Link
                                        key={cat.id}
                                        href={`/galeria?etiqueta=${cat.slug}`}
                                        className={`px-3.5 py-1.5 rounded-full text-xs font-mate uppercase tracking-wider font-bold transition-all ${
                                            etiquetaActual === cat.slug
                                                ? 'bg-ricardo-teal text-white shadow-xs'
                                                : 'bg-white border border-neutral-200 text-neutral-600 hover:border-neutral-300 hover:text-neutral-900'
                                        }`}
                                    >
                                        <span>{cat.nombre}</span>
                                    </Link>
                                ))}
                            </div>

                            <span className="text-xs font-literata text-neutral-400">
                                Mostrando {items.length} fotos
                            </span>
                        </div>
                    )}

                    {!etiquetaActual && (
                        <div className="space-y-1">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-bold block">
                                Cuadrícula General
                            </span>
                            <h2 className="font-mate text-2xl sm:text-3xl text-neutral-900 font-bold uppercase tracking-tight">
                                Todas las Fotografías
                            </h2>
                        </div>
                    )}

                    {items.length === 0 ? (
                        <div className="rounded-3xl border border-dashed border-neutral-300 bg-white p-16 text-center space-y-3">
                            <div className="w-12 h-12 rounded-2xl bg-neutral-100 text-neutral-400 flex items-center justify-center mx-auto">
                                <ImageIcon className="w-6 h-6" />
                            </div>
                            <h3 className="font-mate text-base font-bold text-neutral-800 uppercase tracking-tight">
                                No se encontraron fotografías
                            </h3>
                            <p className="font-literata text-xs text-neutral-500 max-w-sm mx-auto">
                                {etiquetaActual
                                    ? 'No hay imágenes registradas bajo esta categoría.'
                                    : 'Las fotografías publicadas por la institución aparecerán ordenadas aquí.'}
                            </p>
                            {etiquetaActual && (
                                <Link
                                    href="/galeria"
                                    className="inline-block mt-2 text-xs font-mate font-semibold text-ricardo-teal hover:underline uppercase tracking-wider"
                                >
                                    Volver a ver todas las fotografías
                                </Link>
                            )}
                        </div>
                    ) : (
                        /* Mosaico Asimétrico Editorial de Fotografías */
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 auto-rows-[280px] animate-fadeIn">
                            {items.map((item, index) => {
                                const cleanTitle = getCleanTitle(item.titulo);
                                const etiqueta = item.etiqueta?.nombre;

                                // Variación de altura y ancho para el efecto mosaico
                                const isTall = index % 5 === 1;
                                const isWide = index % 5 === 3;
                                const spanClass = isTall 
                                    ? 'sm:row-span-2' 
                                    : isWide 
                                        ? 'lg:col-span-2 sm:row-span-1' 
                                        : 'col-span-1 row-span-1';

                                return (
                                    <article
                                        key={item.id}
                                        onClick={() => openLightbox(index)}
                                        className={`group relative flex flex-col justify-end overflow-hidden rounded-3xl border border-neutral-200/90 bg-neutral-900 shadow-2xs hover:shadow-2xl transition-all duration-500 cursor-pointer select-none ${spanClass}`}
                                    >
                                        {/* Imagen de fondo */}
                                        <img
                                            src={item.url}
                                            alt={cleanTitle || 'Fotografía de la Galería'}
                                            className="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110"
                                            loading="lazy"
                                        />

                                        {/* Degradado para legibilidad del texto */}
                                        <div className="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-black/10 group-hover:from-black/90 group-hover:via-black/40 transition-colors duration-300" />

                                        {/* Etiqueta flotante */}
                                        {etiqueta && (
                                            <div className="absolute top-4 left-4 z-10">
                                                <span className="font-mate text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-white/20 text-white backdrop-blur-md shadow-xs">
                                                    {etiqueta}
                                                </span>
                                            </div>
                                        )}

                                        {/* Icono de zoom en esquina */}
                                        <div className="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-1 group-hover:translate-y-0">
                                            <span className="w-9 h-9 rounded-2xl bg-white/25 hover:bg-white text-white hover:text-neutral-900 backdrop-blur-md flex items-center justify-center shadow-xs transition-colors">
                                                <ZoomIn className="w-4 h-4" />
                                            </span>
                                        </div>

                                        {/* Título en la parte inferior */}
                                        <div className="relative p-5 z-10 space-y-1">
                                            <h3 className="font-mate text-base sm:text-lg font-bold text-white tracking-wide line-clamp-2 drop-shadow-md group-hover:text-emerald-300 transition-colors">
                                                {cleanTitle || 'Fotografía Institucional'}
                                            </h3>
                                        </div>

                                        {/* Borde interactivo */}
                                        <div className="absolute inset-0 border-2 border-white/0 group-hover:border-white/30 rounded-3xl transition-colors duration-300 pointer-events-none" />
                                    </article>
                                );
                            })}
                        </div>
                    )}

                    {/* Paginación Armónica */}
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
                                        preserveScroll
                                        className={`px-3.5 py-2 text-xs font-mate rounded-xl border transition-all cursor-pointer ${
                                            link.active
                                                ? 'bg-ricardo-teal text-white border-ricardo-teal shadow-xs'
                                                : 'border-neutral-200 bg-white text-neutral-700 hover:border-ricardo-teal hover:text-ricardo-teal shadow-2xs'
                                        }`}
                                        dangerouslySetInnerHTML={{ __html: link.label }}
                                    />
                                );
                            })}
                        </div>
                    )}
                </div>
            </section>

            {/* Modal Lightbox a Pantalla Completa */}
            {lightboxIndex !== null && activeItem && (
                <div 
                    onClick={closeLightbox}
                    className="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-md p-4 sm:p-6 select-none animate-fadeIn"
                >
                    {/* Botón Cerrar */}
                    <button
                        type="button"
                        onClick={closeLightbox}
                        className="absolute top-4 right-4 z-50 p-2.5 rounded-2xl bg-white/10 hover:bg-white/25 text-white backdrop-blur-md transition-colors cursor-pointer"
                        title="Cerrar (Esc)"
                    >
                        <X className="w-5 h-5" />
                    </button>

                    {/* Indicador de posición y etiqueta */}
                    <div className="absolute top-4 left-4 z-50 flex items-center gap-2">
                        <div className="px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md text-xs font-mate tracking-wider text-white/90">
                            {lightboxIndex + 1} de {items.length}
                        </div>
                        {activeEtiqueta && (
                            <span className="px-3 py-1 rounded-xl bg-teal-500/80 backdrop-blur-md text-xs font-mate font-bold uppercase tracking-wider text-white">
                                {activeEtiqueta}
                            </span>
                        )}
                    </div>

                    {/* Flecha Anterior */}
                    {items.length > 1 && (
                        <button
                            type="button"
                            onClick={prevImage}
                            className="absolute left-3 sm:left-6 z-50 p-3 rounded-2xl bg-white/10 hover:bg-white/25 text-white backdrop-blur-md transition-all hover:scale-105 cursor-pointer"
                            title="Anterior (Flecha izquierda)"
                        >
                            <ChevronLeft className="w-6 h-6" />
                        </button>
                    )}

                    {/* Contenedor de la Imagen y Título */}
                    <div 
                        onClick={(e) => e.stopPropagation()}
                        className="relative max-w-4xl max-h-[90vh] flex flex-col items-center justify-center space-y-3"
                    >
                        <img
                            src={activeItem.url}
                            alt={activeTitle || 'Fotografía de la Galería'}
                            className="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl"
                        />

                        {activeTitle && (
                            <div className="text-center px-6 py-2.5 rounded-2xl bg-black/60 backdrop-blur-md max-w-2xl">
                                <p className="font-mate text-sm sm:text-base font-bold text-white tracking-wide">
                                    {activeTitle}
                                </p>
                            </div>
                        )}
                    </div>

                    {/* Flecha Siguiente */}
                    {items.length > 1 && (
                        <button
                            type="button"
                            onClick={nextImage}
                            className="absolute right-3 sm:right-6 z-50 p-3 rounded-2xl bg-white/10 hover:bg-white/25 text-white backdrop-blur-md transition-all hover:scale-105 cursor-pointer"
                            title="Siguiente (Flecha derecha)"
                        >
                            <ChevronRight className="w-6 h-6" />
                        </button>
                    )}
                </div>
            )}
        </AppLayout>
    );
}
