import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { 
    X, 
    ChevronLeft, 
    ChevronRight, 
    ZoomIn, 
    Image as ImageIcon,
    Camera
} from 'lucide-react';

export default function Galeria({ imagenes = { data: [] } }) {
    const items = imagenes?.data || [];
    const links = imagenes?.links || [];
    const totalFotos = imagenes?.total || items.length;

    // Estado del Lightbox modal a pantalla completa
    const [lightboxIndex, setLightboxIndex] = useState(null);

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

    // Filtrar títulos que sean nombres de archivo crudos o auto-generados feos
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

    return (
        <AppLayout>
            <Head title="Galería de Fotos | I.E.I. N° 31756 Ricardo Palma" />

            {/* Cabecera Editorial Limpia */}
            <section className="relative bg-[#FBFBFA] border-b border-neutral-200/80 pt-10 sm:pt-14 pb-12 sm:pb-16">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-6">
                    
                    {/* Migas de pan */}
                    <div className="flex items-center gap-2 font-mate text-xs text-neutral-400 uppercase tracking-wider font-semibold">
                        <Link href="/" className="hover:text-ricardo-teal transition-colors">Inicio</Link>
                        <span>/</span>
                        <span className="text-neutral-700">Comunidad</span>
                        <span>/</span>
                        <span className="text-ricardo-teal">Galería</span>
                    </div>

                    {/* Presentación */}
                    <div className="flex flex-col md:flex-row md:items-end justify-between gap-6">
                        <div className="max-w-2xl space-y-3">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-bold block">
                                Registro Visual Institucional
                            </span>
                            <h1 className="font-mate text-3xl sm:text-4xl lg:text-5xl text-neutral-900 uppercase font-bold tracking-tight leading-[1.15]">
                                Galería de Fotos
                            </h1>
                            <div className="flex h-1 w-20">
                                <span className="w-2/3 bg-ricardo-teal"></span>
                                <span className="w-1/3 bg-ricardo-red"></span>
                            </div>
                            <p className="font-literata text-sm sm:text-base text-neutral-600 leading-relaxed font-light pt-1">
                                Vivencias, ceremonias cívicas, logros deportivos y actividades de la comunidad educativa ricardina en Cerro de Pasco.
                            </p>
                        </div>

                        {/* Contador de fotos */}
                        {totalFotos > 0 && (
                            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white border border-neutral-200/80 shadow-2xs text-xs font-mate uppercase tracking-wider text-neutral-600 self-start md:self-auto shrink-0">
                                <Camera className="w-4 h-4 text-ricardo-teal" />
                                <span>{totalFotos} {totalFotos === 1 ? 'Fotografía' : 'Fotografías'}</span>
                            </div>
                        )}
                    </div>

                </div>
            </section>

            {/* Cuadrícula de Fotografías Moderna y Ordenada */}
            <section className="bg-white py-12 sm:py-16 border-b border-neutral-200/80">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    {items.length === 0 ? (
                        <div className="rounded-3xl border border-dashed border-neutral-300 bg-[#FBFBFA] p-16 text-center space-y-3">
                            <div className="w-12 h-12 rounded-2xl bg-neutral-100 text-neutral-400 flex items-center justify-center mx-auto">
                                <ImageIcon className="w-6 h-6" />
                            </div>
                            <h3 className="font-mate text-base font-bold text-neutral-800 uppercase tracking-tight">
                                Aún no hay fotografías en la galería
                            </h3>
                            <p className="font-literata text-xs text-neutral-500 max-w-sm mx-auto">
                                Las fotografías publicadas por la institución aparecerán ordenadas aquí.
                            </p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
                            {items.map((item, index) => {
                                const cleanTitle = getCleanTitle(item.titulo);

                                return (
                                    <article
                                        key={item.id}
                                        onClick={() => openLightbox(index)}
                                        className="group relative aspect-[4/3] overflow-hidden rounded-3xl border border-neutral-200/90 bg-neutral-100 shadow-2xs hover:shadow-xl transition-all duration-300 cursor-pointer select-none"
                                    >
                                        <img
                                            src={item.url}
                                            alt={cleanTitle || 'Fotografía de la Galería'}
                                            className="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-108"
                                            loading="lazy"
                                        />

                                        {/* Overlay elegante en hover */}
                                        <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between p-5">
                                            {/* Botón de ampliar en la esquina superior */}
                                            <div className="flex justify-end">
                                                <span className="w-9 h-9 rounded-2xl bg-white/20 hover:bg-white/30 backdrop-blur-md text-white flex items-center justify-center shadow-sm transition-transform group-hover:scale-105">
                                                    <ZoomIn className="w-4 h-4" />
                                                </span>
                                            </div>

                                            {/* Título en la parte inferior si es descriptivo */}
                                            {cleanTitle && (
                                                <div className="space-y-1 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                                    <p className="font-mate text-sm font-bold text-white tracking-wide leading-snug line-clamp-2">
                                                        {cleanTitle}
                                                    </p>
                                                    <span className="text-[11px] font-literata text-white/80 block">
                                                        Clic para ver en tamaño completo
                                                    </span>
                                                </div>
                                            )}
                                        </div>
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

                    {/* Indicador de posición */}
                    <div className="absolute top-4 left-4 z-50 px-3.5 py-1.5 rounded-xl bg-white/10 backdrop-blur-md text-xs font-mate tracking-wider text-white/90">
                        {lightboxIndex + 1} de {items.length}
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

                    {/* Contenedor de la Imagen */}
                    <div 
                        onClick={(e) => e.stopPropagation()}
                        className="relative max-w-5xl max-h-[85vh] flex flex-col items-center justify-center space-y-3"
                    >
                        <img
                            src={activeItem.url}
                            alt={activeTitle || 'Fotografía de la Galería'}
                            className="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl"
                        />

                        {activeTitle && (
                            <div className="text-center px-4 py-2 rounded-xl bg-black/40 backdrop-blur-sm max-w-xl">
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
