<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactoAdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Simular autenticación del admin
        $admin = User::factory()->create();
        $this->actingAs($admin);
    }

    public function test_admin_can_view_messages_list(): void
    {
        Contact::create([
            'nombre' => 'Juan Perez',
            'telefono' => '987654321',
            'correo' => 'juan@example.com',
            'nivel' => 'Primaria',
            'mensaje' => 'Consulta de matrícula',
            'leido' => false,
        ]);

        $response = $this->get(route('admin.mensajes.index'));
        $response->assertStatus(200);
        $response->assertSee('Juan Perez');
        $response->assertSee('Nuevo');
    }

    public function test_viewing_message_marks_it_as_read(): void
    {
        $contact = Contact::create([
            'nombre' => 'Maria Lopez',
            'telefono' => '987654322',
            'correo' => 'maria@example.com',
            'nivel' => 'Secundaria',
            'mensaje' => 'Informes sobre traslados',
            'leido' => false,
        ]);

        $response = $this->get(route('admin.mensajes.show', $contact->id));
        $response->assertStatus(200);

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'leido' => true,
        ]);
    }

    public function test_admin_can_toggle_read_status(): void
    {
        $contact = Contact::create([
            'nombre' => 'Carlos Ruiz',
            'telefono' => '987654323',
            'correo' => 'carlos@example.com',
            'nivel' => 'Inicial',
            'mensaje' => 'Vacantes 2026',
            'leido' => true,
        ]);

        $response = $this->patch(route('admin.mensajes.toggle', $contact->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'leido' => false,
        ]);
    }
}
