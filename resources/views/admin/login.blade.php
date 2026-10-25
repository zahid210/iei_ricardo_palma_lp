<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo | I.E.I. N° 31756 Ricardo Palma</title>
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
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            padding: 36px 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .login-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-icon {
            width: 52px;
            height: 52px;
            background-color: #f0fdf4;
            border: 1px solid #dcfce7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-green);
            margin-bottom: 14px;
        }

        .brand-icon img {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .login-header h1 {
            font-size: 19px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .login-header span {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .password-wrapper {
            position: relative;
            display: flex;
            align-items: stretch;
            width: 100%;
        }

        .form-input {
            width: 100%;
            padding: 10px 12px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text-primary);
            background-color: #fafafa;
            border: 1px solid var(--border-color);
            outline: none;
            transition: border-color 0.2s, background-color 0.2s;
        }

        .password-wrapper .form-input {
            padding-right: 42px;
        }

        .form-input:focus {
            background-color: #ffffff;
            border-color: var(--brand-green);
        }

        .toggle-password {
            position: absolute;
            right: 1px;
            top: 1px;
            bottom: 1px;
            width: 40px;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s, background-color 0.15s;
        }

        .toggle-password:hover {
            color: var(--text-primary);
            background-color: #f3f4f6;
        }

        .toggle-password:focus {
            outline: 2px solid var(--brand-green);
            outline-offset: -2px;
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 22px;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background-color: var(--primary-btn);
            color: #ffffff;
            border: 1px solid var(--primary-btn);
            padding: 11px 16px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .btn-submit:hover {
            background-color: var(--primary-btn-hover);
            border-color: var(--primary-btn-hover);
        }

        .error-message {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #b91c1c;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .login-footer {
            margin-top: 24px;
            text-align: center;
            font-size: 12px;
            color: var(--text-secondary);
            border-top: 1px solid var(--border-color);
            padding-top: 16px;
        }

        .login-footer a {
            color: var(--brand-green);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .icon {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>
</head>
<body>

    <main class="login-box">
        <div class="login-header">
            <div class="brand-icon">
                <img src="{{ asset('images/branding/logo_color.png') }}" alt="Logo" onerror="this.src='{{ asset('images/logo_color.png') }}';">
            </div>
            <h1>Panel de Administración</h1>
            <span>I.E.I. N° 31756 Ricardo Palma</span>
        </div>

        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Correo electrónico</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-input"
                    value=""
                    required
                    autofocus
                    autocomplete="username"
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <div class="password-wrapper">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-input"
                        required
                        autocomplete="current-password"
                    >
                    <button
                        type="button"
                        id="togglePasswordBtn"
                        class="toggle-password"
                        aria-label="Mostrar contraseña"
                        title="Mostrar u ocultar contraseña"
                    >
                        {{-- Icono Ojo (Ver) --}}
                        <svg id="eyeIcon" class="icon" viewBox="0 0 24 24">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        {{-- Icono Ojo Tachado (Ocultar) --}}
                        <svg id="eyeSlashIcon" class="icon" viewBox="0 0 24 24" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <label class="form-checkbox">
                <input type="checkbox" name="remember" value="1">
                Recordar sesión
            </label>

            <button type="submit" class="btn-submit">
                <svg class="icon" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Iniciar sesión
            </button>
        </form>

        <div class="login-footer">
            <a href="{{ route('home') }}">← Regresar al sitio principal</a>
        </div>
    </main>

    <script>
        (function() {
            var toggleBtn = document.getElementById('togglePasswordBtn');
            var passwordInput = document.getElementById('password');
            var eyeIcon = document.getElementById('eyeIcon');
            var eyeSlashIcon = document.getElementById('eyeSlashIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    var isPassword = passwordInput.getAttribute('type') === 'password';
                    if (isPassword) {
                        passwordInput.setAttribute('type', 'text');
                        eyeIcon.style.display = 'none';
                        eyeSlashIcon.style.display = 'block';
                        toggleBtn.setAttribute('aria-label', 'Ocultar contraseña');
                    } else {
                        passwordInput.setAttribute('type', 'password');
                        eyeIcon.style.display = 'block';
                        eyeSlashIcon.style.display = 'none';
                        toggleBtn.setAttribute('aria-label', 'Mostrar contraseña');
                    }
                });
            }
        })();
    </script>
</body>
</html>
