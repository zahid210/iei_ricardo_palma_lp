import React from 'react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { 
    CheckCircle2, 
    Send, 
    Clock, 
    Phone, 
    MapPin, 
    ExternalLink 
} from 'lucide-react';

export default function Contacto() {
    const { flash = {} } = usePage().props;
    const { data, setData, post, processing, errors, reset, recentlySuccessful } = useForm({
        nombre: '',
        telefono: '',
        correo: '',
        nivel: '',
        mensaje: ''
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/contacto', {
            onSuccess: () => reset()
        });
    };

    return (
        <AppLayout>
            <Head title="Contacto | I.E.I. N° 31756 Ricardo Palma" />

            {/* =========================================================================
                1. CABECERA LIMPIA Y CERCANA AL COLEGIO
               ========================================================================= */}
            <section className="relative bg-[#FBFBFA] border-b border-neutral-200/80 pt-10 sm:pt-14 pb-14 sm:pb-18">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-6">
                    
                    {/* Migas de pan */}
                    <div className="flex items-center gap-2 font-mate text-xs text-neutral-400 uppercase tracking-wider font-semibold">
                        <Link href="/" className="hover:text-ricardo-teal transition-colors">Inicio</Link>
                        <span>/</span>
                        <span className="text-neutral-700">Comunidad</span>
                        <span>/</span>
                        <span className="text-ricardo-teal">Contacto</span>
                    </div>

                    {/* Presentación */}
                    <div className="max-w-3xl space-y-4">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-bold block">
                            Atención a Padres y Apoderados
                        </span>
                        <h1 className="font-mate text-3xl sm:text-5xl lg:text-[46px] text-neutral-900 uppercase font-bold tracking-tight leading-[1.15]">
                            Contáctanos
                        </h1>
                        <div className="flex h-1 w-24">
                            <span className="w-2/3 bg-ricardo-teal"></span>
                            <span className="w-1/3 bg-ricardo-red"></span>
                        </div>
                        <p className="font-literata text-base sm:text-lg text-neutral-700 leading-relaxed font-light pt-1">
                            Estamos a disposición de los padres de familia y vecinos de Chaupimarca para orientar consultas sobre matrículas, traslados o cualquier duda de nuestro colegio.
                        </p>
                    </div>

                </div>
            </section>

            {/* =========================================================================
                2. FORMULARIO EDITORIAL Y CANALES DIRECTOS
               ========================================================================= */}
            <section className="bg-white py-12 sm:py-20 border-b border-neutral-200/80">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                        
                        {/* Columna Izquierda: Formulario de Contacto */}
                        <div className="lg:col-span-7 rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] p-6 sm:p-10 space-y-6 shadow-2xs">
                            <div className="space-y-1.5 border-b border-neutral-200/80 pb-4">
                                <h2 className="font-mate text-xl sm:text-2xl font-bold uppercase text-neutral-900 tracking-tight">
                                    Envíanos un mensaje
                                </h2>
                                <p className="font-literata text-xs sm:text-sm text-neutral-600">
                                    Completa tus datos y nos comunicaremos contigo para ayudarte.
                                </p>
                            </div>

                            {/* Alerta de Éxito Flash */}
                            {(recentlySuccessful || flash?.success) && (
                                <div className="rounded-xl border border-teal-200 bg-teal-50/80 p-4 flex items-center gap-3 text-sm text-teal-900 shadow-2xs">
                                    <CheckCircle2 className="w-5 h-5 text-ricardo-teal shrink-0" />
                                    <span className="font-literata font-medium">
                                        {flash?.success || '¡Gracias por comunicarte! Tu mensaje ha sido recibido exitosamente.'}
                                    </span>
                                </div>
                            )}

                            <form onSubmit={handleSubmit} className="space-y-5">
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    
                                    {/* Nombre */}
                                    <div className="space-y-1.5">
                                        <label htmlFor="nombre" className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                            Nombre del Padre o Apoderado
                                        </label>
                                        <input
                                            type="text"
                                            id="nombre"
                                            value={data.nombre}
                                            onChange={(e) => setData('nombre', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                            placeholder="Ej. Juan Pérez"
                                        />
                                        {errors.nombre && <p className="text-xs text-ricardo-red font-medium">{errors.nombre}</p>}
                                    </div>

                                    {/* Teléfono */}
                                    <div className="space-y-1.5">
                                        <label htmlFor="telefono" className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                            Teléfono de Contacto
                                        </label>
                                        <input
                                            type="tel"
                                            id="telefono"
                                            maxLength={9}
                                            value={data.telefono}
                                            onChange={(e) => setData('telefono', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                            placeholder="921 896 330"
                                        />
                                        {errors.telefono && <p className="text-xs text-ricardo-red font-medium">{errors.telefono}</p>}
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    
                                    {/* Correo Electrónico */}
                                    <div className="space-y-1.5">
                                        <label htmlFor="correo" className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                            Correo Electrónico
                                        </label>
                                        <input
                                            type="email"
                                            id="correo"
                                            value={data.correo}
                                            onChange={(e) => setData('correo', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                            placeholder="correo@ejemplo.com"
                                        />
                                        {errors.correo && <p className="text-xs text-ricardo-red font-medium">{errors.correo}</p>}
                                    </div>

                                    {/* Nivel de Interés */}
                                    <div className="space-y-1.5">
                                        <label htmlFor="nivel" className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                            Nivel de Interés
                                        </label>
                                        <select
                                            id="nivel"
                                            value={data.nivel}
                                            onChange={(e) => setData('nivel', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all cursor-pointer font-literata"
                                        >
                                            <option value="" disabled>Selecciona un nivel</option>
                                            <option value="Inicial">Nivel Inicial (3 a 5 años)</option>
                                            <option value="Primaria">Nivel Primaria (1.° a 6.° grado)</option>
                                            <option value="Secundaria">Nivel Secundaria (1.° a 5.° año)</option>
                                            <option value="todos">Consultas generales</option>
                                        </select>
                                        {errors.nivel && <p className="text-xs text-ricardo-red font-medium">{errors.nivel}</p>}
                                    </div>
                                </div>

                                {/* Mensaje */}
                                <div className="space-y-1.5">
                                    <div className="flex justify-between items-center">
                                        <label htmlFor="mensaje" className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                            Mensaje o Consulta
                                        </label>
                                        <span className="text-[11px] font-mate text-neutral-400">
                                            {data.mensaje.length} / 255
                                        </span>
                                    </div>
                                    <textarea
                                        id="mensaje"
                                        rows={4}
                                        maxLength={255}
                                        value={data.mensaje}
                                        onChange={(e) => setData('mensaje', e.target.value)}
                                        required
                                        className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all resize-none font-literata"
                                        placeholder="Escribe aquí tu consulta sobre vacantes, horarios, traslados o cualquier duda..."
                                    />
                                    {errors.mensaje && <p className="text-xs text-ricardo-red font-medium">{errors.mensaje}</p>}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-ricardo-teal hover:bg-ricardo-teal-dark text-white px-8 py-3.5 font-mate text-xs uppercase tracking-wider font-bold shadow-xs hover:shadow-sm transition-all duration-200 disabled:opacity-50 cursor-pointer"
                                >
                                    <span>{processing ? 'Enviando...' : 'Enviar Consulta'}</span>
                                    <Send className="w-4 h-4" />
                                </button>
                            </form>
                        </div>

                        {/* Columna Derecha: Canales Directos e Información */}
                        <div className="lg:col-span-5 space-y-6">
                            
                            {/* Atención en el Colegio & WhatsApp */}
                            <div className="rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] p-6 sm:p-8 space-y-6 shadow-2xs">
                                <div className="border-b border-neutral-200/80 pb-3">
                                    <span className="font-mate text-xs font-bold uppercase tracking-widest text-neutral-400">
                                        Horario y Teléfono
                                    </span>
                                </div>

                                <div className="space-y-4">
                                    <div className="flex items-start gap-3.5">
                                        <div className="w-9 h-9 rounded-lg bg-white border border-neutral-200/80 flex items-center justify-center text-ricardo-teal shrink-0">
                                            <Clock className="w-4 h-4" />
                                        </div>
                                        <div className="space-y-0.5">
                                            <p className="font-mate text-xs uppercase tracking-wider text-neutral-500 font-semibold">Horario de atención</p>
                                            <p className="font-literata text-sm text-neutral-900">Lunes a Viernes: 8:00 a.m. a 1:00 p.m.</p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3.5">
                                        <div className="w-9 h-9 rounded-lg bg-white border border-neutral-200/80 flex items-center justify-center text-ricardo-teal shrink-0">
                                            <Phone className="w-4 h-4" />
                                        </div>
                                        <div className="space-y-0.5">
                                            <p className="font-mate text-xs uppercase tracking-wider text-neutral-500 font-semibold">Teléfono</p>
                                            <p className="font-literata text-sm text-neutral-900">+51 921 896 330</p>
                                        </div>
                                    </div>
                                </div>

                                {/* Botón Oficial de WhatsApp */}
                                <div className="pt-2 border-t border-neutral-200/80">
                                    <a
                                        href="https://wa.me/51921896330"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-full inline-flex items-center justify-center gap-2.5 rounded-xl bg-[#25D366] hover:bg-[#20ba56] text-white px-5 py-3 font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-xs hover:shadow-sm cursor-pointer"
                                    >
                                        <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                        </svg>
                                        <span>Atención Directa por WhatsApp</span>
                                        <ExternalLink className="w-3.5 h-3.5 opacity-80" />
                                    </a>
                                </div>
                            </div>

                            {/* Ubicación Geográfica en Pasco */}
                            <div className="rounded-2xl border border-neutral-200/80 bg-[#FBFBFA] overflow-hidden shadow-2xs space-y-4">
                                <div className="p-6 sm:p-8 pb-0 space-y-3">
                                    <div className="flex items-center justify-between border-b border-neutral-200/80 pb-3">
                                        <span className="font-mate text-xs font-bold uppercase tracking-widest text-neutral-400">
                                            Nuestra Ubicación
                                        </span>
                                        <a
                                            href="https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="font-mate text-xs uppercase tracking-wider font-bold text-ricardo-teal hover:underline inline-flex items-center gap-1"
                                        >
                                            <span>Abrir en Maps</span>
                                            <ExternalLink className="w-3.5 h-3.5" />
                                        </a>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <MapPin className="w-4 h-4 text-ricardo-teal mt-0.5 shrink-0" />
                                        <p className="font-literata text-sm text-neutral-700 leading-relaxed">
                                            Barrio La Esperanza s/n, Chaupimarca — Cerro de Pasco, Región Pasco, Perú.
                                        </p>
                                    </div>
                                </div>
                                
                                {/* Vista previa del mapa ocupando completamente el contenedor */}
                                <div className="w-full h-64 sm:h-72 border-t border-neutral-200/80 bg-neutral-100">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1964.8140410425316!2d-76.25752934177405!3d-10.68656687258902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910813f8373e351d%3A0x6bfe73f8ff169ea2!2sI.E.I%20N%C2%B0%2031756%20%22Ricardo%20Palma%22!5e0!3m2!1ses!2spe!4v1700000000000!5m2!1ses!2spe"
                                        width="100%"
                                        height="100%"
                                        style={{ border: 0 }}
                                        allowFullScreen=""
                                        loading="lazy"
                                        referrerPolicy="no-referrer-when-downgrade"
                                        className="w-full h-full block"
                                        title="Ubicación I.E.I. Ricardo Palma en Cerro de Pasco"
                                    />
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section>
        </AppLayout>
    );
}
