<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Docente;
use App\Models\Galeria;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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

    public function test_admin_can_create_and_delete_docente(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.docentes.store'), [
            'nivel' => 'Primaria',
            'nombres_apellidos' => 'PEREZ LOPEZ, Juan',
            'cargo' => 'PROFESOR DE MATEMATICA',
            'dni' => '04012345',
            'orden' => 2,
        ]);

        $response->assertRedirect(route('admin.docentes.index'));
        $this->assertDatabaseHas('docentes', ['dni' => '04012345']);

        $docente = Docente::where('dni', '04012345')->first();
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
}
