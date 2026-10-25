<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración') | I.E.I. N° 31756 Ricardo Palma</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #fafbfa;
            --surface-color: #ffffff;
            --border-color: #e5e7eb;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --primary-btn: #0f9d58;
            --primary-btn-hover: #0b7a44;
            --danger-btn: #dc2626;
            --danger-btn-hover: #b91c1c;
            --sidebar-width: 250px;
            --brand-green: #119b8c;
            --font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            border-radius: 0 !important;
        }

        body {
            font-family: var(--font-family);
            background: linear-gradient(135deg, #fffdf8 0%, #f4fbfa 100%);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* BARRA LATERAL (SIDEBAR) */
        .admin-sidebar {
            width: var(--sidebar-width);
            background-color: var(--surface-color);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background-color: #f0fdf4;
            border: 1px solid #dcfce7;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-icon img {
            width: 26px;
            height: 26px;
            object-fit: contain;
        }

        .brand-text h1 {
            font-size: 14px;
            font-weight: 700;
            line-height: 1.2;
            color: var(--text-primary);
        }

        .brand-text span {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* NAVEGACIÓN LATERAL */
        .sidebar-nav {
            padding: 16px 0;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 24px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.15s ease;
        }

        .nav-item:hover {
            background-color: #f9fafb;
            color: var(--text-primary);
        }

        .nav-item.active {
            background-color: #f0fdf4;
            color: var(--brand-green);
            border-left-color: var(--brand-green);
            font-weight: 600;
        }

        /* PIE DE BARRA LATERAL (Cuentas al fondo) */
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            gap: 8px;
            background: #fafbfc;
        }

        .btn-sidebar {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-sidebar:hover {
            background: #f3f4f6;
        }

        .btn-sidebar.active-account {
            background-color: #f0fdf4;
            border-color: #bbf7d0;
            color: var(--brand-green);
            font-weight: 600;
        }

        /* CONTENIDO PRINCIPAL */
        .admin-main {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* TOPBAR SUPERIOR */
        .topbar {
            background-color: var(--surface-color);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 32px;
        }

        .topbar-title {
            font-size: 14px;
            color: var(--text-secondary);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 500;
        }

        .user-badge {
            background: #f3f4f6;
            padding: 4px 10px;
            border: 1px solid var(--border-color);
            font-size: 12px;
            color: var(--text-primary);
        }

        /* CONTENEDOR DE PÁGINA */
        .admin-container {
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
            padding: 32px;
            flex-grow: 1;
        }

        /* HEADER DE SECCIÓN */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .section-title h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--text-primary);
        }

        .section-title p {
            color: var(--text-secondary);
            font-size: 13px;
        }

        .btn-primary {
            background-color: var(--primary-btn);
            color: white;
            border: 1px solid var(--primary-btn);
            padding: 10px 18px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-primary:hover {
            background-color: var(--primary-btn-hover);
            border-color: var(--primary-btn-hover);
        }

        .btn-outline {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 8px 16px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .btn-outline:hover {
            background-color: #f9fafb;
        }

        /* ALERTAS */
        .alert-success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #b91c1c;
            padding: 12px 16px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        /* ICONOS SVG */
        .icon {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                position: static;
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
            }
            body {
                flex-direction: column;
            }
            .admin-main {
                margin-left: 0;
            }
            .admin-container {
                padding: 20px 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- BARRA LATERAL (SIDEBAR) -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <img src="{{ asset('images/logo_color.png') }}" alt="Logo">
            </div>
            <div class="brand-text">
                <h1>Panel Administrativo</h1>
                <span>I.E.I. Ricardo Palma</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('admin.noticias.index') }}" class="nav-item {{ request()->routeIs('admin.noticias.*') ? 'active' : '' }}">
                <svg class="icon" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                Noticias
            </a>

            <a href="{{ route('admin.galeria.index') }}" class="nav-item {{ request()->routeIs('admin.galeria.*') ? 'active' : '' }}">
                <svg class="icon" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="0" ry="0"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Galería
            </a>

            <a href="{{ route('admin.docentes.index') }}" class="nav-item {{ request()->routeIs('admin.docentes.*') ? 'active' : '' }}">
                <svg class="icon" viewBox="0 0 24 24"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                Docentes
            </a>

            <a href="{{ route('admin.mensajes.index') }}" class="nav-item {{ request()->routeIs('admin.mensajes.*') ? 'active' : '' }}">
                <svg class="icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Mensajes
            </a>
        </nav>

        <!-- SECCIÓN INFERIOR: GESTIÓN DE ACCESOS Y CIERRE -->
        <div class="sidebar-footer">
            {{-- Botón de Gestión de Cuentas al fondo de la barra --}}
            <a href="{{ route('admin.usuarios.index') }}" class="btn-sidebar {{ request()->routeIs('admin.usuarios.*') ? 'active-account' : '' }}">
                <svg class="icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                Cuentas de Acceso
            </a>

            <a href="{{ route('home') }}" target="_blank" class="btn-sidebar">
                <svg class="icon" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Ver sitio público
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-sidebar" style="color: var(--danger-btn); border-color: #fee2e2;">
                    <svg class="icon" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- ÁREA PRINCIPAL -->
    <div class="admin-main">
        <header class="topbar">
            <div class="topbar-title">
                Colegio I.E.I. N° 31756 Ricardo Palma • Sistema de Gestión de Contenidos
            </div>
            <div class="topbar-user">
                <span class="user-badge">{{ auth()->user()->name ?? 'Administrador' }}</span>
            </div>
        </header>

        <main class="admin-container">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
