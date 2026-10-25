import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { LogIn, Eye, EyeOff, AlertCircle, ArrowLeft } from 'lucide-react';

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
        <div className="min-h-screen bg-[#FBFBFA] font-literata text-neutral-900 flex flex-col justify-center items-center p-5 selection:bg-ricardo-teal selection:text-white relative overflow-hidden">
            <Head title="Acceso Administrativo | I.E.I. N° 31756 Ricardo Palma" />

            {/* Velo institucional superior */}
            <div className="pointer-events-none absolute inset-x-0 top-0 h-80 bg-gradient-to-b from-[#0C3831]/10 via-[#0C3831]/5 to-transparent"></div>

            <main className="relative z-10 w-full max-w-md bg-white rounded-3xl border border-neutral-200/90 p-8 sm:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                
                {/* Encabezado Institucional */}
                <div className="text-center space-y-4 mb-8">
                    <img 
                        src="/images/branding/logo_color.png" 
                        alt="Logo Ricardo Palma" 
                        className="h-16 w-auto mx-auto drop-shadow-xs transition-transform duration-300 hover:scale-105"
                        onError={(e) => { e.currentTarget.src = '/images/logo_color.png'; }}
                    />
                    
                    <div className="space-y-1.5">
                        <span className="font-mate text-xs uppercase tracking-widest text-ricardo-teal font-semibold block">
                            I.E.I. N° 31756 Ricardo Palma
                        </span>
                        <h1 className="font-mate text-2xl sm:text-3xl text-neutral-900 uppercase font-bold tracking-tight">
                            Acceso Administrativo
                        </h1>
                        <div className="flex h-1 w-16 mx-auto pt-1">
                            <span className="w-2/3 bg-ricardo-teal"></span>
                            <span className="w-1/3 bg-ricardo-red"></span>
                        </div>
                    </div>

                    <p className="text-xs sm:text-sm text-neutral-500 font-literata leading-relaxed">
                        Ingresa tus credenciales para administrar contenidos, docentes y comunicados escolares.
                    </p>
                </div>

                {/* Mensaje de Error */}
                {(errors.email || errors.password) && (
                    <div className="mb-6 rounded-2xl bg-red-50 border border-red-200/80 p-4 text-xs sm:text-sm text-ricardo-red flex items-start gap-3 shadow-xs">
                        <AlertCircle className="w-5 h-5 shrink-0 text-ricardo-red mt-0.5" />
                        <div className="leading-relaxed">
                            {errors.email || errors.password}
                        </div>
                    </div>
                )}

                {/* Formulario */}
                <form onSubmit={handleSubmit} className="space-y-5">
                    <div className="space-y-1.5">
                        <label 
                            htmlFor="email" 
                            className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700"
                        >
                            Correo Electrónico
                        </label>
                        <input
                            type="email"
                            id="email"
                            value={data.email}
                            onChange={(e) => setData('email', e.target.value)}
                            required
                            autoFocus
                            placeholder="admin@rpalma.edu.pe"
                            className="w-full rounded-xl border border-neutral-200/90 bg-[#FBFBFA] px-4 py-3 text-sm text-neutral-900 placeholder-neutral-400 focus:bg-white focus:border-ricardo-teal focus:ring-2 focus:ring-ricardo-teal/20 outline-none transition-all"
                        />
                    </div>

                    <div className="space-y-1.5">
                        <label 
                            htmlFor="password" 
                            className="block font-mate text-xs uppercase tracking-wider font-semibold text-neutral-700"
                        >
                            Contraseña de Acceso
                        </label>
                        <div className="relative">
                            <input
                                type={showPassword ? 'text' : 'password'}
                                id="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                required
                                placeholder="••••••••"
                                className="w-full rounded-xl border border-neutral-200/90 bg-[#FBFBFA] px-4 py-3 pr-11 text-sm text-neutral-900 placeholder-neutral-400 focus:bg-white focus:border-ricardo-teal focus:ring-2 focus:ring-ricardo-teal/20 outline-none transition-all"
                            />
                            <button
                                type="button"
                                onClick={() => setShowPassword(!showPassword)}
                                className="absolute right-0 top-0 bottom-0 px-3.5 flex items-center justify-center text-neutral-400 hover:text-neutral-700 transition-colors focus:outline-none"
                                title="Mostrar u ocultar contraseña"
                            >
                                {showPassword ? <EyeOff className="w-4 h-4" /> : <Eye className="w-4 h-4" />}
                            </button>
                        </div>
                    </div>

                    <div className="flex items-center justify-between pt-1">
                        <label className="flex items-center gap-2 cursor-pointer select-none text-xs text-neutral-600 font-literata">
                            <input
                                type="checkbox"
                                checked={data.remember}
                                onChange={(e) => setData('remember', e.target.checked)}
                                className="rounded border-neutral-300 text-ricardo-teal focus:ring-ricardo-teal/30 h-4 w-4"
                            />
                            <span>Mantener sesión iniciada</span>
                        </label>
                    </div>

                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full rounded-xl bg-ricardo-teal hover:bg-ricardo-teal-dark text-white py-3.5 px-4 font-mate text-xs uppercase tracking-wider font-bold transition-all shadow-sm hover:shadow active:scale-[0.99] flex items-center justify-center gap-2 cursor-pointer disabled:opacity-60"
                    >
                        <LogIn className="w-4 h-4" />
                        <span>{processing ? 'Verificando...' : 'Ingresar al Sistema'}</span>
                    </button>
                </form>

                {/* Pie institucional */}
                <div className="mt-8 pt-6 border-t border-neutral-200/60 text-center">
                    <Link
                        href="/" 
                        className="inline-flex items-center gap-1.5 font-mate text-xs uppercase tracking-wider text-neutral-500 hover:text-ricardo-teal transition-colors font-semibold"
                    >
                        <ArrowLeft className="w-3.5 h-3.5" />
                        <span>Volver al sitio web institucional</span>
                    </Link>
                </div>

            </main>

            <div className="mt-6 text-center text-xs text-neutral-400 font-literata">
                Chaupimarca, Cerro de Pasco • &copy; {new Date().getFullYear()} I.E.I. N° 31756 Ricardo Palma
            </div>
        </div>
    );
}
