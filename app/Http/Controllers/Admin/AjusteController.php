<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ajuste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AjusteController extends Controller
{
    /**
     * Mostrar formulario de configuración institucional.
     */
    public function edit(): Response
    {
        $ajustes = Ajuste::obtener();

        return Inertia::render('Admin/Ajustes/Index', [
            'ajustes' => $ajustes,
        ]);
    }

    /**
     * Actualizar configuración institucional.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'telefono' => ['required', 'string', 'max:50'],
            'whatsapp' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100'],
            'horario_atencion' => ['required', 'string', 'max:150'],
            'direccion' => ['required', 'string', 'max:255'],
            'google_maps_url' => ['nullable', 'string', 'max:500'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'string', 'max:255'],
        ], [
            'telefono.required' => 'El teléfono de atención es obligatorio.',
            'whatsapp.required' => 'El número de WhatsApp es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un formato de correo válido.',
            'horario_atencion.required' => 'El horario de atención es obligatorio.',
            'direccion.required' => 'La dirección física del colegio es obligatoria.',
        ]);

        $ajuste = Ajuste::firstOrNew(['id' => 1]);
        $ajuste->fill($validated);
        $ajuste->save();

        Ajuste::limpiarCache();

        return redirect()->route('admin.ajustes.edit')->with('success', 'Ajustes institucionales actualizados correctamente.');
    }
}
