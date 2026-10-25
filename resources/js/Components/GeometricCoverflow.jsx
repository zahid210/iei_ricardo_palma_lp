import React, { useState, useRef } from 'react';
import { ChevronLeft, ChevronRight } from 'lucide-react';

/**
 * GeometricCoverflow
 * Componente Coverflow Geométrico Institucional.
 * - Mantiene el diseño original acoplado con tarjeta activa al centro y laterales superpuestas.
 * - Las tarjetas forman un bloque armónico y cohesivo (sin separaciones rígidas ni fotos desacopladas).
 * - Paginación 100% limpia sin borde ni background:
 *   - Flechitas de orden discretas.
 *   - Ventana deslizante que muestra siempre exactamente 3 dots sobre una cadena horizontal continua.
 *   - Los dots tienen suficiente margen y máscara lateral suave para que NUNCA se corten en los bordes.
 *   - Intercambio fluido de color institucional (Verde y Rojo Ricardino).
 */
export default function GeometricCoverflow({ 
    slides = [], 
    maxWidth = 'max-w-7xl',
    height = 'h-[310px] sm:h-[350px] lg:h-[380px]' 
}) {
    const [currentIndex, setCurrentIndex] = useState(0);
    const total = slides.length;
    const touchStartX = useRef(null);

    if (total === 0) return null;

    const showNext = () => {
        setCurrentIndex((prev) => (prev + 1) % total);
    };

    const showPrev = () => {
        setCurrentIndex((prev) => (prev - 1 + total) % total);
    };

    const handleTouchStart = (e) => {
        touchStartX.current = e.touches[0].clientX;
    };

    const handleTouchEnd = (e) => {
        if (touchStartX.current === null) return;
        const touchEndX = e.changedTouches[0].clientX;
        const diffX = touchStartX.current - touchEndX;
        if (diffX > 45) {
            showNext();
        } else if (diffX < -45) {
            showPrev();
        }
        touchStartX.current = null;
    };

    const handleKeyDown = (e) => {
        if (e.key === 'ArrowLeft') showPrev();
        if (e.key === 'ArrowRight') showNext();
    };

    // Cadena horizontal de dots con ventana deslizante fija de 3 dots
    // Paso horizontal = 10px dot + 12px gap = 22px
    const dotStep = 22;
    const maxWindowOffset = Math.max(0, total - 3);
    const windowOffset = Math.max(0, Math.min(currentIndex - 1, maxWindowOffset));
    const dotsTranslateX = -windowOffset * dotStep;

    return (
        <div 
            className="w-full pt-2 pb-2 flex flex-col items-center select-none overflow-hidden focus:outline-none"
            tabIndex={0}
            onKeyDown={handleKeyDown}
            onTouchStart={handleTouchStart}
            onTouchEnd={handleTouchEnd}
            aria-roledescription="carousel"
            aria-label="Galería interactiva"
        >
            {/* Viewport del Coverflow Geométrico Original Acoplado */}
            <div className={`relative w-full ${maxWidth} ${height} flex items-center justify-center [perspective:1200px]`}>
                {slides.map((slide, i) => {
                    let diff = (i - currentIndex) % total;
                    if (diff > total / 2) diff -= total;
                    if (diff < -total / 2) diff += total;

                    let pos = 'hidden';
                    if (diff === 0) pos = '0';
                    else if (diff === -1) pos = '-1';
                    else if (diff === 1) pos = '1';
                    else if (diff === -2) pos = '-2';
                    else if (diff === 2) pos = '2';
                    else if (diff < -2) pos = 'hidden-left';
                    else if (diff > 2) pos = 'hidden-right';

                    const isCenter = pos === '0';

                    return (
                        <article
                            key={i}
                            data-pos={pos}
                            onClick={() => {
                                if (!isCenter) setCurrentIndex(i);
                            }}
                            className="carousel-card"
                            aria-hidden={!isCenter}
                        >
                            <img
                                src={slide.src}
                                alt={slide.alt || 'Fotografía escolar'}
                                className="w-full h-full object-cover object-center pointer-events-none"
                                onError={(e) => {
                                    if (slide.fallback) e.currentTarget.src = slide.fallback;
                                }}
                            />
                        </article>
                    );
                })}
            </div>

            {/* Paginación Limpia: Cero borde, cero background, exactamente 3 dots visibles en cadena suave */}
            <div 
                className="mt-6 sm:mt-8 flex items-center justify-center gap-3.5"
                role="navigation"
                aria-label="Controles del carrusel"
            >
                {/* Flechita Anterior */}
                <button
                    type="button"
                    onClick={showPrev}
                    className="p-1.5 text-neutral-400 hover:text-neutral-900 transition-colors cursor-pointer focus:outline-none"
                    aria-label="Foto anterior"
                >
                    <ChevronLeft className="w-4 h-4 stroke-[2.2]" />
                </button>

                {/* Ventana de 3 Dots con margen y máscara suave para evitar cualquier corte lateral */}
                <div 
                    className="relative w-[76px] h-7 flex items-center overflow-hidden [mask-image:linear-gradient(to_right,transparent,black_14%,black_86%,transparent)]"
                >
                    <div 
                        className="flex items-center gap-3 transition-transform duration-300 ease-out will-change-transform px-2.5"
                        style={{ transform: `translateX(${dotsTranslateX}px)` }}
                    >
                        {slides.map((_, idx) => {
                            const isActive = idx === currentIndex;
                            const activeColor = (idx % 2 === 0) 
                                ? 'bg-ricardo-teal shadow-[0_2px_8px_rgba(18,149,130,0.45)]' 
                                : 'bg-ricardo-red shadow-[0_2px_8px_rgba(202,23,8,0.45)]';

                            return (
                                <button
                                    key={idx}
                                    type="button"
                                    onClick={() => setCurrentIndex(idx)}
                                    role="tab"
                                    aria-selected={isActive}
                                    aria-label={`Ir a fotografía ${idx + 1}`}
                                    className={`flex-none rounded-full transition-all duration-300 cursor-pointer focus:outline-none ${
                                        isActive 
                                            ? `w-2.5 h-2.5 ${activeColor} scale-110` 
                                            : 'w-2 h-2 bg-neutral-300 hover:bg-neutral-400'
                                    }`}
                                />
                            );
                        })}
                    </div>
                </div>

                {/* Flechita Siguiente */}
                <button
                    type="button"
                    onClick={showNext}
                    className="p-1.5 text-neutral-400 hover:text-neutral-900 transition-colors cursor-pointer focus:outline-none"
                    aria-label="Foto siguiente"
                >
                    <ChevronRight className="w-4 h-4 stroke-[2.2]" />
                </button>
            </div>
        </div>
    );
}
