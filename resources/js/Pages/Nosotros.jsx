import React from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { 
    Compass, 
    Target, 
    Eye, 
    Award, 
    BookOpen, 
    HeartHandshake, 
    Sparkles, 
    ShieldCheck, 
    Users, 
    ArrowRight
} from 'lucide-react';

export default function Nosotros() {
    const directivos = [
        {
            nombre: 'Walter Porras Ramirez',
            cargo: 'Director',
            badge: 'Dirección General',
            color: 'text-ricardo-red',
            foto: '/images/equipo/walter_porras.png'
        },
        {
            nombre: 'Nicolas Espinoza Suarez',
            cargo: 'Sub Director',
            badge: 'Subdirección',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/nicolas_espinoza.png'
        },
        {
            nombre: 'Adrián Támara Trinidad',
            cargo: 'Coordinador Pedagógico',
            badge: 'Pedagogía',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/adrian_tamara.png'
        },
        {
            nombre: 'Rayda Rivas Solorzano',
            cargo: 'Coordinadora de Ciencias',
            badge: 'Ciencias y Tecnología',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/rayda_rivas.png'
        },
        {
            nombre: 'Carmen Romero Garcia',
            cargo: 'Coordinadora de TOE',
            badge: 'Tutoría Escolar',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/carmen_romero.png'
        },
        {
            nombre: 'Luz Pardave Yachas',
            cargo: 'Coordinadora Nivel Inicial',
            badge: 'Nivel Inicial',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/luz_pardave.png'
        },
        {
            nombre: 'Catering Campos Fernandez',
            cargo: 'Psicóloga Institucional',
            badge: 'Bienestar Psicológico',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/catering_campos.png'
        },
        {
            nombre: 'Jean Rajo Guzman',
            cargo: 'Responsable CIST',
            badge: 'Innovación Tecnológica',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/jean_rajo.png'
        }
    ];

    const valores = [
        {
            numero: '01',
            titulo: 'Respeto',
            desc: 'Valoramos la dignidad de cada persona, promoviendo una convivencia escolar armónica basada en la empatía y la escucha mutua.',
            icon: ShieldCheck
        },
        {
            numero: '02',
            titulo: 'Responsabilidad',
            desc: 'Asumimos con seriedad el deber escolar y ciudadano, cumpliendo metas con disciplina, puntualidad y perseverancia.',
            icon: Target
        },
        {
            numero: '03',
            titulo: 'Honestidad',
            desc: 'Actuamos con rectitud, transparencia y coherencia entre lo que decimos y hacemos dentro y fuera de la institución.',
            icon: Award
        },
        {
            numero: '04',
            titulo: 'Solidaridad',
            desc: 'Fomentamos el compañerismo sincero y la ayuda recíproca ante las necesidades de nuestros pares y la comunidad cerreña.',
            icon: HeartHandshake
        },
        {
            numero: '05',
            titulo: 'Compromiso',
            desc: 'Consagramos el esfuerzo cotidiano de docentes y estudiantes a la mejora continua y a la excelencia humana.',
            icon: Compass
        },
        {
            numero: '06',
            titulo: 'Innovación',
            desc: 'Integramos tecnologías educativas y estrategias pedagógicas modernas que potencian las competencias del siglo XXI.',
            icon: Sparkles
        }
    ];

    const pilares = [
        {
            titulo: 'Educación Integrada',
            desc: 'Acompañamiento continuo desde los primeros pasos en Inicial hasta la culminación de la Secundaria.',
        },
        {
            titulo: 'Innovación Pedagógica',
            desc: 'Aulas equipadas con soporte tecnológico CIST para el aprendizaje interactivo y crítico.',
        },
        {
            titulo: 'Formación en Valores',
            desc: 'Acompañamiento tutorial continuo (TOE) y orientación psicológica para el bienestar escolar.',
        }
    ];

    return (
        <AppLayout>
            <Head title="Nosotros | I.E.I. N° 31756 Ricardo Palma" />

            {/* =========================================================================
                1. HERO EDITORIAL MODERNO Y MINIMALISTA (SIN BLOQUES GENÉRICOS)
               ========================================================================= */}
            <section className="relative bg-[#FBFBFA] border-b border-neutral-200/80 pt-10 sm:pt-14 pb-16 sm:pb-20">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-10">
                    
                    {/* Migas de pan institucionales limpias */}
                    <div className="flex items-center gap-2 font-mate text-xs text-neutral-400 uppercase tracking-wider font-semibold">
                        <Link href="/" className="hover:text-ricardo-teal transition-colors">Inicio</Link>
                        <span>/</span>
                        <span className="text-neutral-700">Nuestra Institución</span>
                    </div>

                    {/* Cabecera Asimétrica */}
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                        
                        {/* Columna Izquierda: Manifiesto Principal */}
                        <div className="lg:col-span-7 space-y-6">
                            <div className="space-y-3">
                                <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-bold block">
                                    Identidad & Trayectoria Educativa
                                </span>
                                <h1 className="font-mate text-3xl sm:text-5xl lg:text-[48px] text-neutral-900 uppercase font-bold tracking-tight leading-[1.14]">
                                    Educación con propósito, carácter y valores en las alturas de Pasco
                                </h1>
                                <div className="flex h-1 w-24">
                                    <span className="w-2/3 bg-ricardo-teal"></span>
                                    <span className="w-1/3 bg-ricardo-red"></span>
                                </div>
                            </div>

                            <p className="font-literata text-base sm:text-lg text-neutral-700 leading-relaxed font-light max-w-2xl">
                                La <strong className="font-semibold text-neutral-900">Institución Educativa Integrada N.° 31756 “Ricardo Palma”</strong> lidera la formación pedagógica y humana en los niveles Inicial, Primaria y Secundaria, forjando estudiantes reflexivos, éticos y comprometidos con el desarrollo integral de Cerro de Pasco.
                            </p>

                            <div className="pt-2 flex flex-wrap items-center gap-3">
                                <a
                                    href="#quienes-somos"
                                    className="bg-ricardo-teal hover:bg-ricardo-teal-dark text-white px-6 py-3 rounded-xl font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-xs inline-flex items-center gap-2"
                                >
                                    <span>Conocer Más</span>
                                    <ArrowRight className="w-4 h-4" />
                                </a>

                                <a
                                    href="#equipo"
                                    className="bg-white hover:bg-neutral-50 text-neutral-800 border border-neutral-200/90 px-6 py-3 rounded-xl font-mate text-xs uppercase tracking-wider font-semibold transition-all shadow-2xs"
                                >
                                    <span>Plana Directiva</span>
                                </a>
                            </div>
                        </div>

                        {/* Columna Derecha: Tarjetas Esculpidas de Pilares */}
                        <div className="lg:col-span-5 space-y-3">
                            {pilares.map((p, idx) => (
                                <div 
                                    key={idx}
                                    className="group rounded-2xl border border-neutral-200/80 bg-white p-5 transition-all duration-300 hover:border-ricardo-teal/40 hover:shadow-xs hover:-translate-y-0.5"
                                >
                                    <div className="flex items-start gap-4">
                                        <div className="w-8 h-8 rounded-xl bg-teal-50 border border-teal-100 text-ricardo-teal flex items-center justify-center font-mate font-bold text-xs shrink-0 group-hover:bg-ricardo-teal group-hover:text-white transition-colors">
                                            0{idx + 1}
                                        </div>
                                        <div className="space-y-1">
                                            <h3 className="font-mate text-sm font-bold uppercase tracking-wide text-neutral-900">
                                                {p.titulo}
                                            </h3>
                                            <p className="font-literata text-xs sm:text-[13px] text-neutral-600 leading-relaxed font-light">
                                                {p.desc}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                    </div>
                </div>
            </section>

            {/* =========================================================================
                2. SECCIÓN ¿QUIÉNES SOMOS? (EDITORIAL CON FOTOGRAFÍA INSTITUCIONAL)
               ========================================================================= */}
            <section id="quienes-somos" className="bg-white py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                        
                        {/* Texto Descriptivo */}
                        <div className="lg:col-span-6 space-y-6 order-2 lg:order-1">
                            <div className="space-y-3">
                                <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                                    Nuestra Esencia
                                </span>
                                <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight">
                                    ¿Quiénes Somos?
                                </h2>
                                <div className="flex h-1 w-20">
                                    <span className="w-2/3 bg-ricardo-teal"></span>
                                    <span className="w-1/3 bg-ricardo-red"></span>
                                </div>
                            </div>

                            <div className="space-y-4 font-literata text-base text-neutral-700 leading-relaxed font-light">
                                <p>
                                    Somos una comunidad educativa con profunda vocación de servicio, orientada a brindar una formación rigurosa y a la vez afectiva, que atiende las particularidades cognitivas y emocionales de cada etapa del estudiante.
                                </p>
                                <p>
                                    Ubicados en el histórico distrito de Chaupimarca, nuestro colegio conjuga la tradición y disciplina de sus fundadores con herramientas pedagógicas de vanguardia, promoviendo el pensamiento crítico, la indagación científica y el arte.
                                </p>
                                <p>
                                    La estrecha alianza entre directivos, docentes y padres de familia garantiza un clima de convivencia democrática, donde el respeto y la superación personal son el sello distintivo de cada Ricardino.
                                </p>
                            </div>

                            <div className="pt-2 border-l-2 border-ricardo-teal pl-4 italic font-literata text-sm text-neutral-600 leading-relaxed">
                                “Educar en el Ricardo Palma es cultivar mentes críticas con corazones generosos, capaces de forjar su propio destino en cualquier rincón del país.”
                            </div>
                        </div>

                        {/* Fotografía Institucional con Marco Sofisticado */}
                        <div className="lg:col-span-6 order-1 lg:order-2">
                            <div className="rounded-3xl overflow-hidden border border-neutral-200/90 shadow-md bg-neutral-100">
                                <img
                                    src="/images/institucional/quienes_somos.jpg"
                                    alt="Comunidad Educativa Ricardo Palma"
                                    className="w-full aspect-[4/3] object-cover transition-transform duration-700 hover:scale-105"
                                    onError={(e) => { e.currentTarget.src = '/images/quienes_somos.jpg'; }}
                                />
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {/* =========================================================================
                3. MISIÓN Y VISIÓN (TARJETAS ARQUITECTÓNICAS ARTICULADAS)
               ========================================================================= */}
            <section className="bg-[#FBFBFA] py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    
                    <div className="text-center max-w-2xl mx-auto space-y-3">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Direccionamiento Estratégico
                        </span>
                        <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight">
                            Misión y Visión
                        </h2>
                        <div className="flex h-1 w-20 mx-auto">
                            <span className="w-2/3 bg-ricardo-teal"></span>
                            <span className="w-1/3 bg-ricardo-red"></span>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {/* Misión */}
                        <div className="rounded-3xl border border-neutral-200/90 bg-white p-8 sm:p-10 space-y-6 shadow-xs relative overflow-hidden group hover:border-ricardo-teal/40 transition-all duration-300">
                            <div className="w-12 h-12 rounded-2xl bg-teal-50 text-ricardo-teal border border-teal-100 flex items-center justify-center">
                                <Compass className="w-6 h-6" />
                            </div>

                            <div className="space-y-3">
                                <div className="flex items-center justify-between">
                                    <h3 className="font-mate text-2xl sm:text-3xl font-bold uppercase text-neutral-900 tracking-tight">
                                        Nuestra Misión
                                    </h3>
                                    <span className="h-1.5 w-12 rounded-full bg-ricardo-teal"></span>
                                </div>
                                <p className="font-literata text-base text-neutral-700 leading-relaxed font-light">
                                    Brindar una educación integral, inclusiva y de calidad a los estudiantes de la Institución Educativa Integrada N.° 31756 “Ricardo Palma”, promoviendo el desarrollo de competencias, valores, pensamiento crítico, creatividad e innovación en un ambiente de respeto, responsabilidad y convivencia democrática.
                                </p>
                            </div>

                            <div className="pt-3 border-t border-neutral-100">
                                <span className="font-mate text-xs uppercase tracking-wider text-ricardo-teal font-semibold">
                                    Compromiso · Formación integral y en valores
                                </span>
                            </div>
                        </div>

                        {/* Visión */}
                        <div className="rounded-3xl border border-neutral-200/90 bg-white p-8 sm:p-10 space-y-6 shadow-xs relative overflow-hidden group hover:border-ricardo-red/40 transition-all duration-300">
                            <div className="w-12 h-12 rounded-2xl bg-red-50 text-ricardo-red border border-red-100 flex items-center justify-center">
                                <Eye className="w-6 h-6" />
                            </div>

                            <div className="space-y-3">
                                <div className="flex items-center justify-between">
                                    <h3 className="font-mate text-2xl sm:text-3xl font-bold uppercase text-neutral-900 tracking-tight">
                                        Nuestra Visión
                                    </h3>
                                    <span className="h-1.5 w-12 rounded-full bg-ricardo-red"></span>
                                </div>
                                <p className="font-literata text-base text-neutral-700 leading-relaxed font-light">
                                    Ser la primera elección de las familias de la región Pasco, garantizando una sólida formación académica, madurez socioemocional y educación en valores éticos que preparen a los egresados para destacar en estudios superiores y liderar positivamente en su entorno.
                                </p>
                            </div>

                            <div className="pt-3 border-t border-neutral-100">
                                <span className="font-mate text-xs uppercase tracking-wider text-ricardo-red font-semibold">
                                    Horizonte · Liderazgo y desarrollo humano
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {/* =========================================================================
                4. VALORES INSTITUCIONALES (NUMERACIÓN Y MICRO-ICONOGRAFÍA)
               ========================================================================= */}
            <section className="bg-white py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    
                    <div className="max-w-2xl space-y-4">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Pilares Éticos
                        </span>
                        <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight">
                            Valores Institucionales
                        </h2>
                        <div className="flex h-1 w-20">
                            <span className="w-2/3 bg-ricardo-teal"></span>
                            <span className="w-1/3 bg-ricardo-red"></span>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        {valores.map((item, idx) => {
                            const IconComponent = item.icon;
                            return (
                                <div
                                    key={idx}
                                    className="group rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] p-7 space-y-4 transition-all duration-300 hover:border-ricardo-teal/40 hover:-translate-y-1 hover:shadow-sm hover:bg-white"
                                >
                                    <div className="flex items-center justify-between">
                                        <div className="w-10 h-10 rounded-xl bg-teal-50 text-ricardo-teal border border-teal-100 flex items-center justify-center transition-colors group-hover:bg-ricardo-teal group-hover:text-white">
                                            <IconComponent className="w-5 h-5" />
                                        </div>
                                        <span className="font-mate text-xs font-bold text-neutral-300 group-hover:text-ricardo-teal transition-colors">
                                            {item.numero}
                                        </span>
                                    </div>

                                    <div className="space-y-1.5">
                                        <h3 className="font-mate text-lg uppercase font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors">
                                            {item.titulo}
                                        </h3>
                                        <p className="font-literata text-xs sm:text-[13.5px] text-neutral-600 leading-relaxed font-light">
                                            {item.desc}
                                        </p>
                                    </div>
                                </div>
                            );
                        })}
                    </div>

                </div>
            </section>

            {/* =========================================================================
                5. EQUIPO DIRECTIVO Y JERÁRQUICO
               ========================================================================= */}
            <section id="equipo" className="bg-[#FBFBFA] py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    
                    <div className="max-w-2xl space-y-4">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                            Liderazgo y Gestión
                        </span>
                        <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight">
                            Equipo Directivo
                        </h2>
                        <div className="flex h-1 w-20">
                            <span className="w-2/3 bg-ricardo-teal"></span>
                            <span className="w-1/3 bg-ricardo-red"></span>
                        </div>
                    </div>

                    <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8">
                        {directivos.map((p, idx) => (
                            <div key={idx} className="group text-center space-y-3">
                                <div className="aspect-[3/4] w-full overflow-hidden rounded-2xl bg-neutral-100 border border-neutral-200/90 shadow-xs relative">
                                    <img
                                        src={p.foto}
                                        alt={p.nombre}
                                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy"
                                        onError={(e) => { e.currentTarget.style.display = 'none'; }}
                                    />
                                    {p.badge && (
                                        <span className="absolute bottom-2 inset-x-2 bg-black/60 backdrop-blur-xs text-white text-[10px] font-mate uppercase tracking-wider py-1 rounded-lg">
                                            {p.badge}
                                        </span>
                                    )}
                                </div>
                                <div className="space-y-1">
                                    <h3 className="font-mate text-base font-bold text-neutral-900 uppercase leading-snug">
                                        {p.nombre}
                                    </h3>
                                    <p className={`font-mate text-xs uppercase tracking-wider font-semibold ${p.color}`}>
                                        {p.cargo}
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>

                </div>
            </section>

            {/* =========================================================================
                6. CIERRE INSPIRADOR: LEMA INSTITUCIONAL
               ========================================================================= */}
            <section className="bg-white py-16 sm:py-20 text-center">
                <div className="mx-auto max-w-4xl px-5 sm:px-8 space-y-6">
                    <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold block">
                        Tradición & Identidad
                    </span>
                    <blockquote className="font-mate text-3xl sm:text-4xl lg:text-5xl font-bold uppercase tracking-tight text-neutral-900">
                        “Ser Ricardino, es ser cada día mejor”
                    </blockquote>
                    <div className="flex h-1 w-20 mx-auto">
                        <span className="w-2/3 bg-ricardo-teal"></span>
                        <span className="w-1/3 bg-ricardo-red"></span>
                    </div>
                    <p className="font-literata text-sm sm:text-base text-neutral-600 max-w-lg mx-auto leading-relaxed font-light">
                        El principio formativo que orienta la labor docente, el esfuerzo de los alumnos y la confianza de las familias en Pasco.
                    </p>
                </div>
            </section>

        </AppLayout>
    );
}
