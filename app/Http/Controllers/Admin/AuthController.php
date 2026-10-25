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

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $adminEmail = (string) env('ADMIN_EMAIL', 'admin@rpalma.edu.pe');
        $adminPassword = (string) env('ADMIN_PASSWORD', 'palma2026');
        $adminName = (string) env('ADMIN_NAME', 'Administrador');

        // Autenticación estricta contra variables de entorno (.env)
        // sin depender de registros manuales en base de datos.
        $emailMatches = hash_equals(strtolower($adminEmail), strtolower($credentials['email']));
        $passwordMatches = hash_equals($adminPassword, $credentials['password']);

        if ($emailMatches && $passwordMatches) {
            // Obtenemos o creamos la sesión del usuario administrador en BD
            // sincronizando la contraseña con la clave actual del .env
            $user = User::firstOrNew(['email' => $adminEmail]);
            $user->name = $adminName;
            $user->password = Hash::make($adminPassword);
            $user->save();

            Auth::login($user, $request->boolean('remember'));
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
