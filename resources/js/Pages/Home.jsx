import React, { useState, useEffect } from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import GeometricCoverflow from '../Components/GeometricCoverflow';
import { ArrowRight, Users, GraduationCap } from 'lucide-react';

export default function Home({ noticias = [], galeria = [], docentesCount = 51 }) {
    // 1. Fotografías reales del Hero (transición suave automática cada 6 segundos)
    const heroSlides = [
        {
            src: '/images/banners/fachada_colegio.jpg',
            fallback: '/images/fachada_colegio.jpg',
            alt: 'Fachada de la I.E.I. Ricardo Palma'
        },
        {
            src: '/images/banners/hero_2.jpg',
            fallback: '/images/hero_2.jpg',
            alt: 'Docentes de la Institución'
        },
        {
            src: '/images/banners/plana_docente.jpg',
            fallback: '/images/plana_docente.jpg',
            alt: 'Estudiantes Ricardinos'
        }
    ];
    const [currentHero, setCurrentHero] = useState(0);

    useEffect(() => {
        const timer = setInterval(() => {
            setCurrentHero((prev) => (prev + 1) % heroSlides.length);
        }, 6000);
        return () => clearInterval(timer);
    }, [heroSlides.length]);

    // 2. Fotografías reales del Lema
    const lemaPhotos = [
        { src: '/images/institucional/alumna_destacada.png', fallback: '/images/alumna_destacada.png', alt: 'Alumna destacada' },
        { src: '/images/institucional/ricardino_campeon.jpg', fallback: '/images/ricardino_campeon.jpg', alt: 'Equipo campeón' },
        { src: '/images/institucional/ricardino_libros.jpg', fallback: '/images/ricardino_libros.jpg', alt: 'Estudiantes leyendo' }
    ];

    // 3. Fotografías reales de la Presentación Institucional (Bienvenidos)
    const welcomePhotos = [
        { src: '/images/institucional/ricardino_escolta.jpg', fallback: '/images/ricardino_escolta.jpg', alt: 'Escolta escolar ricardina' },
        { src: '/images/institucional/ricardinos_premiacion.jpg', fallback: '/images/ricardinos_premiacion.jpg', alt: 'Premiación de estudiantes' },
        { src: '/images/institucional/ricardinos_formados.jpg', fallback: '/images/ricardinos_formados.jpg', alt: 'Formación cívica escolar' }
    ];

    // 4. Fotografías dinámicas sincronizadas con la Base de Datos (tabla galerias)
    const galeriaPhotos = (galeria && galeria.length > 0)
        ? galeria.map((g) => ({
            src: g.url || (g.imagen_path?.startsWith('images/') ? `/${g.imagen_path}` : `/storage/${g.imagen_path}`),
            fallback: '/images/galeria_1.jpg',
            alt: g.titulo || 'Fotografía institucional de la galería'
        }))
        : [
            { src: '/images/galeria_1.jpg', fallback: '/images/galeria_1.jpg', alt: 'Reconocimiento escolar a estudiante' },
            { src: '/images/galeria_2.jpg', fallback: '/images/galeria_2.jpg', alt: 'Equipo femenino campeón de futsal' },
            { src: '/images/galeria_3.jpg', fallback: '/images/galeria_3.jpg', alt: 'Equipo masculino campeón de futsal' }
        ];

    // 5. Estructura Pedagógica Oficial por Niveles
    const niveles = [
        {
            nombre: 'Nivel Inicial',
            imagen: '/images/niveles/nivel_inicial.png',
            fallback: '/images/nivel_inicial.png',
            enfoque: 'Desarrollo psicomotriz, socialización temprana y estimulación cognitiva mediante el aprendizaje lúdico.',
            strokeColor: 'stroke-ricardo-teal',
            glowColor: 'group-hover:shadow-[0_16px_36px_-10px_rgba(18,149,130,0.18)]'
        },
        {
            nombre: 'Nivel Primaria',
            imagen: '/images/niveles/nivel_primaria.png',
            fallback: '/images/nivel_primaria.png',
            enfoque: 'Comprensión lectora, razonamiento lógico-matemático y formación sólida en valores cívicos y éticos.',
            strokeColor: 'stroke-amber-500',
            glowColor: 'group-hover:shadow-[0_16px_36px_-10px_rgba(245,158,11,0.18)]'
        },
        {
            nombre: 'Nivel Secundaria',
            imagen: '/images/niveles/nivel_secundaria.png',
            fallback: '/images/nivel_secundaria.png',
            enfoque: 'Innovación pedagógica, ciencia, tecnología, robótica y sólida preparación preuniversitaria.',
            strokeColor: 'stroke-ricardo-red',
            glowColor: 'group-hover:shadow-[0_16px_36px_-10px_rgba(202,23,8,0.18)]'
        }
    ];

    return (
        <AppLayout>
            <Head title="I.E.I. N° 31756 Ricardo Palma - Cerro de Pasco" />

            {/* =========================================================================
                1. HERO SECTION INMERSIVO (MINIMALISTA, FONDO VERDE INSTITUCIONAL)
               ========================================================================= */}
            <section className="relative flex min-h-[36rem] sm:min-h-[40rem] lg:min-h-[44rem] w-full items-center overflow-hidden bg-[#0C3831]">
                {/* Fotografías Reales con Transición Suave sobre Verde Ricardino */}
                {heroSlides.map((slide, index) => (
                    <img
                        key={index}
                        src={slide.src}
                        alt={slide.alt}
                        className={`absolute inset-0 h-full w-full object-cover object-[center_32%] transition-opacity duration-1000 ease-in-out ${
                            index === currentHero
                                ? 'opacity-90 z-10'
                                : 'opacity-0 z-0 pointer-events-none'
                        }`}
                        onError={(e) => { e.currentTarget.src = slide.fallback; }}
                    />
                ))}

                {/* Velo Verde Institucional (Sin Sombra Negra) */}
                <div className="pointer-events-none absolute inset-0 z-20 bg-gradient-to-r from-[#0C3831]/90 via-[#0C3831]/60 to-[#0C3831]/25"></div>

                <div className="relative z-30 mx-auto max-w-7xl px-5 sm:px-8 py-20 w-full">
                    <div className="max-w-2xl space-y-6">
                        
                        {/* Título Principal Limpio */}
                        <div className="space-y-3">
                            <h1 className="font-mate text-4xl sm:text-5xl lg:text-[54px] text-white uppercase tracking-tight leading-[1.12]">
                                Formando Ricardinos comprometidos con su comunidad
                            </h1>
                            <div className="flex h-1 w-20">
                                <span className="w-2/3 bg-ricardo-teal"></span>
                                <span className="w-1/3 bg-ricardo-red"></span>
                            </div>
                        </div>

                        {/* Bajada Institucional Sobria */}
                        <p className="font-literata text-base sm:text-lg text-neutral-100/95 leading-relaxed font-light max-w-xl">
                            Educación Inicial, Primaria y Secundaria basada en valores, innovación pedagógica y compromiso social en Cerro de Pasco.
                        </p>

                        {/* Botones de Acción Minimalistas */}
                        <div className="pt-2 flex flex-wrap items-center gap-3.5 sm:gap-4">
                            <a
                                href="#niveles"
                                className="group inline-flex items-center justify-center gap-2.5 rounded-xl bg-white text-[#0C3831] hover:bg-ricardo-yellow hover:text-neutral-950 px-7 py-3.5 font-mate text-xs uppercase tracking-wider font-bold shadow-md hover:shadow-lg transition-all duration-300"
                            >
                                <span>Conoce Nuestros Niveles</span>
                                <ArrowRight className="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" />
                            </a>

                            <Link
                                href="/nosotros"
                                className="inline-flex items-center justify-center gap-2 rounded-xl border border-white/30 bg-white/5 hover:bg-white/15 hover:border-white/50 text-white backdrop-blur-sm px-7 py-3.5 font-mate text-xs uppercase tracking-wider font-semibold transition-all duration-300"
                            >
                                <span>Nuestra Institución</span>
                            </Link>
                        </div>

                    </div>
                </div>
            </section>

            {/* =========================================================================
                2. LEMA INSTITUCIONAL & COVERFLOW PERSONALIZADO (TEXTO IZQ / CAROUSEL DER)
               ========================================================================= */}
            <section className="bg-white border-b border-neutral-200 py-16 sm:py-20 lg:py-24 overflow-hidden">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                        
                        {/* Lema a la Izquierda */}
                        <div className="lg:col-span-5 space-y-5 text-left">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                                Filosofía Institucional
                            </span>
                            <blockquote className="font-mate text-3xl sm:text-4xl lg:text-[42px] font-normal text-neutral-900 leading-[1.18] uppercase tracking-tight">
                                “Ser Ricardino, es ser cada día mejor”
                            </blockquote>
                            <div className="flex h-1 w-20">
                                <span className="w-2/3 bg-ricardo-teal"></span>
                                <span className="w-1/3 bg-ricardo-red"></span>
                            </div>
                            <p className="font-literata text-base sm:text-lg text-neutral-600 leading-relaxed pt-1">
                                Principio ético que guía el trabajo de nuestros docentes y el aprendizaje cotidiano de cada estudiante en aulas, talleres y canchas.
                            </p>
                        </div>

                        {/* Coverflow a la Derecha */}
                        <div className="lg:col-span-7 w-full overflow-hidden sm:overflow-visible">
                            <GeometricCoverflow slides={lemaPhotos} maxWidth="max-w-[680px]" />
                        </div>

                    </div>
                </div>
            </section>

            {/* =========================================================================
                3. SECCIÓN NOSOTROS (REUTILIZACIÓN COVERFLOW IZQ / TEXTO AUTÉNTICO DER)
               ========================================================================= */}
            <section id="nosotros" className="bg-[#FBFBFA] py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                        
                        {/* Coverflow con las fotos institucionales (Escolta, Premiación, Formación) */}
                        <div className="lg:col-span-7 w-full order-2 lg:order-1 overflow-hidden sm:overflow-visible">
                            <GeometricCoverflow slides={welcomePhotos} maxWidth="max-w-[680px]" />
                        </div>

                        {/* Presentación Institucional a la Derecha */}
                        <div className="lg:col-span-5 space-y-5 order-1 lg:order-2 text-left">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                                Presentación Institucional
                            </span>
                            <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight leading-snug">
                                Bienvenidos a la I.E.I N.° 31756 Ricardo Palma
                            </h2>
                            <div className="flex h-1 w-20">
                                <span className="w-2/3 bg-ricardo-teal"></span>
                                <span className="w-1/3 bg-ricardo-red"></span>
                            </div>

                            <div className="space-y-4 font-literata text-base sm:text-[16px] text-neutral-700 leading-relaxed pt-1">
                                <p>
                                    La <strong className="font-semibold text-neutral-900">Institución Educativa Integrada N.° 31756 “Ricardo Palma”</strong>, ubicada en Cerro de Pasco, se ha consolidado como una institución comprometida con la formación integral de sus estudiantes en los niveles de Inicial, Primaria y Secundaria.
                                </p>
                                <p>
                                    A lo largo de su trayectoria, ha impulsado proyectos de innovación educativa, fortaleciendo el aprendizaje integral y promoviendo una educación basada en valores, el respeto y la mejora continua.
                                </p>
                                <p>
                                    Hoy, la institución continúa formando estudiantes competentes, autónomos y comprometidos con su comunidad, integrando nuevas estrategias pedagógicas y tecnologías.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {/* =========================================================================
                4. NUESTROS NIVELES (INICIAL, PRIMARIA, SECUNDARIA CON MARCO OCTOGONAL)
               ========================================================================= */}
            <section id="niveles" className="bg-white py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    
                    {/* Encabezado */}
                    <div className="max-w-2xl space-y-4">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Estructura Pedagógica
                        </span>
                        <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight">
                            Nuestros Niveles
                        </h2>
                        <div className="flex h-1 w-20">
                            <span className="w-2/3 bg-ricardo-teal"></span>
                            <span className="w-1/3 bg-ricardo-red"></span>
                        </div>
                    </div>

                    {/* Tarjetas de Nivel con Logos PNG Transparentes y Marco Octogonal Animado */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        {niveles.map((nivel, idx) => (
                            <div
                                key={idx}
                                className={`group rounded-3xl border border-neutral-200/80 bg-[#FBFBFA] p-8 sm:p-10 flex flex-col items-center text-center space-y-6 transition-all duration-500 hover:-translate-y-1.5 hover:border-neutral-300 ${nivel.glowColor}`}
                            >
                                {/* Escenario Octogonal Animado (PNG transparente sin fondo blanco) */}
                                <div className="relative w-40 h-40 sm:w-44 sm:h-44 flex items-center justify-center">
                                    
                                    {/* Marco Octogonal SVG con borde animado que recorre sus 8 lados */}
                                    <svg 
                                        viewBox="0 0 100 100" 
                                        className="absolute inset-0 w-full h-full pointer-events-none overflow-visible"
                                    >
                                        {/* Borde base del octágono */}
                                        <polygon
                                            points="30,2 70,2 98,30 98,70 70,98 30,98 2,70 2,30"
                                            fill="none"
                                            stroke="currentColor"
                                            strokeWidth="1.5"
                                            className="text-neutral-200/90 transition-colors duration-500 group-hover:text-neutral-300"
                                        />
                                        {/* Haz de luz institucional orbitando el octágono */}
                                        <polygon
                                            points="30,2 70,2 98,30 98,70 70,98 30,98 2,70 2,30"
                                            fill="none"
                                            strokeWidth="2.5"
                                            strokeLinecap="round"
                                            className={`${nivel.strokeColor} animate-octagon-orbit transition-opacity duration-300 opacity-60 group-hover:opacity-100`}
                                        />
                                    </svg>

                                    {/* Logo PNG Transparente */}
                                    <img
                                        src={nivel.imagen}
                                        alt={nivel.nombre}
                                        className="relative z-10 w-28 h-28 sm:w-32 sm:h-32 object-contain transition-transform duration-500 ease-out group-hover:scale-110"
                                        onError={(e) => { e.currentTarget.src = nivel.fallback; }}
                                    />
                                </div>

                                {/* Título del Nivel */}
                                <h3 className="font-mate text-2xl sm:text-[26px] font-bold uppercase text-neutral-900 group-hover:text-ricardo-teal transition-colors tracking-tight">
                                    {nivel.nombre}
                                </h3>

                                {/* Enfoque Pedagógico Real */}
                                <p className="font-literata text-sm sm:text-[15px] text-neutral-600 leading-relaxed max-w-sm">
                                    {nivel.enfoque}
                                </p>
                            </div>
                        ))}
                    </div>

                </div>
            </section>

            {/* =========================================================================
                5. GALERÍA FOTOGRÁFICA (PROTAGONISMO CON COVERFLOW REUTILIZABLE)
               ========================================================================= */}
            <section id="galeria" className="bg-[#FBFBFA] py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    
                    <div className="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                        <div className="space-y-4">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                                Registro Visual
                            </span>
                            <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight">
                                Galería Institucional
                            </h2>
                            <div className="flex h-1 w-20">
                                <span className="w-2/3 bg-ricardo-teal"></span>
                                <span className="w-1/3 bg-ricardo-red"></span>
                            </div>
                        </div>

                        <Link
                            href="/galeria"
                            className="font-mate text-xs uppercase tracking-wider text-ricardo-teal font-bold hover:text-neutral-900 transition-colors inline-flex items-center gap-1.5"
                        >
                            <span>Ver más</span>
                            <ArrowRight className="w-3.5 h-3.5" />
                        </Link>
                    </div>

                    {/* El Coverflow Geométrico ocupando el ancho completo establecido de la fila */}
                    <div className="w-full flex justify-center py-2">
                        <GeometricCoverflow 
                            slides={galeriaPhotos} 
                            maxWidth="max-w-7xl" 
                            height="h-[340px] sm:h-[390px] lg:h-[420px]" 
                        />
                    </div>

                </div>
            </section>

            {/* =========================================================================
                6. NUESTRO OBJETIVO & CONTADORES REALES (ESCULTURAS ESTADÍSTICAS)
               ========================================================================= */}
            <section id="objetivo" className="bg-white py-16 sm:py-24">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-16">
                    
                    {/* Manifiesto Institucional */}
                    <div className="max-w-3xl mx-auto text-center space-y-5">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Misión y Compromiso
                        </span>
                        <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight">
                            Nuestro Objetivo
                        </h2>
                        <div className="flex h-1 w-20 mx-auto">
                            <span className="w-2/3 bg-ricardo-teal"></span>
                            <span className="w-1/3 bg-ricardo-red"></span>
                        </div>
                        <p className="font-literata text-base sm:text-lg text-neutral-700 leading-relaxed pt-2">
                            Formar estudiantes íntegros, críticos, creativos e innovadores mediante una educación de calidad, inclusiva y basada en valores; consolidando una institución líder con gestión participativa, docentes actualizados, familias comprometidas e infraestructura moderna y sostenible.
                        </p>
                    </div>

                    {/* Esculturas de Estadísticas Auténticas (Diseño Refinado y Minimalista) */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                        
                        {/* 10 Docentes Titulares */}
                        <div className="group relative rounded-2xl border border-neutral-200/90 bg-[#FBFBFA] hover:bg-white py-9 px-6 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-ricardo-teal/40">
                            <div className="w-14 h-14 mx-auto rounded-2xl bg-teal-50 text-ricardo-teal flex items-center justify-center border border-teal-100/60 mb-4 transition-transform duration-300 group-hover:scale-110">
                                <Users className="w-7 h-7" />
                            </div>
                            <span className="font-mate text-5xl sm:text-6xl font-bold text-neutral-900 block leading-none tracking-tight">
                                {docentesCount}
                            </span>
                            <span className="font-mate text-xs uppercase tracking-widest text-neutral-600 font-semibold block mt-3">
                                Docentes Titulares
                            </span>
                            <span className="mx-auto mt-4 block h-0.5 w-8 rounded-full bg-ricardo-teal/40 group-hover:w-16 group-hover:bg-ricardo-teal transition-all duration-500"></span>
                        </div>

                        {/* 200 Padres Comprometidos */}
                        <div className="group relative rounded-2xl border border-neutral-200/90 bg-[#FBFBFA] hover:bg-white py-9 px-6 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-amber-500/40">
                            <div className="w-14 h-14 mx-auto rounded-2xl bg-amber-50 flex items-center justify-center border border-amber-100/60 p-2.5 mb-4 transition-transform duration-300 group-hover:scale-110">
                                <img
                                    src="/images/padre.png"
                                    alt="Padres Comprometidos"
                                    className="w-7 h-7 object-contain"
                                    onError={(e) => { e.currentTarget.style.display = 'none'; }}
                                />
                            </div>
                            <span className="font-mate text-5xl sm:text-6xl font-bold text-neutral-900 block leading-none tracking-tight">
                                200
                            </span>
                            <span className="font-mate text-xs uppercase tracking-widest text-neutral-600 font-semibold block mt-3">
                                Padres Comprometidos
                            </span>
                            <span className="mx-auto mt-4 block h-0.5 w-8 rounded-full bg-amber-500/40 group-hover:w-16 group-hover:bg-amber-500 transition-all duration-500"></span>
                        </div>

                        {/* 150 Estudiantes Totales */}
                        <div className="group relative rounded-2xl border border-neutral-200/90 bg-[#FBFBFA] hover:bg-white py-9 px-6 text-center transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-ricardo-red/40">
                            <div className="w-14 h-14 mx-auto rounded-2xl bg-red-50 text-ricardo-red flex items-center justify-center border border-red-100/60 mb-4 transition-transform duration-300 group-hover:scale-110">
                                <GraduationCap className="w-7 h-7" />
                            </div>
                            <span className="font-mate text-5xl sm:text-6xl font-bold text-neutral-900 block leading-none tracking-tight">
                                150
                            </span>
                            <span className="font-mate text-xs uppercase tracking-widest text-neutral-600 font-semibold block mt-3">
                                Estudiantes Totales
                            </span>
                            <span className="mx-auto mt-4 block h-0.5 w-8 rounded-full bg-ricardo-red/40 group-hover:w-16 group-hover:bg-ricardo-red transition-all duration-500"></span>
                        </div>

                    </div>

                    {/* Cierre Institucional: Educación con Futuro (Limpio, Luminoso y Minimalista) */}
                    <div className="rounded-2xl border border-neutral-200/90 bg-[#FBFBFA] p-8 sm:p-12 max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm">
                        <div className="space-y-2 text-center sm:text-left">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold block">
                                Educación con Futuro
                            </span>
                            <h3 className="font-mate text-2xl sm:text-3xl text-neutral-900 font-bold uppercase tracking-tight">
                                ¿Deseas formar parte de la familia Ricardina?
                            </h3>
                            <p className="font-literata text-sm sm:text-base text-neutral-600 max-w-lg leading-relaxed">
                                Conoce nuestras instalaciones, propuesta pedagógica y el compromiso de nuestros docentes en Cerro de Pasco.
                            </p>
                        </div>
                        <Link
                            href="/contacto"
                            className="bg-ricardo-teal hover:bg-ricardo-teal-dark text-white px-7 py-3.5 font-mate text-xs uppercase tracking-wider font-semibold whitespace-nowrap transition-colors rounded-xl shrink-0 shadow-sm"
                        >
                            Contáctanos
                        </Link>
                    </div>

                </div>
            </section>
        </AppLayout>
    );
}
