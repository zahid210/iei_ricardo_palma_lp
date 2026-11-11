<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.noticias.index');
        }

        return inertia('Admin/Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Autenticación estándar y segura contra la base de datos (tabla users)
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.noticias.index'));
        }

        // Si la base de datos no tiene usuarios (primer despliegue en servidor limpio),
        // inicializamos con las credenciales por defecto configuradas.
        if (User::count() === 0) {
            $defaultEmail = (string) config('admin.email', env('ADMIN_DEFAULT_EMAIL', 'admin@rpalma.edu.pe'));
            $defaultPassword = (string) config('admin.password', env('ADMIN_DEFAULT_PASSWORD', '@dmin$RP'));
            $defaultName = (string) config('admin.name', env('ADMIN_DEFAULT_NAME', 'Administrador'));

            if (hash_equals(strtolower($defaultEmail), strtolower($credentials['email'])) && hash_equals($defaultPassword, $credentials['password'])) {
                $user = User::create([
                    'name' => $defaultName,
                    'email' => $defaultEmail,
                    'password' => Hash::make($defaultPassword),
                ]);

                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('admin.noticias.index'));
            }
        }

        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
