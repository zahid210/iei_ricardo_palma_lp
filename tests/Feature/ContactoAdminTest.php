<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
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
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/Mensajes/Index')
            ->has('mensajes.data', 1)
            ->where('mensajes.data.0.nombre', 'Juan Perez')
            ->where('mensajes.data.0.leido', false)
        );
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
        $response->assertInertia(fn (Assert $page) => $page
            ->component('Admin/Mensajes/Show')
            ->where('contacto.id', $contact->id)
        );

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

    public function test_admin_can_toggle_archive_status(): void
    {
        $contact = Contact::create([
            'nombre' => 'Ana Torres',
            'telefono' => '987654324',
            'correo' => 'ana@example.com',
            'nivel' => 'Primaria',
            'mensaje' => 'Duda sobre pensiones',
            'leido' => true,
            'archivado' => false,
        ]);

        $response = $this->patch(route('admin.mensajes.toggle-archivado', $contact->id));
        $response->assertRedirect();

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'archivado' => true,
        ]);
    }

    public function test_admin_cannot_delete_unarchived_message(): void
    {
        $contact = Contact::create([
            'nombre' => 'Luis Gomez',
            'telefono' => '987654325',
            'correo' => 'luis@example.com',
            'nivel' => 'Secundaria',
            'mensaje' => 'Consulta no archivada',
            'leido' => true,
            'archivado' => false,
        ]);

        $response = $this->delete(route('admin.mensajes.destroy', $contact->id));
        $response->assertRedirect();

        // El mensaje NO debe haberse borrado
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function test_admin_can_delete_archived_message(): void
    {
        $contact = Contact::create([
            'nombre' => 'Elena Vega',
            'telefono' => '987654326',
            'correo' => 'elena@example.com',
            'nivel' => 'Inicial',
            'mensaje' => 'Consulta archivada a eliminar',
            'leido' => true,
            'archivado' => true,
        ]);

        $response = $this->delete(route('admin.mensajes.destroy', $contact->id));
        $response->assertRedirect();

        // El mensaje debe haber sido eliminado
        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function test_admin_cannot_toggle_read_status_on_archived_message(): void
    {
        $contact = Contact::create([
            'nombre' => 'Roberto Diaz',
            'telefono' => '987654327',
            'correo' => 'roberto@example.com',
            'nivel' => 'Primaria',
            'mensaje' => 'Consulta archivada',
            'leido' => true,
            'archivado' => true,
        ]);

        $response = $this->patch(route('admin.mensajes.toggle', $contact->id));
        $response->assertRedirect();
        $response->assertSessionHas('error');

        // El estado de lectura no debe haber cambiado
        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'leido' => true,
        ]);
    }
}
