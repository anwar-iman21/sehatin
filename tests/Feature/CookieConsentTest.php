<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CookieConsentTest extends TestCase
{
    use RefreshDatabase;

    public function test_cookie_consent_banner_is_available_in_indonesian(): void
    {
        $this->withSession(['locale' => 'id'])
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Kami menggunakan cookie')
            ->assertSee('Terima Semua Cookie')
            ->assertSee('Hanya Cookie Esensial')
            ->assertSee('Pengaturan Cookie');
    }

    public function test_cookie_consent_banner_is_available_in_english(): void
    {
        $this->withSession(['locale' => 'en'])
            ->get(route('home'))
            ->assertOk()
            ->assertSee('We use cookies')
            ->assertSee('Accept All Cookies')
            ->assertSee('Essential Cookies Only')
            ->assertSee('Cookie Settings');
    }
}
