<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }

    public function test_admin_can_login_using_env_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => env('ADMIN_EMAIL', 'admin@rpalma.edu.pe'),
            'password' => env('ADMIN_PASSWORD', 'palma2026'),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('admin.noticias.index'));
    }

    public function test_admin_cannot_login_with_invalid_password(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => env('ADMIN_EMAIL', 'admin@rpalma.edu.pe'),
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_login_has_throttle_protection(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.submit'), [
                'email' => 'bad@email.com',
                'password' => 'badpass',
            ]);
        }

        // El 6to intento debe recibir 429 Too Many Requests
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'bad@email.com',
            'password' => 'badpass',
        ]);

        $response->assertStatus(429);
    }

    public function test_existing_database_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'docente.editor@rpalma.edu.pe',
            'password' => Hash::make('secreto123'),
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'docente.editor@rpalma.edu.pe',
            'password' => 'secreto123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.noticias.index'));
    }
}
