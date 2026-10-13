<?php

namespace Tests\Feature;

use App\Support\HtmlSanitizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_headers_are_applied_to_web_responses(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()')
            ->assertHeader('Cross-Origin-Opener-Policy', 'same-origin')
            ->assertHeader('Cross-Origin-Resource-Policy', 'same-origin');
    }

    public function test_language_switch_is_not_available_over_get(): void
    {
        $this->get('/lang/en')->assertMethodNotAllowed();
    }

    public function test_html_sanitizer_removes_scriptable_markup(): void
    {
        $html = HtmlSanitizer::clean('<p onclick="alert(1)">Safe</p><img src="javascript:alert(1)" onerror="alert(1)"><script>alert(1)</script>');

        $this->assertStringContainsString('<p>Safe</p>', $html);
        $this->assertStringNotContainsString('onclick', $html);
        $this->assertStringNotContainsString('onerror', $html);
        $this->assertStringNotContainsString('javascript:', $html);
        $this->assertStringNotContainsString('<script', $html);
    }
}
