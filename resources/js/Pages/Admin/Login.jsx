import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Eye, EyeOff, AlertCircle } from 'lucide-react';

export default function Login() {
    const [showPassword, setShowPassword] = useState(false);

    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/admin/login');
    };

    return (
        <div className="min-h-screen w-full relative flex items-center justify-center p-4 sm:p-6 bg-[#F6F7F6] font-literata text-neutral-900 selection:bg-ricardo-teal selection:text-white overflow-hidden">
            <Head title="Acceso Administrativo | I.E.I. N° 31756 Ricardo Palma" />

            {/* Efectos de Blur Ambiental en un solo plano (Sin imágenes) */}
            <div className="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[34rem] h-[34rem] rounded-full bg-gradient-to-tr from-teal-200/40 via-emerald-100/30 to-transparent filter blur-[100px]" />
            <div className="pointer-events-none absolute -top-20 -left-20 w-80 h-80 rounded-full bg-emerald-100/40 filter blur-[80px]" />
            <div className="pointer-events-none absolute -bottom-20 -right-20 w-80 h-80 rounded-full bg-teal-100/35 filter blur-[80px]" />

            {/* Módulo Central Glass Minimalista */}
            <main className="relative z-10 w-full max-w-[390px]">
                <div className="bg-white/70 backdrop-blur-2xl border border-white/80 rounded-3xl p-8 sm:p-10 shadow-[0_20px_60px_-15px_rgba(12,56,49,0.07),0_1px_1px_rgba(0,0,0,0.03)]">
                    
                    {/* Logotipo y Título sobrio */}
                    <div className="text-center mb-8">
                        <img 
                            src="/images/branding/logo_color.png" 
                            alt="Logo Ricardo Palma" 
                            className="h-12 w-auto mx-auto mb-3.5 drop-shadow-2xs"
                            onError={(e) => { e.currentTarget.src = '/images/logo_color.png'; }}
                        />
                        <h1 className="font-mate text-xl uppercase font-bold text-neutral-900 tracking-tight">
                            Acceso Administrativo
                        </h1>
                        <p className="font-mate text-[11px] uppercase tracking-wider text-neutral-400 font-semibold mt-1">
                            I.E.I. N° 31756 Ricardo Palma
                        </p>
                    </div>

                    {/* Alerta de Error si falla la autenticación */}
                    {(errors.email || errors.password) && (
                        <div className="mb-5 rounded-2xl bg-red-50/90 border border-red-200/80 p-3 text-xs text-ricardo-red flex items-start gap-2.5">
                            <AlertCircle className="w-4 h-4 shrink-0 mt-0.5" />
                            <div className="leading-relaxed">
                                {errors.email || errors.password}
                            </div>
                        </div>
                    )}

                    {/* Formulario */}
                    <form onSubmit={handleSubmit} className="space-y-4">
                        <div className="space-y-1.5">
                            <label 
                                htmlFor="email" 
                                className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700"
                            >
                                Correo
                            </label>
                            <input
                                type="email"
                                id="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                required
                                autoFocus
                                placeholder="admin@rpalma.edu.pe"
                                className="w-full rounded-xl border border-neutral-200/80 bg-white/80 px-3.5 py-2.5 text-sm text-neutral-900 placeholder-neutral-400 focus:bg-white focus:border-ricardo-teal focus:ring-2 focus:ring-ricardo-teal/20 outline-none transition-all font-literata"
                            />
                        </div>

                        <div className="space-y-1.5">
                            <label 
                                htmlFor="password" 
                                className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700"
                            >
                                Contraseña
                            </label>
                            <div className="relative">
                                <input
                                    type={showPassword ? 'text' : 'password'}
                                    id="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                    placeholder="••••••••"
                                    className="w-full rounded-xl border border-neutral-200/80 bg-white/80 px-3.5 py-2.5 pr-10 text-sm text-neutral-900 placeholder-neutral-400 focus:bg-white focus:border-ricardo-teal focus:ring-2 focus:ring-ricardo-teal/20 outline-none transition-all font-literata"
                                />
                                <button
                                    type="button"
                                    onClick={() => setShowPassword(!showPassword)}
                                    className="absolute right-0 top-0 bottom-0 px-3 flex items-center justify-center text-neutral-400 hover:text-neutral-700 transition-colors focus:outline-none"
                                    title="Mostrar u ocultar contraseña"
                                    tabIndex={-1}
                                >
                                    {showPassword ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                                </button>
                            </div>
                        </div>

                        <div className="flex items-center justify-between pt-0.5">
                            <label className="flex items-center gap-2 cursor-pointer select-none text-xs text-neutral-600 font-literata">
                                <input
                                    type="checkbox"
                                    checked={data.remember}
                                    onChange={(e) => setData('remember', e.target.checked)}
                                    className="rounded border-neutral-300 text-ricardo-teal focus:ring-ricardo-teal/30 h-3.5 w-3.5"
                                />
                                <span>Recordar sesión</span>
                            </label>
                        </div>

                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full rounded-xl bg-ricardo-teal hover:bg-ricardo-teal-dark text-white py-2.5 px-4 font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-xs hover:shadow active:scale-[0.99] flex items-center justify-center cursor-pointer disabled:opacity-60 mt-2"
                        >
                            <span>{processing ? 'Verificando...' : 'Iniciar Sesión'}</span>
                        </button>
                    </form>

                    {/* Pie mínimo */}
                    <div className="mt-7 pt-4 border-t border-neutral-200/50 text-center text-[11px] text-neutral-400 font-literata">
                        Chaupimarca, Pasco • &copy; {new Date().getFullYear()}
                    </div>
                </div>
            </main>
        </div>
    );
}
