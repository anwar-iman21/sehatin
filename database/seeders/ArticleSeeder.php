<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $articles = [
            [
                'category_slug' => 'kesehatan-umum',
                'title'         => 'Manfaat Minum Air Putih yang Cukup Setiap Hari',
                'excerpt'       => 'Air adalah komponen penting tubuh manusia. Mengetahui manfaat minum air yang cukup setiap hari dapat mendorong kebiasaan hidup yang lebih sehat.',
                'content'       => '<p>Tubuh manusia terdiri dari sekitar 60% air. Menjaga kecukupan asupan air setiap hari adalah salah satu fondasi utama kesehatan yang sering diabaikan.</p><h3>Manfaat Minum Air yang Cukup</h3><ul><li>Menjaga fungsi organ tubuh secara optimal</li><li>Membantu proses pencernaan</li><li>Mengatur suhu tubuh</li><li>Meningkatkan konsentrasi dan fungsi otak</li><li>Membantu pembuangan racun melalui urin</li></ul><p>Rekomendasi umum adalah minum minimal 8 gelas (2 liter) air per hari, namun kebutuhan individu bisa bervariasi tergantung aktivitas dan kondisi kesehatan.</p>',
                'status'        => 'published',
            ],
            [
                'category_slug' => 'kesehatan-mental',
                'title'         => '5 Cara Efektif Mengelola Stres di Era Modern',
                'excerpt'       => 'Stres adalah respons alami tubuh terhadap tekanan. Pelajari cara-cara efektif untuk mengelola stres agar kualitas hidup Anda tetap terjaga.',
                'content'       => '<p>Di era modern yang serba cepat, stres menjadi salah satu tantangan kesehatan yang paling umum dihadapi. Mengelola stres dengan baik sangat penting untuk kesejahteraan mental dan fisik.</p><h3>5 Cara Mengelola Stres</h3><ol><li><strong>Olahraga teratur</strong> – Aktivitas fisik membantu melepaskan endorfin yang meningkatkan suasana hati</li><li><strong>Meditasi dan pernapasan dalam</strong> – Teknik ini terbukti menurunkan kadar kortisol (hormon stres)</li><li><strong>Tidur yang cukup</strong> – Tidur 7-9 jam per malam membantu pemulihan tubuh dan pikiran</li><li><strong>Berbicara dengan orang terpercaya</strong> – Berbagi masalah dapat meringankan beban pikiran</li><li><strong>Batasi paparan media sosial</strong> – Kurangi konsumsi konten negatif yang memperparah kecemasan</li></ol>',
                'status'        => 'published',
            ],
            [
                'category_slug' => 'diet-dan-nutrisi',
                'title'         => 'Panduan Gizi Seimbang untuk Hidup Lebih Sehat',
                'excerpt'       => 'Gizi seimbang bukan sekadar diet, melainkan pola makan berkelanjutan yang memenuhi semua kebutuhan nutrisi tubuh secara optimal.',
                'content'       => '<p>Gizi seimbang adalah kunci utama menjaga kesehatan jangka panjang. Tubuh membutuhkan berbagai nutrisi dalam jumlah yang tepat untuk dapat berfungsi dengan optimal.</p><h3>Komponen Gizi Seimbang</h3><ul><li><strong>Karbohidrat kompleks</strong> – Nasi merah, oat, ubi</li><li><strong>Protein</strong> – Daging tanpa lemak, ikan, kacang-kacangan, telur</li><li><strong>Lemak sehat</strong> – Alpukat, minyak zaitun, kacang almond</li><li><strong>Serat</strong> – Sayuran, buah-buahan, biji-bijian</li><li><strong>Vitamin dan mineral</strong> – Berasal dari variasi makanan yang beragam</li></ul><p>Ingat, tidak ada makanan "ajaib" yang bisa memenuhi semua kebutuhan gizi. Variasi dan keseimbangan adalah kuncinya.</p>',
                'status'        => 'published',
            ],
            [
                'category_slug' => 'kesehatan-anak',
                'title'         => 'Tips Menjaga Imunitas Anak agar Tidak Mudah Sakit',
                'excerpt'       => 'Sistem imun anak yang kuat adalah investasi terbaik untuk tumbuh kembangnya. Berikut tips praktis yang bisa Anda terapkan sehari-hari.',
                'content'       => '<p>Anak-anak rentan terhadap infeksi karena sistem imun mereka masih dalam proses perkembangan. Ada banyak cara yang dapat dilakukan orang tua untuk membantu memperkuat daya tahan tubuh anak.</p><h3>Tips Memperkuat Imunitas Anak</h3><ul><li>Pastikan anak mendapat vaksinasi sesuai jadwal</li><li>Berikan makanan bergizi dengan banyak sayur dan buah</li><li>Pastikan anak tidur cukup sesuai usianya</li><li>Ajarkan kebiasaan cuci tangan yang benar</li><li>Batasi paparan asap rokok dan polusi</li><li>Dorong anak untuk aktif bermain di luar rumah</li></ul>',
                'status'        => 'published',
            ],
            [
                'category_slug' => 'gaya-hidup-sehat',
                'title'         => 'Mulai Olahraga dari Nol: Panduan untuk Pemula',
                'excerpt'       => 'Memulai kebiasaan olahraga bisa terasa berat di awal. Panduan ini akan membantu Anda memulai perjalanan aktif dengan cara yang aman dan menyenangkan.',
                'content'       => '<p>Olahraga teratur adalah salah satu kebiasaan terbaik yang bisa Anda tanamkan untuk kesehatan jangka panjang. Bagi pemula, kuncinya adalah memulai perlahan dan konsisten.</p><h3>Langkah Memulai Olahraga untuk Pemula</h3><ol><li><strong>Tetapkan tujuan yang realistis</strong> – Mulai dengan target kecil seperti 15-20 menit, 3 kali seminggu</li><li><strong>Pilih aktivitas yang Anda nikmati</strong> – Berjalan, bersepeda, renang, atau senam</li><li><strong>Lakukan pemanasan</strong> – Selalu mulai dengan pemanasan 5-10 menit</li><li><strong>Tingkatkan intensitas bertahap</strong> – Jangan langsung terlalu keras di awal</li><li><strong>Istirahat yang cukup</strong> – Beri waktu tubuh untuk pulih antar sesi olahraga</li></ol>',
                'status'        => 'published',
            ],
        ];

        foreach ($articles as $data) {
            $category = Category::where('slug', $data['category_slug'])->first();
            if (!$category || !$admin) continue;

            $slug = Str::slug($data['title']);
            Article::firstOrCreate(['slug' => $slug], [
                'user_id'          => $admin->id,
                'category_id'      => $category->id,
                'title'            => $data['title'],
                'slug'             => $slug,
                'excerpt'          => $data['excerpt'],
                'content'          => $data['content'],
                'meta_description' => $data['excerpt'],
                'status'           => 'published',
                'published_at'     => now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
