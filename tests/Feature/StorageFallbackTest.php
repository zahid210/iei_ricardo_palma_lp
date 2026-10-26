<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageFallbackTest extends TestCase
{
    public function test_storage_fallback_route_serves_existing_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('galeria_test_fallback.png', 'fake image content');

        $response = $this->get('/storage/galeria_test_fallback.png');

        $response->assertOk();
    }

    public function test_storage_fallback_route_returns_404_when_file_does_not_exist(): void
    {
        Storage::fake('public');

        $response = $this->get('/storage/archivo_inexistente_123.png');

        $response->assertNotFound();
    }
}
