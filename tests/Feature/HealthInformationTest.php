<?php

namespace Tests\Feature;

use App\Models\Disease;
use App\Models\Drug;
use App\Models\HealthGuide;
use App\Models\User;
use Database\Seeders\DiseaseSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DrugSeeder;
use Database\Seeders\HealthGuideSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_catalog_seeders_create_all_requested_records_and_public_pages_render(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('drugs', 15);
        $this->assertDatabaseCount('diseases', 10);
        $this->assertDatabaseCount('health_guides', 10);

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeHtml('<title>SEHATIN</title>')
            ->assertSeeHtml('<link rel="icon" type="image/svg+xml" href="http://localhost:8000/favicon.svg">')
            ->assertSee('Info Obat')
            ->assertSee('Info Penyakit')
            ->assertSee('Panduan Kesehatan');
        $this->get(route('layanan.index'))->assertOk()->assertSee('Info Obat')->assertSee('Info Penyakit')->assertSee('Panduan Kesehatan');
        $this->get(route('obat.index'))
            ->assertOk()
            ->assertSee('Paracetamol')
            ->assertSee('Selanjutnya')
            ->assertSee('Navigasi halaman')
            ->assertDontSee('Showing');
        $this->get(route('obat.show', Drug::where('slug', 'paracetamol')->firstOrFail()))
            ->assertOk()
            ->assertSeeHtml('data-page-header-typed')
            ->assertSee('Indikasi')
            ->assertSee('Informasi ini bersifat edukatif dan tidak menggantikan konsultasi dengan tenaga kesehatan profesional');
        $this->get(route('penyakit.index'))->assertOk()->assertSee('Demam Berdarah');
        $this->get(route('penyakit.show', Disease::where('slug', 'demam-berdarah')->firstOrFail()))
            ->assertOk()
            ->assertSeeHtml('data-page-header-typed')
            ->assertSee('Kapan harus ke dokter')
            ->assertSee('Informasi ini bersifat edukatif dan tidak menggantikan konsultasi dengan tenaga kesehatan profesional');
        $this->get(route('panduan.index'))->assertOk()->assertSee('Panduan Gizi Seimbang');
        $this->get(route('panduan.show', HealthGuide::where('slug', 'panduan-gizi-seimbang')->firstOrFail()))
            ->assertOk()
            ->assertSeeHtml('data-page-header-typed')
            ->assertSeeHtml('<h2>Isi piring dengan beragam pangan</h2>')
            ->assertSee('Informasi ini bersifat edukatif dan tidak menggantikan konsultasi dengan tenaga kesehatan profesional');
    }

    public function test_public_catalog_search_and_category_filters_work(): void
    {
        $this->seed([DrugSeeder::class, DiseaseSeeder::class, HealthGuideSeeder::class]);

        $this->get(route('obat.index', ['q' => 'para', 'letter' => 'P', 'category' => 'bebas']))
            ->assertOk()
            ->assertSee('Paracetamol')
            ->assertDontSee('Ibuprofen');

        $this->get(route('penyakit.index', ['q' => 'asma']))
            ->assertOk()
            ->assertSee('Asma')
            ->assertDontSee('Demam Berdarah');

        $this->get(route('panduan.index', ['category' => 'nutrisi']))
            ->assertOk()
            ->assertSee('Panduan Gizi Seimbang')
            ->assertDontSee('Olahraga untuk Pemula');
    }

    public function test_inactive_health_information_is_not_publicly_accessible(): void
    {
        $drug = Drug::create([
            'name' => 'Obat Nonaktif',
            'category' => 'bebas',
            'form' => 'tablet',
            'content' => 'Informasi',
            'is_active' => false,
        ]);
        $disease = Disease::create([
            'name' => 'Penyakit Nonaktif',
            'overview' => 'Informasi',
            'is_active' => false,
        ]);
        $guide = HealthGuide::create([
            'title' => 'Panduan Nonaktif',
            'category' => 'lainnya',
            'content' => '<p>Informasi</p>',
            'is_active' => false,
        ]);

        $this->get(route('obat.show', $drug))->assertNotFound();
        $this->get(route('penyakit.show', $disease))->assertNotFound();
        $this->get(route('panduan.show', $guide))->assertNotFound();
    }

    public function test_admin_can_manage_drugs_diseases_and_guides(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->get(route('admin.obat.index'))->assertOk();
        $this->get(route('admin.obat.create'))->assertOk();
        $this->post(route('admin.obat.store'), [
            'name' => 'Obat Uji',
            'generic_name' => 'Nama Generik',
            'category' => 'bebas',
            'form' => 'tablet',
            'content' => 'Deskripsi obat.',
        ])->assertRedirect(route('admin.obat.index'));
        $drug = Drug::where('slug', 'obat-uji')->firstOrFail();
        $this->get(route('admin.obat.edit', $drug))->assertOk();
        $this->put(route('admin.obat.update', $drug), [
            'name' => 'Obat Uji Diperbarui',
            'category' => 'resep',
            'form' => 'kapsul',
            'content' => 'Informasi terbaru.',
            'is_active' => 1,
        ])->assertRedirect(route('admin.obat.index'));
        $drug = Drug::where('slug', 'obat-uji-diperbarui')->firstOrFail();
        $this->post(route('admin.obat.toggle', $drug))->assertRedirect();
        $this->assertFalse($drug->fresh()->is_active);
        $this->post(route('admin.obat.store'), [
            'name' => 'Obat Uji Diperbarui',
            'category' => 'bebas',
            'form' => 'tablet',
            'content' => 'Obat dengan nama serupa.',
        ])->assertRedirect(route('admin.obat.index'));
        $duplicateDrug = Drug::where('slug', 'obat-uji-diperbarui-2')->firstOrFail();
        $this->delete(route('admin.obat.destroy', $drug))->assertRedirect(route('admin.obat.index'));
        $this->delete(route('admin.obat.destroy', $duplicateDrug))->assertRedirect(route('admin.obat.index'));

        $this->get(route('admin.penyakit.index'))->assertOk();
        $this->get(route('admin.penyakit.create'))->assertOk();
        $this->post(route('admin.penyakit.store'), [
            'name' => 'Penyakit Uji',
            'overview' => 'Gambaran penyakit.',
        ])->assertRedirect(route('admin.penyakit.index'));
        $disease = Disease::where('slug', 'penyakit-uji')->firstOrFail();
        $this->get(route('admin.penyakit.edit', $disease))->assertOk();
        $this->put(route('admin.penyakit.update', $disease), [
            'name' => 'Penyakit Uji Diperbarui',
            'overview' => 'Gambaran terbaru.',
            'is_active' => 1,
        ])->assertRedirect(route('admin.penyakit.index'));
        $disease = Disease::where('slug', 'penyakit-uji-diperbarui')->firstOrFail();
        $this->post(route('admin.penyakit.toggle', $disease))->assertRedirect();
        $this->delete(route('admin.penyakit.destroy', $disease))->assertRedirect(route('admin.penyakit.index'));

        $this->get(route('admin.panduan.index'))->assertOk();
        $this->get(route('admin.panduan.create'))->assertOk();
        $this->post(route('admin.panduan.store'), [
            'title' => 'Panduan Uji',
            'category' => 'lainnya',
            'content' => '<p>Isi panduan.</p>',
            'order' => 1,
        ])->assertRedirect(route('admin.panduan.index'));
        $guide = HealthGuide::where('slug', 'panduan-uji')->firstOrFail();
        $this->get(route('admin.panduan.edit', $guide))->assertOk();
        $this->put(route('admin.panduan.update', $guide), [
            'title' => 'Panduan Uji Diperbarui',
            'category' => 'mental',
            'content' => '<p>Konten terbaru.</p>',
            'order' => 2,
            'is_active' => 1,
        ])->assertRedirect(route('admin.panduan.index'));
        $guide = HealthGuide::where('slug', 'panduan-uji-diperbarui')->firstOrFail();
        $this->post(route('admin.panduan.toggle', $guide))->assertRedirect();
        $this->delete(route('admin.panduan.destroy', $guide))->assertRedirect(route('admin.panduan.index'));
    }
}
