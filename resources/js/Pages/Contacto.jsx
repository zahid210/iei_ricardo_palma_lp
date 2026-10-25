import React from 'react';
import { Head, useForm, usePage } from '@inertiajs/react';
import AppLayout from '../Layouts/AppLayout';
import { CheckCircle2, Send, MapPin, Clock, Phone, ArrowUpRight } from 'lucide-react';

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

            {/* Banner Institucional */}
            <section className="bg-[#0C3831] text-white py-16 sm:py-20 border-b border-white/10">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 space-y-4">
                    <span className="font-mate text-xs uppercase tracking-widest text-ricardo-yellow font-semibold">
                        Canales de Atención
                    </span>
                    <h1 className="font-mate text-3xl sm:text-5xl uppercase font-bold tracking-tight">
                        Contáctanos
                    </h1>
                    <div className="flex h-1 w-20">
                        <span className="w-2/3 bg-ricardo-teal"></span>
                        <span className="w-1/3 bg-ricardo-red"></span>
                    </div>
                    <p className="font-literata text-base sm:text-lg text-neutral-200 max-w-2xl leading-relaxed pt-1 font-light">
                        Estamos a tu disposición para brindarte orientación sobre matrículas, traslados y nuestra propuesta pedagógica en Cerro de Pasco.
                    </p>
                </div>
            </section>

            {/* Formulario y Canales */}
            <section className="bg-white py-16 sm:py-24 border-b border-neutral-200">
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                        
                        {/* Formulario */}
                        <div className="lg:col-span-7 rounded-3xl border border-neutral-200/90 bg-[#FBFBFA] p-8 sm:p-10 space-y-6 shadow-xs">
                            <div className="space-y-2">
                                <h2 className="font-mate text-2xl sm:text-3xl font-bold uppercase text-neutral-900 tracking-tight">
                                    Envíanos un mensaje
                                </h2>
                                <p className="font-literata text-sm text-neutral-600">
                                    Completa tus datos y nuestro equipo administrativo se comunicará contigo a la brevedad.
                                </p>
                            </div>

                            {(recentlySuccessful || flash?.success) && (
                                <div className="rounded-2xl border border-teal-200 bg-teal-50/80 p-4 flex items-center gap-3 text-sm text-teal-900">
                                    <CheckCircle2 className="w-5 h-5 text-ricardo-teal shrink-0" />
                                    <span>{flash?.success || '¡Gracias por comunicarte! Tu mensaje ha sido enviado correctamente.'}</span>
                                </div>
                            )}

                            <form onSubmit={handleSubmit} className="space-y-5">
                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
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
                                            className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all"
                                            placeholder="Ej. Juan Pérez"
                                        />
                                        {errors.nombre && <p className="text-xs text-ricardo-red">{errors.nombre}</p>}
                                    </div>

                                    <div className="space-y-1.5">
                                        <label htmlFor="telefono" className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                            Teléfono de Contacto
                                        </label>
                                        <input
                                            type="tel"
                                            id="telefono"
                                            value={data.telefono}
                                            onChange={(e) => setData('telefono', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all"
                                            placeholder="921 896 330"
                                        />
                                        {errors.telefono && <p className="text-xs text-ricardo-red">{errors.telefono}</p>}
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
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
                                            className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all"
                                            placeholder="correo@ejemplo.com"
                                        />
                                        {errors.correo && <p className="text-xs text-ricardo-red">{errors.correo}</p>}
                                    </div>

                                    <div className="space-y-1.5">
                                        <label htmlFor="nivel" className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                            Nivel de Interés
                                        </label>
                                        <select
                                            id="nivel"
                                            value={data.nivel}
                                            onChange={(e) => setData('nivel', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all cursor-pointer"
                                        >
                                            <option value="" disabled>Selecciona un nivel</option>
                                            <option value="Inicial">Nivel Inicial</option>
                                            <option value="Primaria">Nivel Primaria</option>
                                            <option value="Secundaria">Nivel Secundaria</option>
                                            <option value="todos">Consultas Generales</option>
                                        </select>
                                        {errors.nivel && <p className="text-xs text-ricardo-red">{errors.nivel}</p>}
                                    </div>
                                </div>

                                <div className="space-y-1.5">
                                    <div className="flex justify-between items-center">
                                        <label htmlFor="mensaje" className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                            Mensaje o Consulta
                                        </label>
                                        <span className="text-[11px] font-system text-neutral-400">
                                            {data.mensaje.length}/255
                                        </span>
                                    </div>
                                    <textarea
                                        id="mensaje"
                                        rows={4}
                                        maxLength={255}
                                        value={data.mensaje}
                                        onChange={(e) => setData('mensaje', e.target.value)}
                                        required
                                        className="w-full rounded-xl border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all resize-none"
                                        placeholder="Escribe aquí tu consulta sobre vacantes, horarios o requisitos..."
                                    />
                                    {errors.mensaje && <p className="text-xs text-ricardo-red">{errors.mensaje}</p>}
                                </div>

                                <button
                                    type="submit"
                                    disabled={processing}
                                    className="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-ricardo-teal hover:bg-ricardo-teal-dark text-white px-8 py-4 font-mate text-xs uppercase tracking-widest font-bold shadow-md hover:shadow-lg transition-all duration-300 disabled:opacity-50 cursor-pointer"
                                >
                                    <span>{processing ? 'Enviando...' : 'Enviar Consulta'}</span>
                                    <Send className="w-4 h-4" />
                                </button>
                            </form>
                        </div>

                        {/* Canales Directos e Información */}
                        <div className="lg:col-span-5 space-y-6">
                            
                            {/* Ubicación y Mapa */}
                            <div className="rounded-3xl border border-neutral-200/90 bg-[#FBFBFA] p-7 sm:p-8 space-y-4 shadow-xs">
                                <div className="flex items-center gap-2.5">
                                    <MapPin className="w-5 h-5 text-ricardo-teal" />
                                    <h3 className="font-mate text-lg font-bold uppercase text-neutral-900 tracking-tight">
                                        Nuestra Ubicación
                                    </h3>
                                </div>
                                <p className="font-literata text-sm text-neutral-600">
                                    Barrio La Esperanza, Chaupimarca - Cerro de Pasco, Perú.
                                </p>
                                
                                <div className="rounded-2xl overflow-hidden border border-neutral-200 aspect-[16/10] max-h-48 relative group">
                                    <a
                                        href="https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9"
                                        target="_blank"
                                        rel="noreferrer"
                                        className="block w-full h-full"
                                    >
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1964.8140410425316!2d-76.25752934177405!3d-10.68656687258902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910813f8373e351d%3A0x6bfe73f8ff169ea2!2sI.E.I%20N%C2%B0%2031756%20%22Ricardo%20Palma%22!5e0!3m2!1ses!2spe!4v1700000000000!5m2!1ses!2spe"
                                            width="100%"
                                            height="100%"
                                            style={{ border: 0 }}
                                            allowFullScreen=""
                                            loading="lazy"
                                            className="h-full w-full pointer-events-none"
                                            title="Ubicación escolar"
                                        />
                                    </a>
                                </div>
                            </div>

                            {/* Horarios y WhatsApp */}
                            <div className="rounded-3xl border border-neutral-200/90 bg-[#FBFBFA] p-7 sm:p-8 space-y-5 shadow-xs">
                                <h3 className="font-mate text-xs font-bold uppercase tracking-widest text-neutral-400 border-b border-neutral-200 pb-3">
                                    Atención Institucional
                                </h3>

                                <div className="space-y-4">
                                    <div className="flex items-start gap-3">
                                        <Clock className="w-4 h-4 text-ricardo-teal mt-0.5 shrink-0" />
                                        <div>
                                            <p className="font-mate text-xs uppercase tracking-wider text-neutral-500 font-semibold">Horario Escolar</p>
                                            <p className="font-literata text-sm text-neutral-800">Lunes a Viernes de 8:00 a.m. a 1:00 p.m.</p>
                                        </div>
                                    </div>

                                    <div className="flex items-start gap-3">
                                        <Phone className="w-4 h-4 text-ricardo-teal mt-0.5 shrink-0" />
                                        <div>
                                            <p className="font-mate text-xs uppercase tracking-wider text-neutral-500 font-semibold">Teléfono de Secretaría</p>
                                            <p className="font-literata text-sm text-neutral-800">+51 921 896 330</p>
                                        </div>
                                    </div>

                                    <div className="pt-2">
                                        <a
                                            href="https://wa.me/51921896330"
                                            target="_blank"
                                            rel="noreferrer"
                                            className="w-full inline-flex items-center justify-center gap-2.5 rounded-xl bg-[#25D366] hover:bg-[#20ba56] text-white px-5 py-3 font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-sm"
                                        >
                                            <span>Atención Directa por WhatsApp</span>
                                            <ArrowUpRight className="w-4 h-4" />
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </section>
        </AppLayout>
    );
}
