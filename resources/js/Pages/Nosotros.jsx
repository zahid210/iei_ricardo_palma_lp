import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';

export default function Nosotros() {
    const directivos = [
        {
            nombre: 'Walter Porras Ramirez',
            cargo: 'Director',
            color: 'text-ricardo-red',
            foto: '/images/equipo/walter_porras.png'
        },
        {
            nombre: 'Nicolas Espinoza Suarez',
            cargo: 'Sub Director',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/nicolas_espinoza.png'
        },
        {
            nombre: 'Adrián Támara Trinidad',
            cargo: 'Coordinador Pedagógico',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/adrian_tamara.png'
        },
        {
            nombre: 'Rayda Rivas Solorzano',
            cargo: 'Coordinadora de Ciencias',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/rayda_rivas.png'
        },
        {
            nombre: 'Carmen Romero Garcia',
            cargo: 'Coordinadora de TOE',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/carmen_romero.png'
        },
        {
            nombre: 'Luz Pardave Yachas',
            cargo: 'Coordinadora Nivel Inicial',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/luz_pardave.png'
        },
        {
            nombre: 'Catering Campos Fernandez',
            cargo: 'Psicóloga',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/catering_campos.png'
        },
        {
            nombre: 'Jean Rajo Guzman',
            cargo: 'CIST',
            color: 'text-ricardo-teal',
            foto: '/images/equipo/jean_rajo.png'
        }
    ];

    const valores = [
        {
            titulo: 'Respeto',
            desc: 'Valoramos a cada persona y fomentamos una convivencia armoniosa basada en el buen trato y la tolerancia mutua.'
        },
        {
            titulo: 'Responsabilidad',
            desc: 'Cumplimos nuestros deberes con compromiso, puntualidad y dedicación en cada una de nuestras acciones formativas.'
        },
        {
            titulo: 'Honestidad',
            desc: 'Actuamos con verdad, transparencia y coherencia en nuestra vida personal, comunitaria y escolar.'
        },
        {
            titulo: 'Solidaridad',
            desc: 'Promovemos la ayuda mutua, el compañerismo y el trabajo colaborativo dentro de la comunidad ricardina.'
        },
        {
            titulo: 'Compromiso',
            desc: 'Asumimos con seriedad nuestra labor educativa y el esfuerzo constante por mejorar cada día.'
        },
        {
            titulo: 'Innovación',
            desc: 'Impulsamos nuevas formas de enseñar y aprender, integrando estrategias pedagógicas que fortalecen competencias.'
        }
    ];

    return (
        <AppLayout>
            <Head title="Nosotros | I.E.I. N° 31756 Ricardo Palma" />

            {/* Banner Institucional Minimalista */}
            <section className="bg-[#0C3831] text-white py-16 sm:py-20 border-b border-white/10">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-4">
                    <span className="font-mate text-xs uppercase tracking-widest text-ricardo-yellow font-semibold">
                        Conoce Nuestra Institución
                    </span>
                    <h1 className="font-mate text-3xl sm:text-5xl uppercase font-bold tracking-tight">
                        Innovación y Excelencia Educativa
                    </h1>
                    <div className="flex h-1 w-20">
                        <span className="w-2/3 bg-ricardo-teal"></span>
                        <span className="w-1/3 bg-ricardo-red"></span>
                    </div>
                    <p className="font-literata text-base sm:text-lg text-neutral-200 max-w-2xl leading-relaxed pt-1 font-light">
                        Preparamos a los estudiantes para ser líderes éticos y ciudadanos responsables en un mundo en constante evolución.
                    </p>
                </div>
            </section>

            {/* ¿Quiénes Somos? */}
            <section className="bg-white py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                        <div className="lg:col-span-6 space-y-5">
                            <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold">
                                Identidad Ricardina
                            </span>
                            <h2 className="font-mate text-3xl sm:text-4xl text-neutral-900 uppercase font-bold tracking-tight">
                                ¿Quiénes Somos?
                            </h2>
                            <div className="flex h-1 w-20">
                                <span className="w-2/3 bg-ricardo-teal"></span>
                                <span className="w-1/3 bg-ricardo-red"></span>
                            </div>
                            <div className="space-y-4 font-literata text-base text-neutral-700 leading-relaxed pt-2">
                                <p>
                                    Somos una institución comprometida en proporcionar una educación de calidad que se alinea con las demandas del mundo actual. Nuestro enfoque se centra en el desarrollo integral de los alumnos, fortaleciendo tanto sus habilidades académicas como sus capacidades sociales y emocionales.
                                </p>
                                <p>
                                    A lo largo del tiempo, nuestra labor pedagógica se ha consolidado mediante la participación activa de docentes, directivos, estudiantes y familias, reafirmando una formación basada en valores, inclusión y mejora continua en Cerro de Pasco.
                                </p>
                            </div>
                        </div>

                        <div className="lg:col-span-6">
                            <div className="rounded-3xl overflow-hidden border border-neutral-200/90 shadow-md">
                                <img
                                    src="/images/institucional/quienes_somos.jpg"
                                    alt="Comunidad Educativa Ricardo Palma"
                                    className="w-full aspect-[4/3] object-cover"
                                    onError={(e) => { e.currentTarget.src = '/images/quienes_somos.jpg'; }}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* Misión y Visión */}
            <section className="bg-[#FBFBFA] py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        {/* Misión */}
                        <div className="rounded-3xl border border-neutral-200/90 bg-white p-8 sm:p-10 space-y-5 shadow-xs">
                            <div className="flex items-center justify-between">
                                <h3 className="font-mate text-2xl sm:text-3xl font-bold uppercase text-neutral-900 tracking-tight">
                                    Misión
                                </h3>
                                <span className="h-1.5 w-12 rounded-full bg-ricardo-teal"></span>
                            </div>
                            <p className="font-literata text-base text-neutral-700 leading-relaxed font-light">
                                Brindar una educación integral, inclusiva y de calidad a los estudiantes de la Institución Educativa Integrada N.° 31756 “Ricardo Palma”, promoviendo el desarrollo de competencias, valores, pensamiento crítico, creatividad e innovación en un ambiente de respeto, responsabilidad y convivencia democrática.
                            </p>
                            <div className="pt-2">
                                <span className="font-mate text-xs uppercase tracking-wider text-ricardo-teal font-semibold">
                                    Enfoque · Formación integral y en valores
                                </span>
                            </div>
                        </div>

                        {/* Visión */}
                        <div className="rounded-3xl border border-neutral-200/90 bg-white p-8 sm:p-10 space-y-5 shadow-xs">
                            <div className="flex items-center justify-between">
                                <h3 className="font-mate text-2xl sm:text-3xl font-bold uppercase text-neutral-900 tracking-tight">
                                    Visión
                                </h3>
                                <span className="h-1.5 w-12 rounded-full bg-ricardo-red"></span>
                            </div>
                            <p className="font-literata text-base text-neutral-700 leading-relaxed font-light">
                                Ser la primera elección de las familias que garantice la formación académica sólida, la madurez emocional y la educación en valores necesarias para el futuro de sus hijos en un entorno tecnológico y global.
                            </p>
                            <div className="pt-2">
                                <span className="font-mate text-xs uppercase tracking-wider text-ricardo-red font-semibold">
                                    Horizonte · Liderazgo y desarrollo humano
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {/* Valores Institucionales */}
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
                        {valores.map((item, idx) => (
                            <div
                                key={idx}
                                className="group rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] p-7 space-y-3 transition-all duration-300 hover:border-ricardo-teal/40 hover:-translate-y-1 hover:shadow-sm"
                            >
                                <h3 className="font-mate text-xl uppercase font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors">
                                    {item.titulo}
                                </h3>
                                <p className="font-literata text-sm text-neutral-600 leading-relaxed">
                                    {item.desc}
                                </p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Equipo Directivo */}
            <section className="bg-[#FBFBFA] py-16 sm:py-24">
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
                                <div className="aspect-[3/4] w-full overflow-hidden rounded-2xl bg-neutral-200 border border-neutral-200/90 shadow-xs">
                                    <img
                                        src={p.foto}
                                        alt={p.nombre}
                                        className="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy"
                                        onError={(e) => { e.currentTarget.style.display = 'none'; }}
                                    />
                                </div>
                                <div className="space-y-1">
                                    <h3 className="font-mate text-base sm:text-[17px] font-bold text-neutral-900 uppercase leading-snug">
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

        </AppLayout>
    );
}
