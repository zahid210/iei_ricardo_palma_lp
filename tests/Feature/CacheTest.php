<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Cache::flush();
    }

    public function test_home_page_is_served_from_cache_on_second_request(): void
    {
        $this->get('/')->assertOk()->assertHeader('X-Cache', 'MISS');
        $this->get('/')->assertOk()->assertHeader('X-Cache', 'HIT');
    }

    public function test_contact_page_is_never_cached(): void
    {
        $this->get('/contacto')->assertOk()->assertHeaderMissing('X-Cache');
    }
}
