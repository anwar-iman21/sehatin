<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question'  => 'Apa itu SEHATIN?',
                'answer'    => 'SEHATIN adalah portal informasi kesehatan digital yang menyediakan artikel kesehatan berkualitas, informasi obat, informasi penyakit, dan panduan kesehatan untuk masyarakat Indonesia. Semua konten disajikan dengan bahasa yang mudah dipahami dan berbasis sumber terpercaya.',
                'is_active' => true,
                'order'     => 1,
            ],
            [
                'question'  => 'Apakah informasi di SEHATIN dapat dijadikan pengganti konsultasi dokter?',
                'answer'    => 'Tidak. Seluruh informasi yang tersedia di SEHATIN bersifat edukatif dan bertujuan untuk meningkatkan literasi kesehatan masyarakat. Informasi ini tidak menggantikan diagnosis, saran medis, atau konsultasi dengan dokter dan tenaga kesehatan profesional. Untuk kondisi kesehatan yang serius, selalu konsultasikan dengan dokter Anda.',
                'is_active' => true,
                'order'     => 2,
            ],
            [
                'question'  => 'Bagaimana cara mendaftar akun di SEHATIN?',
                'answer'    => 'Anda dapat mendaftar akun SEHATIN dengan mengisi formulir pendaftaran menggunakan email dan kata sandi, atau lebih mudah dengan login menggunakan akun Google Anda. Klik tombol "Daftar" di pojok kanan atas halaman untuk memulai.',
                'is_active' => true,
                'order'     => 3,
            ],
            [
                'question'  => 'Apakah konten di SEHATIN gratis?',
                'answer'    => 'Ya, seluruh konten artikel dan informasi kesehatan di SEHATIN dapat diakses secara gratis oleh semua pengguna, baik yang sudah mendaftar maupun yang belum. Kami berkomitmen untuk menyediakan informasi kesehatan yang terjangkau dan mudah diakses oleh seluruh masyarakat.',
                'is_active' => true,
                'order'     => 4,
            ],
            [
                'question'  => 'Bagaimana cara mengganti bahasa tampilan di SEHATIN?',
                'answer'    => 'SEHATIN mendukung dua bahasa: Bahasa Indonesia dan English. Untuk mengganti bahasa, klik ikon bahasa (🌐) yang tersedia di bagian header/navigasi website, kemudian pilih bahasa yang Anda inginkan. Pilihan bahasa akan tersimpan otomatis untuk kunjungan berikutnya.',
                'is_active' => true,
                'order'     => 5,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
