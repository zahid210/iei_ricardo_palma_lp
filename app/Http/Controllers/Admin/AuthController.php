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

        $adminEmail = (string) config('admin.email', env('ADMIN_EMAIL', 'admin@rpalma.edu.pe'));
        $adminPassword = (string) config('admin.password', env('ADMIN_PASSWORD', 'palma2026'));
        $adminName = (string) config('admin.name', env('ADMIN_NAME', 'Administrador'));

        // 1. Autenticación contra configuración administrativa (soporta config:cache)
        $emailMatches = hash_equals(strtolower($adminEmail), strtolower($credentials['email']));
        $passwordMatches = hash_equals($adminPassword, $credentials['password']);

        if ($emailMatches && $passwordMatches) {
            // Obtenemos o creamos la sesión del usuario administrador en BD
            $user = User::firstOrNew(['email' => $adminEmail]);
            $user->name = $adminName;
            $user->password = Hash::make($adminPassword);
            $user->save();

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->intended(route('admin.noticias.index'));
        }

        // 2. Autenticación estándar contra base de datos
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.noticias.index'));
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
