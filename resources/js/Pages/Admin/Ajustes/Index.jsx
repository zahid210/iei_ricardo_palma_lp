import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import { 
    Settings, 
    Phone, 
    Mail, 
    Clock, 
    MapPin, 
    Share2, 
    Save, 
    ExternalLink,
    CheckCircle2
} from 'lucide-react';

export default function AjustesIndex({ ajustes }) {
    const { data, setData, put, processing, errors, recentlySuccessful } = useForm({
        telefono: ajustes?.telefono || '',
        whatsapp: ajustes?.whatsapp || '',
        email: ajustes?.email || '',
        horario_atencion: ajustes?.horario_atencion || '',
        direccion: ajustes?.direccion || '',
        google_maps_url: ajustes?.google_maps_url || '',
        facebook_url: ajustes?.facebook_url || '',
        youtube_url: ajustes?.youtube_url || '',
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        put('/admin/ajustes', {
            preserveScroll: true,
        });
    };

    return (
        <AdminLayout title="Ajustes Institucionales">
            <Head title="Ajustes Institucionales | Panel Ricardino" />

            <div className="max-w-4xl mx-auto space-y-8">
                
                {/* Cabecera */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-200/80 pb-6">
                    <div>
                        <div className="flex items-center gap-2 text-ricardo-teal font-mate text-xs font-bold uppercase tracking-widest mb-1">
                            <Settings className="w-4 h-4" />
                            <span>Configuración General</span>
                        </div>
                        <h1 className="font-mate text-2xl sm:text-3xl font-bold uppercase tracking-tight text-neutral-900">
                            Ajustes Institucionales
                        </h1>
                        <p className="font-literata text-xs sm:text-sm text-neutral-500 mt-1">
                            Actualiza los canales oficiales, teléfonos de atención y ubicación que se muestran en el sitio web.
                        </p>
                    </div>

                    {recentlySuccessful && (
                        <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-mate font-bold animate-fadeIn">
                            <CheckCircle2 className="w-4 h-4 text-emerald-600" />
                            <span>¡Guardado con éxito!</span>
                        </div>
                    )}
                </div>

                <form onSubmit={handleSubmit} className="space-y-8">
                    
                    {/* BLOQUE 1: ATENCIÓN Y CONTACTO */}
                    <div className="bg-white rounded-3xl border border-neutral-200/90 p-6 sm:p-8 shadow-2xs space-y-6">
                        <div className="flex items-center gap-2.5 border-b border-neutral-100 pb-4">
                            <div className="w-8 h-8 rounded-xl bg-teal-50 text-ricardo-teal flex items-center justify-center">
                                <Phone className="w-4 h-4" />
                            </div>
                            <div>
                                <h2 className="font-mate text-sm sm:text-base font-bold uppercase tracking-wider text-neutral-900">
                                    Canales de Atención
                                </h2>
                                <p className="font-literata text-xs text-neutral-400">
                                    Teléfonos de llamadas, WhatsApp para padres y correo institucional.
                                </p>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {/* Teléfono */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Teléfono de Llamadas / Central
                                </label>
                                <input
                                    type="text"
                                    value={data.telefono}
                                    onChange={(e) => setData('telefono', e.target.value)}
                                    placeholder="+51 921 896 330"
                                    className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                />
                                {errors.telefono && <p className="text-xs text-ricardo-red font-medium">{errors.telefono}</p>}
                            </div>

                            {/* WhatsApp */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    WhatsApp Oficial (Número directo sin espacios)
                                </label>
                                <input
                                    type="text"
                                    value={data.whatsapp}
                                    onChange={(e) => setData('whatsapp', e.target.value)}
                                    placeholder="51921896330"
                                    className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                />
                                {errors.whatsapp && <p className="text-xs text-ricardo-red font-medium">{errors.whatsapp}</p>}
                                <p className="text-[11px] font-literata text-neutral-400">
                                    Se usará para generar el botón de enlace directo: <span className="font-mono text-neutral-600">wa.me/{data.whatsapp || '51...'}</span>
                                </p>
                            </div>

                            {/* Email */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Correo Electrónico Institucional
                                </label>
                                <input
                                    type="email"
                                    value={data.email}
                                    onChange={(e) => setData('email', e.target.value)}
                                    placeholder="contacto@rpalma.edu.pe"
                                    className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                />
                                {errors.email && <p className="text-xs text-ricardo-red font-medium">{errors.email}</p>}
                            </div>

                            {/* Horario de Atención */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Horario de Atención al Público
                                </label>
                                <input
                                    type="text"
                                    value={data.horario_atencion}
                                    onChange={(e) => setData('horario_atencion', e.target.value)}
                                    placeholder="Lunes a Viernes: 8:00 a.m. a 1:00 p.m."
                                    className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                />
                                {errors.horario_atencion && <p className="text-xs text-ricardo-red font-medium">{errors.horario_atencion}</p>}
                            </div>
                        </div>
                    </div>

                    {/* BLOQUE 2: UBICACIÓN INSTITUCIONAL */}
                    <div className="bg-white rounded-3xl border border-neutral-200/90 p-6 sm:p-8 shadow-2xs space-y-6">
                        <div className="flex items-center gap-2.5 border-b border-neutral-100 pb-4">
                            <div className="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                <MapPin className="w-4 h-4" />
                            </div>
                            <div>
                                <h2 className="font-mate text-sm sm:text-base font-bold uppercase tracking-wider text-neutral-900">
                                    Ubicación y Sede
                                </h2>
                                <p className="font-literata text-xs text-neutral-400">
                                    Dirección física en Cerro de Pasco y enlace a Google Maps.
                                </p>
                            </div>
                        </div>

                        <div className="space-y-5">
                            {/* Dirección */}
                            <div className="space-y-1.5">
                                <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                    Dirección Física Completa
                                </label>
                                <input
                                    type="text"
                                    value={data.direccion}
                                    onChange={(e) => setData('direccion', e.target.value)}
                                    placeholder="Barrio La Esperanza s/n, Chaupimarca — Cerro de Pasco, Región Pasco, Perú."
                                    className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                />
                                {errors.direccion && <p className="text-xs text-ricardo-red font-medium">{errors.direccion}</p>}
                            </div>

                            {/* Enlace Google Maps */}
                            <div className="space-y-1.5">
                                <div className="flex items-center justify-between">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Enlace a Google Maps
                                    </label>
                                    {data.google_maps_url && (
                                        <a
                                            href={data.google_maps_url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="text-xs font-mate text-ricardo-teal hover:underline inline-flex items-center gap-1"
                                        >
                                            <span>Probar enlace</span>
                                            <ExternalLink className="w-3 h-3" />
                                        </a>
                                    )}
                                </div>
                                <input
                                    type="text"
                                    value={data.google_maps_url}
                                    onChange={(e) => setData('google_maps_url', e.target.value)}
                                    placeholder="https://maps.app.goo.gl/..."
                                    className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                />
                                {errors.google_maps_url && <p className="text-xs text-ricardo-red font-medium">{errors.google_maps_url}</p>}
                            </div>
                        </div>
                    </div>

                    {/* BLOQUE 3: REDES SOCIALES */}
                    <div className="bg-white rounded-3xl border border-neutral-200/90 p-6 sm:p-8 shadow-2xs space-y-6">
                        <div className="flex items-center gap-2.5 border-b border-neutral-100 pb-4">
                            <div className="w-8 h-8 rounded-xl bg-red-50 text-ricardo-red flex items-center justify-center">
                                <Share2 className="w-4 h-4" />
                            </div>
                            <div>
                                <h2 className="font-mate text-sm sm:text-base font-bold uppercase tracking-wider text-neutral-900">
                                    Redes Sociales y Multimedia
                                </h2>
                                <p className="font-literata text-xs text-neutral-400">
                                    Enlaces oficiales que se integran en el pie de página institucional.
                                </p>
                            </div>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            {/* Facebook */}
                            <div className="space-y-1.5">
                                <div className="flex items-center justify-between">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Página de Facebook
                                    </label>
                                    {data.facebook_url && (
                                        <a
                                            href={data.facebook_url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="text-xs font-mate text-ricardo-teal hover:underline inline-flex items-center gap-1"
                                        >
                                            <span>Abrir</span>
                                            <ExternalLink className="w-3 h-3" />
                                        </a>
                                    )}
                                </div>
                                <input
                                    type="text"
                                    value={data.facebook_url}
                                    onChange={(e) => setData('facebook_url', e.target.value)}
                                    placeholder="https://www.facebook.com/..."
                                    className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                />
                                {errors.facebook_url && <p className="text-xs text-ricardo-red font-medium">{errors.facebook_url}</p>}
                            </div>

                            {/* YouTube */}
                            <div className="space-y-1.5">
                                <div className="flex items-center justify-between">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Canal de YouTube
                                    </label>
                                    {data.youtube_url && (
                                        <a
                                            href={data.youtube_url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="text-xs font-mate text-ricardo-teal hover:underline inline-flex items-center gap-1"
                                        >
                                            <span>Abrir</span>
                                            <ExternalLink className="w-3 h-3" />
                                        </a>
                                    )}
                                </div>
                                <input
                                    type="text"
                                    value={data.youtube_url}
                                    onChange={(e) => setData('youtube_url', e.target.value)}
                                    placeholder="https://www.youtube.com/@..."
                                    className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                />
                                {errors.youtube_url && <p className="text-xs text-ricardo-red font-medium">{errors.youtube_url}</p>}
                            </div>
                        </div>
                    </div>

                    {/* Botón de Guardar flotante / fijo */}
                    <div className="flex items-center justify-end gap-4 pt-4 border-t border-neutral-200/80">
                        <button
                            type="submit"
                            disabled={processing}
                            className="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-ricardo-teal hover:bg-ricardo-teal-dark text-white font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-xs hover:shadow-md disabled:opacity-50 cursor-pointer"
                        >
                            <Save className="w-4 h-4" />
                            <span>{processing ? 'Guardando Cambios...' : 'Guardar Ajustes Institucionales'}</span>
                        </button>
                    </div>

                </form>

            </div>
        </AdminLayout>
    );
}
