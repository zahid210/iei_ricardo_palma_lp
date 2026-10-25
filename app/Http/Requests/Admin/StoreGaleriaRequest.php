<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreGaleriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'imagen_file' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título o descripción de la fotografía es obligatorio.',
            'imagen_file.required' => 'Debes seleccionar un archivo de imagen para subir.',
            'imagen_file.image' => 'El archivo debe ser una imagen válida (JPG, PNG o WebP).',
            'imagen_file.max' => 'La imagen no debe superar los 5 MB.',
        ];
    }
}
