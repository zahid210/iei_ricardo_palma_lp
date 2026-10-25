import React, { useState, useMemo } from 'react';
import { Head, Link } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { 
    Search, 
    X, 
    Users, 
    GraduationCap, 
    Sparkles 
} from 'lucide-react';

// Formateo tipográfico de nombres para eliminar mayúsculas agresivas
function formatDocenteName(name) {
    if (!name) return '';
    return name
        .toLowerCase()
        .replace(/(^|[\s,.\-\/])([a-záéíóúñ])/gi, (match, sep, char) => sep + char.toUpperCase());
}

// Formateo institucional de cargos
function formatCargo(cargo) {
    if (!cargo) return 'Docente de Aula';
    const clean = cargo.trim().toUpperCase();
    const map = {
        'DOCENTE DE AULA': 'Docente de Aula',
        'SUB DIRECTOR': 'Subdirección Académica',
        'DOCENTE DE EDUCACIÓN FISICA': 'Docente de Educación Física',
        'SECRETARIA': 'Secretaría Administrativa',
        'AUXILIAR DE EDUCACIÓN': 'Auxiliar de Educación',
        'COORDINADOR': 'Coordinación Pedagógica',
        'PSICÓLOGA': 'Psicóloga Institucional',
        'CIST': 'Coordinación de Innovación Tecnológica (CIST)',
        'P. I. P.': 'Profesor de Innovación Pedagógica (PIP)',
        'PIP': 'Profesor de Innovación Pedagógica (PIP)',
    };
    if (map[clean]) return map[clean];
    return cargo
        .toLowerCase()
        .replace(/(^|[\s,.\-\/])([a-záéíóúñ])/gi, (match, sep, char) => sep + char.toUpperCase());
}

// Descripción por nivel educativo
const NIVELES_CONFIG = {
    Inicial: {
        desc: 'Primeros pasos en el aprendizaje, motricidad y convivencia a través del juego.',
        rango: '3 a 5 años'
    },
    Primaria: {
        desc: 'Lectura, matemáticas y valores fundamentales para el desarrollo de los niños.',
        rango: '1.° a 6.° de primaria'
    },
    Secundaria: {
        desc: 'Preparación académica, ciencias y formación para el futuro de los jóvenes.',
        rango: '1.° a 5.° de secundaria'
    }
};

export default function Docentes({ porNivel = {} }) {
    const [selectedNivel, setSelectedNivel] = useState('Todos');
    const [searchQuery, setSearchQuery] = useState('');

    // Aplanar y normalizar el listado de docentes
    const todosDocentes = useMemo(() => {
        const result = [];
        Object.entries(porNivel).forEach(([nivel, lista]) => {
            if (Array.isArray(lista)) {
                lista.forEach((d) => {
                    result.push({
                        ...d,
                        nivel: d.nivel || nivel,
                        nombreFormateado: formatDocenteName(d.nombres_apellidos),
                        cargoFormateado: formatCargo(d.cargo),
                    });
                });
            }
        });
        return result;
    }, [porNivel]);

    // Conteos por nivel
    const conteos = useMemo(() => {
        return {
            Todos: todosDocentes.length,
            Inicial: porNivel.Inicial?.length || 0,
            Primaria: porNivel.Primaria?.length || 0,
            Secundaria: porNivel.Secundaria?.length || 0,
        };
    }, [todosDocentes, porNivel]);

    // Filtrado interactivo
    const filteredDocentes = useMemo(() => {
        const query = searchQuery.trim().toLowerCase();

        return todosDocentes.filter((docente) => {
            // Filtro por nivel
            if (selectedNivel !== 'Todos' && docente.nivel !== selectedNivel) {
                return false;
            }

            // Filtro por búsqueda
            if (query) {
                const matchNombre = (docente.nombres_apellidos || '').toLowerCase().includes(query);
                const matchCargo = (docente.cargo || '').toLowerCase().includes(query);
                const matchNivel = (docente.nivel || '').toLowerCase().includes(query);
                return matchNombre || matchCargo || matchNivel;
            }

            return true;
        });
    }, [todosDocentes, selectedNivel, searchQuery]);

    // Agrupación por nivel si estamos en vista "Todos" sin búsqueda
    const mostrarAgrupado = selectedNivel === 'Todos' && !searchQuery.trim();

    return (
        <AppLayout>
            <Head title="Nuestros Profesores | I.E.I. N° 31756 Ricardo Palma" />

            {/* =========================================================================
                1. CABECERA LIMPIA
               ========================================================================= */}
            <section className="relative bg-[#FBFBFA] border-b border-neutral-200/80 pt-10 sm:pt-14 pb-14 sm:pb-18">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-8">
                    
                    {/* Migas de pan */}
                    <div className="flex items-center gap-2 font-mate text-xs text-neutral-400 uppercase tracking-wider font-semibold">
                        <Link href="/" className="hover:text-ricardo-teal transition-colors">Inicio</Link>
                        <span>/</span>
                        <span className="text-neutral-700">Comunidad</span>
                        <span>/</span>
                        <span className="text-ricardo-teal">Profesores</span>
                    </div>

                    {/* Cabecera */}
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                        
                        {/* Columna Izquierda */}
                        <div className="lg:col-span-7 space-y-5">
                            <div className="space-y-3">
                                <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-bold block">
                                    Plana de Profesores
                                </span>
                                <h1 className="font-mate text-3xl sm:text-5xl lg:text-[46px] text-neutral-900 uppercase font-bold tracking-tight leading-[1.15]">
                                    Nuestros Profesores
                                </h1>
                                <div className="flex h-1 w-24">
                                    <span className="w-2/3 bg-ricardo-teal"></span>
                                    <span className="w-1/3 bg-ricardo-red"></span>
                                </div>
                            </div>

                            <p className="font-literata text-base sm:text-lg text-neutral-700 leading-relaxed font-light max-w-2xl">
                                Profesores y profesoras comprometidos con la enseñanza, el cuidado y los valores de nuestros estudiantes en Cerro de Pasco.
                            </p>
                        </div>

                        {/* Columna Derecha */}
                        <div className="lg:col-span-5 grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div className="bg-white border border-neutral-200/80 rounded-xl p-4 shadow-2xs space-y-1">
                                <div className="flex items-center justify-between text-ricardo-teal mb-2">
                                    <Users className="w-5 h-5" />
                                    <span className="font-mate text-xs uppercase tracking-wider font-semibold text-neutral-400">Total</span>
                                </div>
                                <p className="font-mate text-2xl font-bold text-neutral-900">{conteos.Todos}</p>
                                <p className="font-literata text-xs text-neutral-500">Profesores</p>
                            </div>

                            <div className="bg-white border border-neutral-200/80 rounded-xl p-4 shadow-2xs space-y-1">
                                <div className="flex items-center justify-between text-ricardo-teal mb-2">
                                    <GraduationCap className="w-5 h-5" />
                                    <span className="font-mate text-xs uppercase tracking-wider font-semibold text-neutral-400">Niveles</span>
                                </div>
                                <p className="font-mate text-2xl font-bold text-neutral-900">3</p>
                                <p className="font-literata text-xs text-neutral-500">Inicial, Primaria, Secundaria</p>
                            </div>

                            <div className="bg-white border border-neutral-200/80 rounded-xl p-4 shadow-2xs space-y-1">
                                <div className="flex items-center justify-between text-ricardo-red mb-2">
                                    <Sparkles className="w-5 h-5" />
                                    <span className="font-mate text-xs uppercase tracking-wider font-semibold text-neutral-400">Vocación</span>
                                </div>
                                <p className="font-mate text-2xl font-bold text-neutral-900">100%</p>
                                <p className="font-literata text-xs text-neutral-500">Dedicación Escolar</p>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            {/* =========================================================================
                2. BARRA DE CONTROL Y FILTRADO INTERACTIVO (SEARCH + TABS)
               ========================================================================= */}
            <section className="sticky top-0 z-20 bg-white/95 backdrop-blur-md border-b border-neutral-200/80 py-4 shadow-2xs">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                        
                        {/* Selector Segmentado de Niveles (Pills) */}
                        <div className="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
                            {['Todos', 'Inicial', 'Primaria', 'Secundaria'].map((tab) => {
                                const isSelected = selectedNivel === tab;
                                const count = conteos[tab];

                                return (
                                    <button
                                        key={tab}
                                        type="button"
                                        onClick={() => setSelectedNivel(tab)}
                                        className={`px-3.5 py-2 rounded-xl font-mate text-xs uppercase tracking-wider font-semibold transition-all whitespace-nowrap flex items-center gap-2 cursor-pointer ${
                                            isSelected
                                                ? 'bg-ricardo-red text-white shadow-xs'
                                                : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200/80 hover:text-neutral-900'
                                        }`}
                                    >
                                        <span>{tab === 'Todos' ? 'Todos los Niveles' : tab}</span>
                                        <span
                                            className={`px-1.5 py-0.5 rounded-md text-[10px] font-bold ${
                                                isSelected
                                                    ? 'bg-white/20 text-white'
                                                    : 'bg-neutral-200 text-neutral-600'
                                            }`}
                                        >
                                            {count}
                                        </span>
                                    </button>
                                );
                            })}
                        </div>

                        {/* Buscador en Tiempo Real */}
                        <div className="relative w-full md:w-80 shrink-0">
                            <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-400">
                                <Search className="w-4 h-4" />
                            </div>
                            <input
                                type="text"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                placeholder="Buscar por nombre o cargo..."
                                className="w-full pl-10 pr-9 py-2 bg-neutral-50 border border-neutral-200 rounded-xl text-sm font-literata text-neutral-800 placeholder-neutral-400 focus:outline-none focus:border-ricardo-teal focus:bg-white transition-all"
                            />
                            {searchQuery && (
                                <button
                                    type="button"
                                    onClick={() => setSearchQuery('')}
                                    className="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-400 hover:text-neutral-600"
                                    title="Limpiar búsqueda"
                                >
                                    <X className="w-4 h-4" />
                                </button>
                            )}
                        </div>

                    </div>
                </div>
            </section>

            {/* =========================================================================
                3. DIRECTORIO DOCENTE EDITORIAL
               ========================================================================= */}
            <section className="bg-white py-12 sm:py-16 min-h-[500px]">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-12">
                    
                    {/* Resumen del filtro activo */}
                    <div className="flex items-center justify-between border-b border-neutral-200/70 pb-4">
                        <p className="font-mate text-xs uppercase tracking-wider text-neutral-500 font-semibold">
                            {searchQuery ? (
                                <>Resultados para &ldquo;<span className="text-neutral-900 font-bold">{searchQuery}</span>&rdquo; en {selectedNivel}:</>
                            ) : (
                                <>Directorio {selectedNivel === 'Todos' ? 'Completo' : `Nivel ${selectedNivel}`}:</>
                            )}
                        </p>
                        <span className="font-mate text-xs text-neutral-500 font-semibold">
                            {filteredDocentes.length} {filteredDocentes.length === 1 ? 'docente encontrado' : 'docentes encontrados'}
                        </span>
                    </div>

                    {/* Caso A: Si no hay resultados de búsqueda */}
                    {filteredDocentes.length === 0 && (
                        <div className="text-center py-16 px-4 bg-[#FBFBFA] rounded-2xl border border-dashed border-neutral-300 space-y-4">
                            <div className="w-12 h-12 rounded-full bg-neutral-100 flex items-center justify-center mx-auto text-neutral-400">
                                <Search className="w-6 h-6" />
                            </div>
                            <div className="space-y-1">
                                <h3 className="font-mate text-lg font-bold text-neutral-800">
                                    No se encontraron docentes
                                </h3>
                                <p className="font-literata text-sm text-neutral-500 max-w-md mx-auto">
                                    No hay resultados que coincidan con &ldquo;{searchQuery}&rdquo; en {selectedNivel}. Intenta buscar con otros términos.
                                </p>
                            </div>
                            <button
                                type="button"
                                onClick={() => {
                                    setSearchQuery('');
                                    setSelectedNivel('Todos');
                                }}
                                className="inline-flex items-center gap-2 px-4 py-2 bg-ricardo-teal text-white rounded-xl font-mate text-xs uppercase tracking-wider font-semibold hover:bg-ricardo-teal-dark transition-colors cursor-pointer"
                            >
                                Restablecer Directorio
                            </button>
                        </div>
                    )}

                    {/* Caso B: Vista agrupada por Nivel (cuando selectedNivel === 'Todos' y no hay búsqueda) */}
                    {mostrarAgrupado && filteredDocentes.length > 0 && (
                        <div className="space-y-14">
                            {['Inicial', 'Primaria', 'Secundaria'].map((nivel) => {
                                const docentesDelNivel = filteredDocentes.filter((d) => d.nivel === nivel);
                                if (docentesDelNivel.length === 0) return null;
                                const config = NIVELES_CONFIG[nivel];

                                return (
                                    <div key={nivel} className="space-y-6">
                                        
                                        {/* Cabecera de Nivel Limpia (sin badges redundantes) */}
                                        <div className="border-l-2 border-ricardo-teal pl-4 space-y-1">
                                            <h2 className="font-mate text-xl sm:text-2xl font-bold text-neutral-900 uppercase tracking-tight">
                                                Nivel {nivel}
                                            </h2>
                                            <p className="font-literata text-xs sm:text-sm text-neutral-500">
                                                {config.desc} ({config.rango})
                                            </p>
                                        </div>

                                        {/* Rejilla de Docentes Minimalista */}
                                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                                            {docentesDelNivel.map((docente, idx) => (
                                                <DocenteCard
                                                    key={docente.id || `${nivel}-${idx}`}
                                                    docente={docente}
                                                />
                                            ))}
                                        </div>

                                    </div>
                                );
                            })}
                        </div>
                    )}

                    {/* Caso C: Vista plana / filtrada (cuando se selecciona un nivel específico o hay búsqueda activa) */}
                    {!mostrarAgrupado && filteredDocentes.length > 0 && (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                            {filteredDocentes.map((docente, idx) => (
                                <DocenteCard
                                    key={docente.id || idx}
                                    docente={docente}
                                />
                            ))}
                        </div>
                    )}

                </div>
            </section>
        </AppLayout>
    );
}

// Tarjeta editorial minimalista (sin números, sin badges redundantes, pura elegancia tipográfica)
function DocenteCard({ docente }) {
    return (
        <div className="group bg-[#FBFBFA] hover:bg-white border border-neutral-200/80 hover:border-ricardo-teal/40 rounded-xl p-4 sm:p-5 transition-all duration-200 shadow-2xs hover:shadow-xs flex items-center gap-3.5">
            
            {/* Foto real solo si existe */}
            {docente.foto && (
                <img
                    src={docente.foto}
                    alt={docente.nombres_apellidos}
                    className="w-11 h-11 rounded-lg object-cover border border-neutral-200 shrink-0"
                />
            )}

            {/* Información tipográfica limpia */}
            <div className="min-w-0 flex-1 space-y-0.5">
                <h3 className="font-mate text-base font-bold text-neutral-900 group-hover:text-ricardo-teal transition-colors leading-snug line-clamp-2">
                    {docente.nombreFormateado || docente.nombres_apellidos}
                </h3>
                <p className="font-literata text-xs text-neutral-500 font-medium">
                    {docente.cargoFormateado || docente.cargo}
                </p>
            </div>
        </div>
    );
}
