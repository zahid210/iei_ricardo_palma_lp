<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nivel' => ['required', 'string', 'in:Inicial,Primaria,Secundaria'],
            'nombres_apellidos' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'max:255'],
            'dni' => ['nullable', 'string', 'max:20'],
            'orden' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    public function messages(): array
    {
        return [
            'nivel.required' => 'El nivel educativo es obligatorio.',
            'nivel.in' => 'El nivel educativo debe ser Inicial, Primaria o Secundaria.',
            'nombres_apellidos.required' => 'Los nombres y apellidos son obligatorios.',
            'cargo.required' => 'El cargo o función docente es obligatorio.',
        ];
    }
}
