import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import { 
    ArrowLeft, 
    Mail, 
    Calendar, 
    Phone, 
    User, 
    GraduationCap, 
    CheckCircle2, 
    Send,
    MessageSquare
} from 'lucide-react';

export default function Show({ contacto }) {
    const handleToggleLeido = () => {
        router.patch(`/admin/mensajes/${contacto.id}/toggle-leido`);
    };

    const cleanPhone = contacto.telefono ? contacto.telefono.replace(/\D/g, '') : null;
    const whatsappUrl = cleanPhone 
        ? `https://wa.me/51${cleanPhone.length === 9 ? cleanPhone : cleanPhone.slice(-9)}?text=${encodeURIComponent(`Hola ${contacto.nombre}, le escribimos de la I.E.I. N° 31756 Ricardo Palma en respuesta a su consulta.`)}`
        : null;

    const formatMessageDate = (dateVal) => {
        if (!dateVal) return '-';
        if (typeof dateVal === 'string' && /^\d{2}\/\d{2}\/\d{4}/.test(dateVal)) {
            return dateVal;
        }
        const d = new Date(dateVal);
        if (isNaN(d.getTime())) return String(dateVal);
        return d.toLocaleDateString('es-PE', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    };

    return (
        <AdminLayout title={`Mensaje: ${contacto.nombre}`}>
            <div className="max-w-4xl mx-auto space-y-6">
                
                {/* Cabecera y Volver */}
                <div className="flex items-center justify-between gap-4">
                    <Link
                        href="/admin/mensajes"
                        className="inline-flex items-center gap-2 text-xs font-mate uppercase tracking-wider text-neutral-500 hover:text-neutral-900 transition-colors font-semibold"
                    >
                        <ArrowLeft className="w-4 h-4" />
                        <span>Volver a la bandeja</span>
                    </Link>

                    <button
                        type="button"
                        onClick={handleToggleLeido}
                        className="btn-admin-secondary text-xs"
                    >
                        {contacto.leido ? 'Marcar como no leído' : 'Marcar como leído'}
                    </button>
                </div>

                {/* Tarjeta del Mensaje */}
                <div className="bg-white rounded-3xl border border-neutral-200/80 p-6 sm:p-10 shadow-2xs space-y-8">
                    
                    {/* Encabezado del remitente */}
                    <div className="flex flex-col sm:flex-row sm:items-start justify-between gap-4 border-b border-neutral-200/70 pb-6">
                        <div className="flex items-center gap-4">
                            <div className="w-12 h-12 rounded-2xl bg-teal-50 text-ricardo-teal border border-teal-100 flex items-center justify-center font-mate font-bold text-lg shrink-0">
                                {contacto.nombre.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <h1 className="font-mate text-xl sm:text-2xl text-neutral-900 font-bold uppercase tracking-tight">
                                    {contacto.nombre}
                                </h1>
                                <span className="text-xs text-neutral-400 font-literata flex items-center gap-1.5 mt-0.5">
                                    <Calendar className="w-3.5 h-3.5" />
                                    Recibido el {formatMessageDate(contacto.created_at)}
                                </span>
                            </div>
                        </div>

                        {/* Nivel Consultado */}
                        {contacto.nivel && (
                            <div className="self-start sm:self-auto">
                                <span className="inline-block font-mate text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-teal-50 text-ricardo-teal border border-teal-100">
                                    Nivel: {contacto.nivel}
                                </span>
                            </div>
                        )}
                    </div>

                    {/* Datos de Contacto Directo */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-[#FBFBFA] p-5 rounded-2xl border border-neutral-200/80">
                        <div className="space-y-1">
                            <span className="font-mate text-[11px] uppercase tracking-wider font-bold text-neutral-400 block">
                                Correo Electrónico
                            </span>
                            <a 
                                href={`mailto:${contacto.correo}?subject=Respuesta de la I.E.I. N° 31756 Ricardo Palma`}
                                className="text-sm font-semibold text-ricardo-teal hover:underline flex items-center gap-1.5 font-literata"
                            >
                                <Mail className="w-4 h-4 text-ricardo-teal" />
                                <span>{contacto.correo}</span>
                            </a>
                        </div>

                        <div className="space-y-1">
                            <span className="font-mate text-[11px] uppercase tracking-wider font-bold text-neutral-400 block">
                                Teléfono de Contacto
                            </span>
                            {contacto.telefono ? (
                                <span className="text-sm font-semibold text-neutral-800 flex items-center gap-1.5 font-mono">
                                    <Phone className="w-4 h-4 text-neutral-500" />
                                    <span>{contacto.telefono}</span>
                                </span>
                            ) : (
                                <span className="text-xs text-neutral-400 font-literata">No proporcionado</span>
                            )}
                        </div>
                    </div>

                    {/* Contenido de la Consulta */}
                    <div className="space-y-2">
                        <span className="font-mate text-xs uppercase tracking-wider font-bold text-neutral-500 block">
                            Contenido del Mensaje
                        </span>
                        <div className="p-6 rounded-2xl border border-neutral-200/90 bg-white font-literata text-base text-neutral-800 leading-relaxed whitespace-pre-wrap">
                            {contacto.mensaje}
                        </div>
                    </div>

                    {/* Botones de Acción */}
                    <div className="pt-4 border-t border-neutral-200/80 flex flex-wrap items-center justify-between gap-3">
                        <div className="flex items-center gap-2 text-xs text-neutral-500 font-literata">
                            <CheckCircle2 className="w-4 h-4 text-emerald-600" />
                            <span>Consulta registrada en el sistema escolar.</span>
                        </div>

                        <div className="flex items-center gap-3">
                            {whatsappUrl && (
                                <a
                                    href={whatsappUrl}
                                    target="_blank"
                                    rel="noreferrer"
                                    className="btn-admin-secondary text-xs text-emerald-700 hover:border-emerald-300"
                                >
                                    <Send className="w-3.5 h-3.5" />
                                    <span>Responder por WhatsApp</span>
                                </a>
                            )}

                            <a
                                href={`mailto:${contacto.correo}?subject=Respuesta de la I.E.I. N° 31756 Ricardo Palma&body=Estimado(a) ${encodeURIComponent(contacto.nombre)}:%0D%0A%0D%0AEn respuesta a su consulta realizada a través de nuestra página web...`}
                                className="btn-admin-primary"
                            >
                                <Mail className="w-4 h-4" />
                                <span>Responder por Correo</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </AdminLayout>
    );
}
