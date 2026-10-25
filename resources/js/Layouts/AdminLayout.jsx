import React, { useState } from 'react';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { 
    Newspaper, 
    Image as ImageIcon, 
    GraduationCap, 
    Mail, 
    ExternalLink, 
    LogOut, 
    Menu, 
    X, 
    CheckCircle2, 
    AlertCircle, 
    ChevronRight,
    User
} from 'lucide-react';

export default function AdminLayout({ title, children }) {
    const { auth, flash, pendientesContacto } = usePage().props;
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [confirmModal, setConfirmModal] = useState({ open: false, title: '', message: '', onConfirm: null });

    const currentUrl = typeof window !== 'undefined' ? window.location.pathname : '';

    const navItems = [
        { name: 'Noticias', href: '/admin/noticias', icon: Newspaper, active: currentUrl.startsWith('/admin/noticias') },
        { name: 'Galería', href: '/admin/galeria', icon: ImageIcon, active: currentUrl.startsWith('/admin/galeria') },
        { name: 'Docentes', href: '/admin/docentes', icon: GraduationCap, active: currentUrl.startsWith('/admin/docentes') },
        { 
            name: 'Mensajes', 
            href: '/admin/mensajes', 
            icon: Mail, 
            active: currentUrl.startsWith('/admin/mensajes'),
            badge: pendientesContacto > 0 ? pendientesContacto : null 
        },
    ];

    const handleLogout = (e) => {
        e.preventDefault();
        router.post('/admin/logout');
    };

    return (
        <div className="min-h-screen bg-[#F8F9F8] text-neutral-900 flex font-literata selection:bg-ricardo-teal selection:text-white">
            <Head title={title ? `${title} | Panel Ricardino` : 'Panel de Administración'} />

            {/* BARRA LATERAL (SIDEBAR) */}
            <aside 
                className={`fixed inset-y-0 left-0 z-40 w-68 bg-white border-r border-neutral-200/90 flex flex-col transition-transform duration-300 md:translate-x-0 ${
                    sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'
                }`}
            >
                {/* Cabecera Sidebar */}
                <div className="h-20 px-6 border-b border-neutral-200/80 flex items-center justify-between">
                    <Link href="/admin/noticias" className="flex items-center gap-3 group">
                        <img 
                            src="/images/branding/logo_color.png" 
                            alt="Logo" 
                            className="h-10 w-auto transition-transform duration-300 group-hover:scale-105"
                            onError={(e) => { e.currentTarget.src = '/images/logo_color.png'; }}
                        />
                        <div>
                            <h1 className="font-mate text-xs font-bold uppercase tracking-wider text-neutral-900 leading-tight">
                                Panel Ricardino
                            </h1>
                            <span className="font-mate text-[11px] text-ricardo-teal font-semibold tracking-wider block">
                                I.E.I. N° 31756
                            </span>
                        </div>
                    </Link>

                    <button 
                        onClick={() => setSidebarOpen(false)} 
                        className="md:hidden text-neutral-400 hover:text-neutral-800 p-1.5 rounded-lg hover:bg-neutral-100"
                        aria-label="Cerrar menú"
                    >
                        <X className="w-5 h-5" />
                    </button>
                </div>

                {/* Navegación */}
                <nav className="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                    <div className="px-3 pb-2 text-[10px] font-mate uppercase tracking-widest text-neutral-400 font-bold">
                        Gestión de Contenidos
                    </div>

                    {navItems.map((item) => {
                        const Icon = item.icon;
                        return (
                            <Link
                                key={item.name}
                                href={item.href}
                                onClick={() => setSidebarOpen(false)}
                                className={`flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-mate uppercase tracking-wider font-semibold transition-all ${
                                    item.active
                                        ? 'bg-teal-50 text-ricardo-teal border border-teal-100/80 shadow-2xs'
                                        : 'text-neutral-600 hover:bg-neutral-50 hover:text-neutral-900'
                                }`}
                            >
                                <div className="flex items-center gap-3">
                                    <Icon className={`w-4 h-4 shrink-0 ${item.active ? 'text-ricardo-teal' : 'text-neutral-400'}`} />
                                    <span>{item.name}</span>
                                </div>
                                {item.badge && (
                                    <span className="bg-ricardo-red text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-2xs">
                                        {item.badge}
                                    </span>
                                )}
                            </Link>
                        );
                    })}
                </nav>

                {/* Pie del Sidebar: Ver sitio público y Logout */}
                <div className="p-4 border-t border-neutral-200/80 space-y-2 bg-[#FBFBFA]">
                    <a
                        href="/"
                        target="_blank"
                        rel="noreferrer"
                        className="flex items-center justify-center gap-2 w-full py-2.5 px-3 rounded-xl border border-neutral-200/90 bg-white hover:bg-neutral-50 text-neutral-700 text-xs font-mate uppercase tracking-wider font-semibold transition-all shadow-2xs"
                    >
                        <ExternalLink className="w-3.5 h-3.5" />
                        <span>Ver Sitio Web</span>
                    </a>

                    <button
                        onClick={handleLogout}
                        className="flex items-center justify-center gap-2 w-full py-2.5 px-3 rounded-xl border border-red-200/80 bg-red-50/70 hover:bg-red-100 text-ricardo-red text-xs font-mate uppercase tracking-wider font-bold transition-all cursor-pointer"
                    >
                        <LogOut className="w-3.5 h-3.5" />
                        <span>Cerrar Sesión</span>
                    </button>
                </div>
            </aside>

            {/* Backdrop en pantallas móviles */}
            {sidebarOpen && (
                <div 
                    onClick={() => setSidebarOpen(false)} 
                    className="fixed inset-0 bg-neutral-900/40 backdrop-blur-xs z-30 md:hidden"
                />
            )}

            {/* ÁREA DE CONTENIDO */}
            <div className="flex-1 min-w-0 flex flex-col md:pl-68 min-h-screen">
                
                {/* Topbar */}
                <header className="h-20 bg-white border-b border-neutral-200/80 px-5 sm:px-8 flex items-center justify-between sticky top-0 z-20 shadow-2xs">
                    <div className="flex items-center gap-3">
                        <button
                            onClick={() => setSidebarOpen(true)}
                            className="md:hidden text-neutral-600 hover:text-neutral-900 p-2 -ml-2 rounded-lg hover:bg-neutral-100"
                            aria-label="Abrir menú"
                        >
                            <Menu className="w-5 h-5" />
                        </button>
                        <div>
                            <h2 className="font-mate text-base font-bold text-neutral-900 uppercase tracking-tight">
                                {title || 'Panel de Administración'}
                            </h2>
                            <span className="hidden sm:block text-xs text-neutral-400 font-literata">
                                I.E.I. N° 31756 Ricardo Palma • Chaupimarca, Pasco
                            </span>
                        </div>
                    </div>

                    <div className="flex items-center gap-3">
                        <div className="hidden sm:flex flex-col text-right">
                            <span className="text-xs font-semibold text-neutral-900 leading-tight">
                                {auth?.user?.name || 'Administrador'}
                            </span>
                            <span className="font-mate text-[11px] text-ricardo-teal uppercase font-bold tracking-wider">
                                Dirección / Admin
                            </span>
                        </div>
                        <div className="w-9 h-9 rounded-xl bg-teal-50 border border-teal-200/80 flex items-center justify-center text-ricardo-teal font-mate font-bold text-sm shadow-2xs">
                            {auth?.user?.name ? auth.user.name.charAt(0).toUpperCase() : <User className="w-4 h-4" />}
                        </div>
                    </div>
                </header>

                {/* Contenido Principal */}
                <main className="flex-1 p-5 sm:p-8 max-w-7xl w-full mx-auto">
                    
                    {/* Alertas Flash de Éxito */}
                    {flash?.success && (
                        <div className="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200/80 p-4 text-xs sm:text-sm text-emerald-900 flex items-start gap-3 shadow-xs">
                            <CheckCircle2 className="w-5 h-5 shrink-0 text-emerald-600 mt-0.5" />
                            <div className="leading-relaxed font-medium">
                                {flash.success}
                            </div>
                        </div>
                    )}

                    {/* Alertas Flash de Error */}
                    {flash?.error && (
                        <div className="mb-6 rounded-2xl bg-red-50 border border-red-200/80 p-4 text-xs sm:text-sm text-ricardo-red flex items-start gap-3 shadow-xs">
                            <AlertCircle className="w-5 h-5 shrink-0 text-ricardo-red mt-0.5" />
                            <div className="leading-relaxed font-medium">
                                {flash.error}
                            </div>
                        </div>
                    )}

                    {children}
                </main>
            </div>
        </div>
    );
}
