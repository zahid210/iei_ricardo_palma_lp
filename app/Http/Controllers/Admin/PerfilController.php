<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;
use Inertia\Response;

class PerfilController extends Controller
{
    /**
     * Mostrar la pantalla de configuración de perfil y seguridad.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Admin/Perfil/Index', [
            'user' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
        ]);
    }

    /**
     * Actualizar los datos generales del perfil (Nombre y Correo).
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'name.required' => 'El nombre del usuario es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un formato de correo válido.',
            'email.unique' => 'Este correo electrónico ya está registrado en otra cuenta.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('admin.perfil.edit')->with('success', 'Datos del perfil actualizados correctamente.');
    }

    /**
     * Actualizar la contraseña del administrador.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'current_password.current_password' => 'La contraseña actual no es correcta.',
            'password.required' => 'Debes ingresar una nueva contraseña.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('admin.perfil.edit')->with('success', 'Tu contraseña ha sido actualizada con éxito.');
    }
}
