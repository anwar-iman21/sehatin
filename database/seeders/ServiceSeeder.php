<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name'        => 'Info Obat',
                'slug'        => 'info-obat',
                'description' => 'Temukan informasi lengkap mengenai obat-obatan, fungsi, dosis, dan efek sampingnya.',
                'content'     => '<p>Layanan Info Obat SEHATIN menyediakan database informasi obat yang komprehensif. Anda dapat mencari informasi tentang berbagai jenis obat, mulai dari obat bebas hingga obat resep, termasuk komposisi, indikasi, kontraindikasi, dan cara penggunaan yang tepat.</p><p><strong>Disclaimer:</strong> Informasi ini bersifat edukatif dan tidak menggantikan konsultasi dengan apoteker atau tenaga kesehatan profesional.</p>',
                'icon'        => 'fas fa-pills',
                'is_active'   => true,
                'order'       => 1,
            ],
            [
                'name'        => 'Info Penyakit',
                'slug'        => 'info-penyakit',
                'description' => 'Pelajari gejala, penyebab, dan cara pencegahan berbagai penyakit secara mudah.',
                'content'     => '<p>Layanan Info Penyakit menyajikan informasi medis yang mudah dipahami tentang berbagai kondisi kesehatan. Dari penyakit umum seperti flu dan demam, hingga penyakit kronis seperti diabetes dan hipertensi.</p><p><strong>Disclaimer:</strong> Informasi di SEHATIN bersifat edukatif dan tidak menggantikan diagnosis atau konsultasi dengan tenaga kesehatan.</p>',
                'icon'        => 'fas fa-notes-medical',
                'is_active'   => true,
                'order'       => 2,
            ],
            [
                'name'        => 'Edukasi Kesehatan',
                'slug'        => 'edukasi-kesehatan',
                'description' => 'Tingkatkan literasi kesehatan Anda melalui konten edukatif yang terpercaya.',
                'content'     => '<p>Program Edukasi Kesehatan SEHATIN hadir untuk meningkatkan kesadaran masyarakat tentang pentingnya menjaga kesehatan. Kami menyajikan konten kesehatan yang akurat, mudah dipahami, dan dapat diterapkan dalam kehidupan sehari-hari.</p>',
                'icon'        => 'fas fa-graduation-cap',
                'is_active'   => true,
                'order'       => 3,
            ],
            [
                'name'        => 'Panduan Kesehatan',
                'slug'        => 'panduan-kesehatan',
                'description' => 'Panduan praktis menjaga kesehatan dari berbagai aspek kehidupan sehari-hari.',
                'content'     => '<p>Panduan Kesehatan SEHATIN menyediakan langkah-langkah praktis untuk menjaga kesehatan optimal. Mulai dari panduan olahraga, pola tidur yang baik, manajemen stres, hingga tips menjaga imunitas tubuh.</p>',
                'icon'        => 'fas fa-book-medical',
                'is_active'   => true,
                'order'       => 4,
            ],
            [
                'name'        => 'Direktori Kesehatan',
                'slug'        => 'direktori-kesehatan',
                'description' => 'Temukan fasilitas dan layanan kesehatan terpercaya di sekitar Anda.',
                'content'     => '<p>Direktori Kesehatan SEHATIN memudahkan Anda menemukan informasi tentang berbagai fasilitas layanan kesehatan. Kami menyediakan informasi tentang rumah sakit, klinik, puskesmas, dan fasilitas kesehatan lainnya.</p>',
                'icon'        => 'fas fa-map-marker-alt',
                'is_active'   => true,
                'order'       => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
