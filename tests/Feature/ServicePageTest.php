<?php

namespace Tests\Feature;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_with_reserved_slugs_render_without_image_feature(): void
    {
        $service = Service::create([
            'name' => 'Info Obat',
            'slug' => 'info-obat',
            'description' => 'Informasi lengkap mengenai obat.',
            'content' => '<p>Konten layanan.</p>',
            'icon' => 'fas fa-pills',
            'is_active' => true,
            'order' => 1,
        ]);

        $this->get(route('layanan.index'))
            ->assertOk()
            ->assertSee(route('layanan.detail', $service))
            ->assertDontSee('type="file"')
            ->assertDontSee('services/info-obat.jpg');

        $this->get(route('layanan.detail', $service))
            ->assertOk()
            ->assertSee('Konten layanan.')
            ->assertDontSee('services/info-obat.jpg');
    }
}
