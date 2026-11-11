<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PerfilTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_invitados_no_pueden_acceder_al_perfil(): void
    {
        $response = $this->get('/admin/perfil');
        $response->assertRedirect('/admin/login');
    }

    public function test_administrador_puede_actualizar_su_nombre_y_correo(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Antiguo',
            'email' => 'antiguo@rpalma.edu.pe',
        ]);

        $response = $this->actingAs($admin)->put('/admin/perfil', [
            'name' => 'Admin Nuevo',
            'email' => 'nuevo@rpalma.edu.pe',
        ]);

        $response->assertRedirect('/admin/perfil');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => 'Admin Nuevo',
            'email' => 'nuevo@rpalma.edu.pe',
        ]);
    }

    public function test_administrador_puede_cambiar_su_password_con_validacion_actual(): void
    {
        $admin = User::factory()->create([
            'password' => Hash::make('clave-anterior-123'),
        ]);

        // Falla con clave actual errónea
        $failResponse = $this->actingAs($admin)->put('/admin/perfil/password', [
            'current_password' => 'clave-incorrecta',
            'password' => 'nueva-clave-segura-2026',
            'password_confirmation' => 'nueva-clave-segura-2026',
        ]);
        $failResponse->assertSessionHasErrors('current_password');

        // Exito con clave correcta
        $successResponse = $this->actingAs($admin)->put('/admin/perfil/password', [
            'current_password' => 'clave-anterior-123',
            'password' => 'nueva-clave-segura-2026',
            'password_confirmation' => 'nueva-clave-segura-2026',
        ]);
        $successResponse->assertRedirect('/admin/perfil');
        $successResponse->assertSessionHas('success');

        $admin->refresh();
        $this->assertTrue(Hash::check('nueva-clave-segura-2026', $admin->password));
    }
}
