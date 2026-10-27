<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Evita depender del build de Vite (public/build/manifest.json) en los tests.
        $this->withoutVite();

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
