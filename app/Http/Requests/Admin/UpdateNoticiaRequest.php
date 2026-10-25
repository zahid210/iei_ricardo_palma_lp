<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoticiaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'extracto' => ['required', 'string', 'max:500'],
            'contenido' => ['required', 'string'],
            'imagen_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'autor' => ['nullable', 'string', 'max:120'],
            'fecha_publicacion' => ['required', 'date'],
            'destacada' => ['nullable', 'boolean'],
            'orden' => ['nullable', 'integer', 'min:0', 'max:9999'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título de la noticia es obligatorio.',
            'extracto.required' => 'El resumen o extracto es obligatorio.',
            'contenido.required' => 'El contenido de la noticia es obligatorio.',
            'imagen_file.image' => 'El archivo seleccionado debe ser una imagen válida.',
            'imagen_file.max' => 'La imagen no debe superar los 5 MB.',
            'fecha_publicacion.required' => 'La fecha de publicación es obligatoria.',
        ];
    }
}
