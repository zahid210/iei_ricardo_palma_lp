<?php

namespace Tests\Feature;

use App\Models\Docente;
use App\Models\Galeria;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_admin_can_view_noticias_and_edit_without_404(): void
    {
        $noticia = Noticia::create([
            'titulo' => 'Gran Actividad Escolar',
            'slug' => 'gran-actividad-escolar',
            'extracto' => 'Resumen breve de la actividad',
            'contenido' => 'Contenido completo del comunicado',
            'fecha_publicacion' => now()->toDateString(),
            'autor' => 'Colegio Ricardo Palma',
            'imagen' => 'images/galeria_1.jpg',
            'destacada' => false,
            'orden' => 1,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.noticias.edit', $noticia->id));
        $response->assertOk();

        // Eliminar usando id
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.noticias.destroy', $noticia->id));
        $deleteResponse->assertRedirect(route('admin.noticias.index'));
        $this->assertDatabaseMissing('noticias', ['id' => $noticia->id]);
    }

    public function test_admin_can_create_and_update_noticia_with_image_upload(): void
    {
        $file = UploadedFile::fake()->create('noticia_foto.jpg', 300, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post(route('admin.noticias.store'), [
            'titulo' => 'Inicio de Clases 2026',
            'extracto' => 'Todo listo para el inicio del nuevo año escolar.',
            'contenido' => 'Los docentes y directivos del colegio Ricardo Palma dan la bienvenida a los estudiantes.',
            'fecha_publicacion' => '2026-03-01',
            'autor' => 'Dirección',
            'destacada' => true,
            'orden' => 1,
            'imagen_file' => $file,
        ]);

        $response->assertRedirect(route('admin.noticias.index'));
        $this->assertDatabaseHas('noticias', ['titulo' => 'Inicio de Clases 2026']);

        $noticia = Noticia::where('titulo', 'Inicio de Clases 2026')->first();
        $this->assertNotNull($noticia);
        $this->assertStringStartsWith('storage/noticia_upload_', $noticia->imagen);
        $this->assertEquals('/'.$noticia->imagen, $noticia->imagen_url);
        $this->assertTrue(Storage::disk('public')->exists(str_replace('storage/', '', $noticia->imagen)));

        // Eliminar y comprobar limpieza física del archivo
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.noticias.destroy', $noticia->id));
        $delResponse->assertRedirect(route('admin.noticias.index'));
        $this->assertFalse(Storage::disk('public')->exists(str_replace('storage/', '', $noticia->imagen)));
    }

    public function test_admin_can_create_and_delete_docente(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.docentes.store'), [
            'nivel' => 'Primaria',
            'nombres_apellidos' => 'PEREZ LOPEZ, Juan',
            'cargo' => 'PROFESOR DE MATEMATICA',
            'orden' => 2,
        ]);

        $response->assertRedirect(route('admin.docentes.index'));
        $this->assertDatabaseHas('docentes', ['nombres_apellidos' => 'PEREZ LOPEZ, Juan']);

        $docente = Docente::where('nombres_apellidos', 'PEREZ LOPEZ, Juan')->first();
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.docentes.destroy', $docente->id));
        $delResponse->assertRedirect(route('admin.docentes.index'));
        $this->assertDatabaseMissing('docentes', ['id' => $docente->id]);
    }

    public function test_admin_can_view_and_delete_galeria(): void
    {
        $foto = Galeria::create([
            'titulo' => 'Foto de desfile 2026',
            'imagen_path' => 'images/galeria_1.jpg',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.galeria.index'));
        $response->assertOk();

        $delResponse = $this->actingAs($this->admin)->delete(route('admin.galeria.destroy', $foto->id));
        $delResponse->assertRedirect(route('admin.galeria.index'));
        $this->assertDatabaseMissing('galerias', ['id' => $foto->id]);
    }

    public function test_admin_can_upload_foto_to_galeria(): void
    {
        $file = UploadedFile::fake()->create('mi_foto_escolar.jpg', 200, 'image/jpeg');
        $tag = \App\Models\GaleriaEtiqueta::firstOrCreate(['nombre' => 'Deportes'], ['slug' => 'deportes']);

        $response = $this->actingAs($this->admin)->post(route('admin.galeria.store'), [
            'titulo' => 'Escolta Escolar 2026',
            'etiqueta_id' => $tag->id,
            'imagen_file' => $file,
        ]);

        $response->assertRedirect(route('admin.galeria.index'));
        $this->assertDatabaseHas('galerias', [
            'titulo' => 'Escolta Escolar 2026',
            'etiqueta_id' => $tag->id,
        ]);

        $galeria = Galeria::where('titulo', 'Escolta Escolar 2026')->first();
        $this->assertNotNull($galeria);
        $this->assertStringStartsWith('storage/galeria_upload_', $galeria->imagen_path);
        $this->assertEquals('/'.$galeria->imagen_path, $galeria->url);
        $this->assertTrue(Storage::disk('public')->exists(str_replace('storage/', '', $galeria->imagen_path)));

        // Limpieza física mediante destroy
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.galeria.destroy', $galeria->id));
        $delResponse->assertRedirect(route('admin.galeria.index'));
        $this->assertFalse(Storage::disk('public')->exists(str_replace('storage/', '', $galeria->imagen_path)));
    }

    public function test_admin_can_manage_galeria_etiquetas_and_update_foto(): void
    {
        // 1. Crear etiqueta
        $tagResponse = $this->actingAs($this->admin)->post(route('admin.galeria.etiquetas.store'), [
            'nombre' => 'Ferias Científicas',
        ]);
        $tagResponse->assertRedirect();
        $this->assertDatabaseHas('galeria_etiquetas', ['nombre' => 'Ferias Científicas']);
        $tag = \App\Models\GaleriaEtiqueta::where('nombre', 'Ferias Científicas')->first();

        // 2. Crear foto
        $foto = Galeria::create([
            'titulo' => 'Foto original',
            'imagen_path' => 'images/galeria_1.jpg',
        ]);

        // 3. Editar foto para cambiar título y asignar etiqueta
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.galeria.update', $foto->id), [
            'titulo' => 'Feria de Ciencias 2026',
            'etiqueta_id' => $tag->id,
        ]);
        $updateResponse->assertRedirect(route('admin.galeria.index'));
        $this->assertDatabaseHas('galerias', [
            'id' => $foto->id,
            'titulo' => 'Feria de Ciencias 2026',
            'etiqueta_id' => $tag->id,
        ]);

        // 4. Eliminar etiqueta
        $delTagResponse = $this->actingAs($this->admin)->delete(route('admin.galeria.etiquetas.destroy', $tag->id));
        $delTagResponse->assertRedirect();
        $this->assertDatabaseMissing('galeria_etiquetas', ['id' => $tag->id]);
        $foto->refresh();
        $this->assertNull($foto->etiqueta_id);
    }
}
