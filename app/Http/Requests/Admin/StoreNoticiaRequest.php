<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoticiaRequest extends FormRequest
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
            'imagen_file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
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
            'titulo.max' => 'El título no debe exceder los 255 caracteres.',
            'extracto.required' => 'El resumen o extracto es obligatorio.',
            'extracto.max' => 'El extracto no debe exceder los 500 caracteres.',
            'contenido.required' => 'El contenido de la noticia es obligatorio.',
            'imagen_file.file' => 'El archivo seleccionado no es válido.',
            'imagen_file.mimes' => 'La imagen debe tener formato JPG, JPEG, PNG o WebP.',
            'imagen_file.max' => 'La imagen no debe superar los 10 MB.',
            'fecha_publicacion.required' => 'La fecha de publicación es obligatoria.',
        ];
    }
}
