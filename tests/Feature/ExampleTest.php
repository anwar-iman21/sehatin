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
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_mobile_navigation_controls_a_single_menu_panel(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<div class="nav-menu" id="navMenu">', false)
            ->assertSee('<ul class="nav-links" id="navLinks">', false)
            ->assertSee('<div class="nav-right" id="navRight">', false)
            ->assertSee('aria-controls="navMenu" aria-expanded="false"', false);
    }
}
