import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import { 
    User, 
    KeyRound, 
    Save, 
    CheckCircle2, 
    ShieldCheck, 
    Mail, 
    Lock
} from 'lucide-react';

export default function PerfilIndex({ user }) {
    // Formulario 1: Datos Personales
    const formPerfil = useForm({
        name: user?.name || '',
        email: user?.email || '',
    });

    // Formulario 2: Seguridad / Contraseña
    const formPassword = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const handleUpdatePerfil = (e) => {
        e.preventDefault();
        formPerfil.put('/admin/perfil', {
            preserveScroll: true,
        });
    };

    const handleUpdatePassword = (e) => {
        e.preventDefault();
        formPassword.put('/admin/perfil/password', {
            preserveScroll: true,
            onSuccess: () => formPassword.reset(),
        });
    };

    return (
        <AdminLayout title="Mi Perfil y Seguridad">
            <Head title="Mi Perfil y Seguridad | Panel Ricardino" />

            <div className="max-w-4xl mx-auto space-y-8">
                
                {/* Cabecera */}
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-200/80 pb-6">
                    <div>
                        <div className="flex items-center gap-2 text-ricardo-teal font-mate text-xs font-bold uppercase tracking-widest mb-1">
                            <ShieldCheck className="w-4 h-4" />
                            <span>Cuenta Administrativa</span>
                        </div>
                        <h1 className="font-mate text-2xl sm:text-3xl font-bold uppercase tracking-tight text-neutral-900">
                            Mi Perfil y Seguridad
                        </h1>
                        <p className="font-literata text-xs sm:text-sm text-neutral-500 mt-1">
                            Gestiona tu información de acceso y actualiza tu contraseña periódicamente.
                        </p>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {/* BLOQUE 1: DATOS GENERALES */}
                    <div className="bg-white rounded-3xl border border-neutral-200/90 p-6 sm:p-8 shadow-2xs space-y-6 flex flex-col justify-between">
                        <div className="space-y-6">
                            <div className="flex items-center gap-2.5 border-b border-neutral-100 pb-4">
                                <div className="w-8 h-8 rounded-xl bg-teal-50 text-ricardo-teal flex items-center justify-center">
                                    <User className="w-4 h-4" />
                                </div>
                                <div>
                                    <h2 className="font-mate text-sm sm:text-base font-bold uppercase tracking-wider text-neutral-900">
                                        Información de la Cuenta
                                    </h2>
                                    <p className="font-literata text-xs text-neutral-400">
                                        Nombre para mostrar y correo de inicio de sesión.
                                    </p>
                                </div>
                            </div>

                            <form id="form-perfil" onSubmit={handleUpdatePerfil} className="space-y-4">
                                {/* Nombre */}
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Nombre Completo
                                    </label>
                                    <input
                                        type="text"
                                        value={formPerfil.data.name}
                                        onChange={(e) => formPerfil.setData('name', e.target.value)}
                                        required
                                        className="w-full rounded-xl border border-neutral-300 bg-white px-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                    />
                                    {formPerfil.errors.name && (
                                        <p className="text-xs text-ricardo-red font-medium">{formPerfil.errors.name}</p>
                                    )}
                                </div>

                                {/* Correo */}
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Correo Electrónico (Login)
                                    </label>
                                    <div className="relative">
                                        <input
                                            type="email"
                                            value={formPerfil.data.email}
                                            onChange={(e) => formPerfil.setData('email', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white pl-9 pr-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                        />
                                        <Mail className="w-4 h-4 text-neutral-400 absolute left-3 top-3" />
                                    </div>
                                    {formPerfil.errors.email && (
                                        <p className="text-xs text-ricardo-red font-medium">{formPerfil.errors.email}</p>
                                    )}
                                </div>
                            </form>
                        </div>

                        <div className="pt-4 border-t border-neutral-100 flex items-center justify-between">
                            {formPerfil.recentlySuccessful ? (
                                <span className="inline-flex items-center gap-1.5 text-xs font-mate text-emerald-600 font-bold">
                                    <CheckCircle2 className="w-3.5 h-3.5" />
                                    <span>Actualizado</span>
                                </span>
                            ) : <span></span>}

                            <button
                                type="submit"
                                form="form-perfil"
                                disabled={formPerfil.processing}
                                className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-ricardo-teal hover:bg-ricardo-teal-dark text-white font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-xs disabled:opacity-50 cursor-pointer"
                            >
                                <Save className="w-3.5 h-3.5" />
                                <span>{formPerfil.processing ? 'Guardando...' : 'Guardar Datos'}</span>
                            </button>
                        </div>
                    </div>

                    {/* BLOQUE 2: CAMBIAR CONTRASEÑA */}
                    <div className="bg-white rounded-3xl border border-neutral-200/90 p-6 sm:p-8 shadow-2xs space-y-6 flex flex-col justify-between">
                        <div className="space-y-6">
                            <div className="flex items-center gap-2.5 border-b border-neutral-100 pb-4">
                                <div className="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                    <KeyRound className="w-4 h-4" />
                                </div>
                                <div>
                                    <h2 className="font-mate text-sm sm:text-base font-bold uppercase tracking-wider text-neutral-900">
                                        Cambiar Contraseña
                                    </h2>
                                    <p className="font-literata text-xs text-neutral-400">
                                        Usa al menos 8 caracteres con números y símbolos.
                                    </p>
                                </div>
                            </div>

                            <form id="form-password" onSubmit={handleUpdatePassword} className="space-y-4">
                                {/* Contraseña Actual */}
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Contraseña Actual
                                    </label>
                                    <div className="relative">
                                        <input
                                            type="password"
                                            value={formPassword.data.current_password}
                                            onChange={(e) => formPassword.setData('current_password', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white pl-9 pr-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                        />
                                        <Lock className="w-4 h-4 text-neutral-400 absolute left-3 top-3" />
                                    </div>
                                    {formPassword.errors.current_password && (
                                        <p className="text-xs text-ricardo-red font-medium">{formPassword.errors.current_password}</p>
                                    )}
                                </div>

                                {/* Nueva Contraseña */}
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Nueva Contraseña
                                    </label>
                                    <div className="relative">
                                        <input
                                            type="password"
                                            value={formPassword.data.password}
                                            onChange={(e) => formPassword.setData('password', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white pl-9 pr-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                        />
                                        <Lock className="w-4 h-4 text-neutral-400 absolute left-3 top-3" />
                                    </div>
                                    {formPassword.errors.password && (
                                        <p className="text-xs text-ricardo-red font-medium">{formPassword.errors.password}</p>
                                    )}
                                </div>

                                {/* Confirmar Nueva Contraseña */}
                                <div className="space-y-1.5">
                                    <label className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700">
                                        Confirmar Nueva Contraseña
                                    </label>
                                    <div className="relative">
                                        <input
                                            type="password"
                                            value={formPassword.data.password_confirmation}
                                            onChange={(e) => formPassword.setData('password_confirmation', e.target.value)}
                                            required
                                            className="w-full rounded-xl border border-neutral-300 bg-white pl-9 pr-3.5 py-2.5 text-xs text-neutral-900 placeholder:text-neutral-400 focus:border-ricardo-teal focus:outline-none focus:ring-1 focus:ring-ricardo-teal transition-all font-literata"
                                        />
                                        <Lock className="w-4 h-4 text-neutral-400 absolute left-3 top-3" />
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div className="pt-4 border-t border-neutral-100 flex items-center justify-between">
                            {formPassword.recentlySuccessful ? (
                                <span className="inline-flex items-center gap-1.5 text-xs font-mate text-emerald-600 font-bold">
                                    <CheckCircle2 className="w-3.5 h-3.5" />
                                    <span>Contraseña Cambiada</span>
                                </span>
                            ) : <span></span>}

                            <button
                                type="submit"
                                form="form-password"
                                disabled={formPassword.processing}
                                className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-xs disabled:opacity-50 cursor-pointer"
                            >
                                <KeyRound className="w-3.5 h-3.5" />
                                <span>{formPassword.processing ? 'Actualizando...' : 'Actualizar Contraseña'}</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </AdminLayout>
    );
}
