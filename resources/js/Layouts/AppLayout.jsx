import React, { useState, useEffect } from 'react';
import { Link } from '@inertiajs/react';
import { Menu, X, ArrowUpRight } from 'lucide-react';

export default function AppLayout({ children }) {
    const [scrolled, setScrolled] = useState(false);
    const [mobileOpen, setMobileOpen] = useState(false);

    useEffect(() => {
        const onScroll = () => setScrolled(window.scrollY > 24);
        window.addEventListener('scroll', onScroll, { passive: true });
        return () => window.removeEventListener('scroll', onScroll);
    }, []);

    const navItems = [
        { name: 'Inicio', href: '/' },
        { name: 'Nosotros', href: '/nosotros' },
        { name: 'Docentes', href: '/docentes' },
        { name: 'Noticias', href: '/noticias' },
        { name: 'Contacto', href: '/contacto' },
    ];

    const currentPath = typeof window !== 'undefined' ? window.location.pathname : '/';

    return (
        <div className="min-h-screen bg-[#FBFBFA] text-neutral-900 flex flex-col font-literata selection:bg-ricardo-teal selection:text-white">
            {/* Header Sticky con Blur Sutil */}
            <header className={`sticky top-0 z-50 transition-all duration-300 ${
                scrolled
                    ? 'bg-white/90 backdrop-blur-md border-b border-neutral-200/80 shadow-[0_2px_12px_rgba(0,0,0,0.03)]'
                    : 'bg-[#FBFBFA] border-b border-neutral-200/40'
            }`}>
                <div className="mx-auto max-w-7xl px-5 sm:px-8">
                    <div className="flex h-18 sm:h-20 items-center justify-between">
                        {/* Identidad Institucional */}
                        <Link href="/" className="flex items-center gap-3.5 group">
                            <img
                                src="/images/branding/logo_color.png"
                                alt="I.E.I. Ricardo Palma"
                                className="h-11 sm:h-12 w-auto transition-transform duration-300 group-hover:scale-105"
                                onError={(e) => { e.currentTarget.src = '/images/logo_color.png'; }}
                            />
                            <div className="flex flex-col border-l border-neutral-200 pl-3.5">
                                <span className="font-mate text-sm sm:text-base font-bold tracking-tight text-neutral-900 uppercase leading-none">
                                    I.E.I. N.° 31756
                                </span>
                                <span className="font-mate text-xs text-ricardo-teal font-semibold tracking-wider uppercase mt-1 leading-none">
                                    Ricardo Palma
                                </span>
                            </div>
                        </Link>

                        {/* Navegación Desktop */}
                        <nav className="hidden md:flex items-center gap-8 font-mate text-xs lg:text-[13px] uppercase tracking-wider">
                            {navItems.map((item) => {
                                const isActive = currentPath === item.href || (item.href !== '/' && currentPath.startsWith(item.href));
                                return (
                                    <Link
                                        key={item.name}
                                        href={item.href}
                                        className={`relative py-1 transition-colors duration-200 ${
                                            isActive
                                                ? 'text-ricardo-teal font-bold'
                                                : 'text-neutral-600 hover:text-neutral-950 font-medium'
                                        }`}
                                    >
                                        {item.name}
                                        {isActive && (
                                            <span className="absolute -bottom-1 left-0 right-0 h-[2px] bg-ricardo-red"></span>
                                        )}
                                    </Link>
                                );
                            })}
                        </nav>

                        {/* Botón Móvil */}
                        <button
                            onClick={() => setMobileOpen(!mobileOpen)}
                            className="md:hidden p-2 text-neutral-700 hover:text-neutral-950 transition-colors"
                            aria-label="Alternar navegación"
                        >
                            {mobileOpen ? <X className="w-5 h-5" /> : <Menu className="w-5 h-5" />}
                        </button>
                    </div>
                </div>

                {/* Menú Desplegable Móvil */}
                {mobileOpen && (
                    <div className="md:hidden border-t border-neutral-200 bg-white px-6 py-5 space-y-3 font-mate text-xs uppercase tracking-wider">
                        {navItems.map((item) => {
                            const isActive = currentPath === item.href;
                            return (
                                <Link
                                    key={item.name}
                                    href={item.href}
                                    onClick={() => setMobileOpen(false)}
                                    className={`block py-1.5 ${
                                        isActive
                                            ? 'text-ricardo-teal font-bold border-l-2 border-ricardo-red pl-2.5'
                                            : 'text-neutral-600 hover:text-neutral-900'
                                    }`}
                                >
                                    {item.name}
                                </Link>
                            );
                        })}
                    </div>
                )}
            </header>

            {/* Contenido */}
            <main className="flex-grow">
                {children}
            </main>

            {/* Barra Bicolor Institucional Superior del Footer */}
            <div className="flex h-1.5 w-full">
                <span className="w-2/3 bg-ricardo-teal"></span>
                <span className="w-1/3 bg-ricardo-red"></span>
            </div>

            {/* Footer Institucional en Pizarra Neutra y Serena */}
            <footer className="bg-[#1E2327] text-white">
                <div className="mx-auto max-w-7xl px-5 sm:px-8 py-14 sm:py-16">
                    <div className="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-8 pb-12 border-b border-white/10">
                        {/* Bloque Identidad */}
                        <div className="md:col-span-5 space-y-4">
                            <img
                                src="/images/branding/logo_original_blanco.png"
                                alt="I.E.I. Ricardo Palma"
                                className="h-14 w-auto object-contain"
                                onError={(e) => { e.currentTarget.src = '/images/logo_original_blanco.png'; }}
                            />
                            <p className="font-mate text-base text-neutral-100 uppercase tracking-wide leading-snug">
                                Institución Educativa Integrada N.° 31756<br />
                                “Ricardo Palma”
                            </p>
                            <p className="text-xs text-neutral-300 font-literata max-w-sm leading-relaxed">
                                Educación Inicial, Primaria y Secundaria al servicio de las familias de Chaupimarca y Cerro de Pasco.
                            </p>
                        </div>

                        {/* Bloque Redes Sociales con Logos Oficiales y Color de Marca en Hover */}
                        <div className="md:col-span-3 space-y-4">
                            <span className="font-mate text-xs text-ricardo-yellow uppercase tracking-widest block font-bold">
                                Canales Oficiales
                            </span>
                            <div className="flex flex-col gap-3 text-xs font-system text-neutral-200">
                                
                                {/* Facebook */}
                                <a
                                    href="https://www.facebook.com/ricardinosemprendeores"
                                    target="_blank"
                                    rel="noreferrer"
                                    className="group inline-flex items-center gap-3 transition-colors hover:text-white"
                                >
                                    <span className="w-7 h-7 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center text-white/80 transition-colors group-hover:bg-[#1877F2] group-hover:border-[#1877F2] group-hover:text-white">
                                        <svg className="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </span>
                                    <span>Facebook Institucional</span>
                                    <ArrowUpRight className="w-3.5 h-3.5 text-neutral-400 group-hover:text-white transition-colors ml-auto md:ml-0" />
                                </a>

                                {/* WhatsApp */}
                                <a
                                    href="https://wa.me/51921896330"
                                    target="_blank"
                                    rel="noreferrer"
                                    className="group inline-flex items-center gap-3 transition-colors hover:text-white"
                                >
                                    <span className="w-7 h-7 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center text-white/80 transition-colors group-hover:bg-[#25D366] group-hover:border-[#25D366] group-hover:text-white">
                                        <svg className="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                        </svg>
                                    </span>
                                    <span>WhatsApp de Atención</span>
                                    <ArrowUpRight className="w-3.5 h-3.5 text-neutral-400 group-hover:text-white transition-colors ml-auto md:ml-0" />
                                </a>

                                {/* YouTube */}
                                <a
                                    href="https://www.youtube.com/@ricardopalma4155"
                                    target="_blank"
                                    rel="noreferrer"
                                    className="group inline-flex items-center gap-3 transition-colors hover:text-white"
                                >
                                    <span className="w-7 h-7 rounded-lg bg-white/10 border border-white/15 flex items-center justify-center text-white/80 transition-colors group-hover:bg-[#FF0000] group-hover:border-[#FF0000] group-hover:text-white">
                                        <svg className="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                        </svg>
                                    </span>
                                    <span>Canal de YouTube</span>
                                    <ArrowUpRight className="w-3.5 h-3.5 text-neutral-400 group-hover:text-white transition-colors ml-auto md:ml-0" />
                                </a>

                            </div>
                        </div>

                        {/* Bloque Ubicación con Contenedor Google Maps Pulcro */}
                        <div className="md:col-span-4 space-y-3">
                            <span className="font-mate text-xs text-ricardo-yellow uppercase tracking-widest block font-bold">
                                Ubicación
                            </span>
                            <p className="text-xs text-neutral-300 font-literata">
                                Barrio La Esperanza, Chaupimarca - Pasco, Perú.
                            </p>
                            
                            {/* Contenedor Limpio y Minimalista de Google Maps */}
                            <div className="mt-3 rounded-xl overflow-hidden border border-white/15 bg-black/40 aspect-[16/9] max-h-36">
                                <a
                                    href="https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9"
                                    target="_blank"
                                    rel="noreferrer"
                                    className="block w-full h-full group"
                                    title="Ver en Google Maps"
                                >
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1964.8140410425316!2d-76.25752934177405!3d-10.68656687258902!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910813f8373e351d%3A0x6bfe73f8ff169ea2!2sI.E.I%20N%C2%B0%2031756%20%22Ricardo%20Palma%22!5e0!3m2!1ses!2spe!4v1700000000000!5m2!1ses!2spe"
                                        width="100%"
                                        height="100%"
                                        style={{ border: 0 }}
                                        allowFullScreen=""
                                        loading="lazy"
                                        referrerPolicy="no-referrer-when-downgrade"
                                        className="h-full w-full pointer-events-none opacity-85 group-hover:opacity-100 transition-opacity"
                                        title="Mapa escolar"
                                    />
                                </a>
                            </div>
                        </div>
                    </div>

                    <div className="pt-8 flex flex-col sm:flex-row items-center justify-between text-[11px] font-system text-neutral-400 gap-2">
                        <p>© {new Date().getFullYear()} I.E.I. N.° 31756 Ricardo Palma</p>
                        <p>Cerro de Pasco, Perú</p>
                    </div>
                </div>
            </footer>
        </div>
    );
}
