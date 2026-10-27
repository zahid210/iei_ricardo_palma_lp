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
    User,
    Calendar,
    ChevronRight
} from 'lucide-react';

export default function AdminLayout({ title, children }) {
    const { auth, flash, pendientesContacto } = usePage().props;
    const { url } = usePage();
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [flashVisible, setFlashVisible] = useState(true);

    const currentUrl = (url || '').split('?')[0];

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

    const formattedDate = new Intl.DateTimeFormat('es-PE', { 
        weekday: 'short', 
        day: 'numeric', 
        month: 'short', 
        year: 'numeric' 
    }).format(new Date());

    return (
        <div className="min-h-screen bg-[#FBFBFA] text-neutral-900 flex font-literata selection:bg-ricardo-teal selection:text-white">
            <Head title={title ? `${title} | Panel Ricardino` : 'Panel de Administración'} />

            {/* SIDEBAR LATERAL */}
            <aside 
                className={`fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-neutral-200/90 flex flex-col transition-transform duration-300 md:translate-x-0 ${
                    sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'
                }`}
            >
                {/* Cabecera Sidebar */}
                <div className="h-18 px-5 border-b border-neutral-200/70 flex items-center justify-between">
                    <Link href="/admin/noticias" className="flex items-center gap-3 group">
                        <img 
                            src="/images/branding/logo_color.png" 
                            alt="Logo Ricardo Palma" 
                            className="h-10 w-auto transition-transform duration-300 group-hover:scale-105"
                            onError={(e) => { e.currentTarget.src = '/images/logo_color.png'; }}
                        />
                        <div className="min-w-0">
                            <h1 className="font-mate text-xs font-bold uppercase tracking-wider text-neutral-900 leading-tight truncate">
                                I.E.I. Ricardo Palma
                            </h1>
                            <span className="font-mate text-[11px] text-ricardo-teal font-semibold tracking-wider block">
                                Panel del Colegio
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

                {/* Navegación Principal */}
                <nav className="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
                    <div className="px-3 pb-2 text-[10px] font-mate uppercase tracking-widest text-neutral-400 font-bold">
                        Módulos de Gestión
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
                                        ? 'bg-[#0C3831] text-white shadow-xs'
                                        : 'text-neutral-600 hover:bg-neutral-100/80 hover:text-neutral-900'
                                }`}
                            >
                                <div className="flex items-center gap-3">
                                    <Icon className={`w-4 h-4 shrink-0 ${item.active ? 'text-emerald-300' : 'text-neutral-400'}`} />
                                    <span>{item.name}</span>
                                </div>
                                {item.badge && (
                                    <span className="bg-ricardo-red text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-2xs animate-pulse">
                                        {item.badge}
                                    </span>
                                )}
                            </Link>
                        );
                    })}
                </nav>

                {/* Pie del Sidebar */}
                <div className="p-3.5 border-t border-neutral-200/70 space-y-2 bg-[#FBFBFA]/60">
                    <a
                        href="/"
                        target="_blank"
                        rel="noreferrer"
                        className="flex items-center justify-center gap-2 w-full py-2.5 px-3 rounded-xl border border-neutral-200 bg-white hover:bg-neutral-50 text-neutral-700 text-xs font-mate uppercase tracking-wider font-semibold transition-all shadow-2xs"
                    >
                        <ExternalLink className="w-3.5 h-3.5 text-neutral-500" />
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
            <div className="flex-1 min-w-0 flex flex-col md:pl-64 min-h-screen">
                
                {/* Topbar */}
                <header className="h-18 bg-white border-b border-neutral-200/80 px-5 sm:px-8 flex items-center justify-between sticky top-0 z-20 shadow-2xs">
                    <div className="flex items-center gap-3">
                        <button
                            onClick={() => setSidebarOpen(true)}
                            className="md:hidden text-neutral-600 hover:text-neutral-900 p-2 -ml-2 rounded-lg hover:bg-neutral-100"
                            aria-label="Abrir menú"
                        >
                            <Menu className="w-5 h-5" />
                        </button>
                        <div>
                            <div className="flex items-center gap-1.5 text-xs text-neutral-400 font-mate uppercase tracking-wider">
                                <span>Panel</span>
                                <ChevronRight className="w-3 h-3 text-neutral-300" />
                                <span className="text-ricardo-teal font-semibold">{title || 'General'}</span>
                            </div>
                            <h2 className="font-mate text-sm sm:text-base font-bold text-neutral-900 uppercase tracking-tight">
                                {title || 'Panel de Administración'}
                            </h2>
                        </div>
                    </div>

                    <div className="flex items-center gap-3 sm:gap-4">
                        {/* Fecha actual */}
                        <div className="hidden lg:flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-neutral-50 border border-neutral-200/60 text-neutral-500 text-xs font-literata capitalize">
                            <Calendar className="w-3.5 h-3.5 text-neutral-400" />
                            <span>{formattedDate}</span>
                        </div>

                        {/* Perfil del Usuario */}
                        <div className="flex items-center gap-3 pl-2 sm:border-l sm:border-neutral-200/80">
                            <div className="hidden sm:flex flex-col text-right">
                                <span className="text-xs font-semibold text-neutral-900 leading-tight">
                                    {auth?.user?.name || 'Administrador'}
                                </span>
                                <span className="font-mate text-[11px] text-neutral-400 uppercase font-bold tracking-wider">
                                    Dirección / Admin
                                </span>
                            </div>
                            <div className="w-8 h-8 rounded-lg bg-[#0C3831] text-white flex items-center justify-center font-mate font-bold text-xs shadow-xs">
                                {auth?.user?.name ? auth.user.name.charAt(0).toUpperCase() : <User className="w-4 h-4" />}
                            </div>
                        </div>
                    </div>
                </header>

                {/* Contenido Principal */}
                <main className="flex-1 p-5 sm:p-8 max-w-7xl w-full mx-auto space-y-6">
                    
                    {/* Alertas Flash de Éxito */}
                    {flash?.success && flashVisible && (
                        <div className="rounded-2xl bg-emerald-50 border border-emerald-200/90 p-4 text-xs sm:text-sm text-emerald-900 flex items-center justify-between gap-3 shadow-xs">
                            <div className="flex items-center gap-3">
                                <CheckCircle2 className="w-5 h-5 shrink-0 text-emerald-600" />
                                <span className="font-medium">{flash.success}</span>
                            </div>
                            <button 
                                onClick={() => setFlashVisible(false)}
                                className="text-emerald-700 hover:text-emerald-900 p-1"
                            >
                                <X className="w-4 h-4" />
                            </button>
                        </div>
                    )}

                    {/* Alertas Flash de Error */}
                    {flash?.error && flashVisible && (
                        <div className="rounded-2xl bg-red-50 border border-red-200/90 p-4 text-xs sm:text-sm text-ricardo-red flex items-center justify-between gap-3 shadow-xs">
                            <div className="flex items-center gap-3">
                                <AlertCircle className="w-5 h-5 shrink-0 text-ricardo-red" />
                                <span className="font-medium">{flash.error}</span>
                            </div>
                            <button 
                                onClick={() => setFlashVisible(false)}
                                className="text-red-700 hover:text-red-900 p-1"
                            >
                                <X className="w-4 h-4" />
                            </button>
                        </div>
                    )}

                    {children}
                </main>
            </div>
        </div>
    );
}
