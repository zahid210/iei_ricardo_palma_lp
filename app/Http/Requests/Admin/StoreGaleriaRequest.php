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
            'imagen_file' => ['required', 'file', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título o descripción de la fotografía es obligatorio.',
            'titulo.max' => 'El título no debe exceder los 255 caracteres.',
            'imagen_file.required' => 'Debes seleccionar un archivo de imagen para subir.',
            'imagen_file.file' => 'El archivo subido no es válido.',
            'imagen_file.mimes' => 'El archivo debe tener formato JPG, JPEG, PNG o WebP.',
            'imagen_file.max' => 'La imagen no debe superar los 10 MB.',
        ];
    }
}
