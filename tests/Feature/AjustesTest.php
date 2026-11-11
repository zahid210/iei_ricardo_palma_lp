<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AjustesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_invitados_no_pueden_acceder_a_ajustes(): void
    {
        $response = $this->get('/admin/ajustes');
        $response->assertRedirect('/admin/login');
    }

    public function test_administrador_puede_ver_y_actualizar_ajustes(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/ajustes');
        $response->assertStatus(200);

        $updateResponse = $this->actingAs($admin)->put('/admin/ajustes', [
            'telefono' => '+51 987 654 321',
            'whatsapp' => '51987654321',
            'email' => 'direccion@rpalma.edu.pe',
            'horario_atencion' => 'Lunes a Viernes: 7:30 a.m. a 2:00 p.m.',
            'direccion' => 'Av. Los Próceres 123, Chaupimarca - Cerro de Pasco',
            'google_maps_url' => 'https://maps.app.goo.gl/ejemplo',
            'facebook_url' => 'https://facebook.com/ricardopalmapasco',
            'youtube_url' => 'https://youtube.com/@ricardopalmapasco',
        ]);

        $updateResponse->assertRedirect('/admin/ajustes');
        $updateResponse->assertSessionHas('success');

        $this->assertDatabaseHas('ajustes', [
            'id' => 1,
            'telefono' => '+51 987 654 321',
            'email' => 'direccion@rpalma.edu.pe',
        ]);
    }
}
