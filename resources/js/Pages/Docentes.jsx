import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';

export default function Docentes({ porNivel = {} }) {
    const nivelesInfo = {
        Inicial: {
            color: 'bg-emerald-50 text-emerald-800 border-emerald-200',
            accent: 'text-ricardo-teal',
            desc: 'Primeros pasos en el desarrollo integral, psicomotriz y socioemocional.'
        },
        Primaria: {
            color: 'bg-amber-50 text-amber-800 border-amber-200',
            accent: 'text-amber-600',
            desc: 'Consolidación de competencias fundamentales, lectura y pensamiento matemático.'
        },
        Secundaria: {
            color: 'bg-sky-50 text-sky-800 border-sky-200',
            accent: 'text-ricardo-red',
            desc: 'Pensamiento crítico, formación científica, tecnológica y preparación preuniversitaria.'
        }
    };

    return (
        <AppLayout>
            <Head title="Docentes | I.E.I. N° 31756 Ricardo Palma" />

            {/* Banner Institucional */}
            <section className="bg-[#0C3831] text-white py-16 sm:py-20 border-b border-white/10">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-4">
                    <span className="font-mate text-xs uppercase tracking-widest text-ricardo-yellow font-semibold">
                        Comunidad Educativa
                    </span>
                    <h1 className="font-mate text-3xl sm:text-5xl uppercase font-bold tracking-tight">
                        Nuestra Plana Docente
                    </h1>
                    <div className="flex h-1 w-20">
                        <span className="w-2/3 bg-ricardo-teal"></span>
                        <span className="w-1/3 bg-ricardo-red"></span>
                    </div>
                    <p className="font-literata text-base sm:text-lg text-neutral-200 max-w-2xl leading-relaxed pt-1 font-light">
                        Profesionales comprometidos con la formación integral, el aprendizaje de calidad y los valores de nuestros estudiantes en Cerro de Pasco.
                    </p>
                </div>
            </section>

            {/* Listado de Docentes por Nivel */}
            <section className="bg-white py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-16">
                    {Object.entries(porNivel).map(([nivel, lista]) => {
                        if (!lista || lista.length === 0) return null;
                        const info = nivelesInfo[nivel] || {
                            color: 'bg-neutral-100 text-neutral-800 border-neutral-300',
                            accent: 'text-neutral-700',
                            desc: ''
                        };

                        return (
                            <div key={nivel} className="space-y-8">
                                <div className="border-b border-neutral-200 pb-5 space-y-2">
                                    <div className="flex items-center gap-3">
                                        <h2 className="font-mate text-2xl sm:text-3xl font-bold uppercase text-neutral-900 tracking-tight">
                                            Nivel {nivel}
                                        </h2>
                                        <span className={`px-3 py-1 text-xs font-mate uppercase tracking-wider font-semibold border rounded-full ${info.color}`}>
                                            {lista.length} {lista.length === 1 ? 'docente' : 'docentes'}
                                        </span>
                                    </div>
                                    <p className="font-literata text-sm text-neutral-500 max-w-xl">
                                        {info.desc}
                                    </p>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                                    {lista.map((docente) => (
                                        <div
                                            key={docente.id}
                                            className="group rounded-2xl border border-neutral-200/90 bg-[#FBFBFA] p-5 flex items-start gap-4 transition-all duration-300 hover:border-ricardo-teal/40 hover:-translate-y-1 hover:shadow-xs"
                                        >
                                            <div className="w-12 h-12 rounded-xl bg-white border border-neutral-200 flex items-center justify-center font-mate font-bold text-neutral-800 text-lg shrink-0 shadow-2xs group-hover:bg-ricardo-teal group-hover:text-white group-hover:border-ricardo-teal transition-colors">
                                                {docente.nombres_apellidos?.charAt(0) || 'D'}
                                            </div>
                                            <div className="min-w-0 flex-grow space-y-1">
                                                <h3 className="font-mate text-base font-bold text-neutral-900 leading-snug line-clamp-2">
                                                    {docente.nombres_apellidos}
                                                </h3>
                                                <p className={`font-mate text-xs uppercase tracking-wider font-semibold ${info.accent}`}>
                                                    {docente.cargo}
                                                </p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        );
                    })}
                </div>
            </section>
        </AppLayout>
    );
}
