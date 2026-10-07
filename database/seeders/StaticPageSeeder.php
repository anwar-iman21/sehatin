<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug'    => 'tentang-sehatin',
                'title'   => 'Tentang SEHATIN',
                'content' => '<h2>Mengenal SEHATIN</h2>
<p>SEHATIN adalah platform informasi kesehatan digital yang didedikasikan untuk membantu masyarakat Indonesia mendapatkan akses mudah terhadap informasi kesehatan yang akurat, terpercaya, dan mudah dipahami.</p>

<h3>Visi Kami</h3>
<p>Menjadi portal referensi kesehatan terdepan yang memberdayakan masyarakat Indonesia untuk membuat keputusan kesehatan yang lebih baik melalui literasi kesehatan yang kuat.</p>

<h3>Misi Kami</h3>
<ul>
<li>Menyajikan konten kesehatan yang akurat dan berbasis bukti ilmiah</li>
<li>Membuat informasi kesehatan mudah dipahami oleh masyarakat umum</li>
<li>Mendukung peningkatan literasi kesehatan masyarakat Indonesia</li>
<li>Menyediakan referensi sehat yang dapat diakses kapan saja dan di mana saja</li>
</ul>

<h3>Komitmen Kami</h3>
<p>Setiap konten yang dipublikasikan di SEHATIN melalui proses kurasi yang ketat. Kami berkomitmen untuk selalu menyajikan informasi yang bertanggung jawab dan tidak menyesatkan.</p>

<div class="disclaimer-box">
<strong>⚠️ Penting:</strong> Informasi di SEHATIN bersifat edukatif dan tidak menggantikan diagnosis atau konsultasi dengan tenaga kesehatan profesional. Untuk kondisi medis yang serius, selalu berkonsultasi dengan dokter Anda.
</div>',
            ],
            [
                'slug'    => 'kebijakan-privasi',
                'title'   => 'Kebijakan Privasi',
                'content' => '<p><em>Terakhir diperbarui: ' . now()->format('d F Y') . '</em></p>

<h2>Kebijakan Privasi SEHATIN</h2>
<p>SEHATIN menghormati privasi Anda dan berkomitmen untuk melindungi data pribadi yang Anda berikan kepada kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi Anda.</p>

<h3>1. Informasi yang Kami Kumpulkan</h3>
<p>Kami dapat mengumpulkan informasi berikut:</p>
<ul>
<li>Nama dan alamat email saat Anda mendaftar akun</li>
<li>Informasi profil Google jika Anda login menggunakan akun Google</li>
<li>Data penggunaan website untuk analitik jika fitur tersebut digunakan dan Anda menyetujuinya</li>
</ul>

<h3>Cookie dan Penyimpanan di Browser</h3>
<p>SEHATIN menggunakan cookie esensial untuk menjaga sesi, keamanan, login, dan pilihan bahasa. Pilihan Anda pada banner cookie (menerima semua cookie atau hanya cookie esensial) disimpan di penyimpanan lokal browser agar banner tidak terus muncul. Pilihan ini dapat diubah kapan saja melalui tautan Pengaturan Cookie di footer. Jika fitur cookie opsional seperti analitik diaktifkan, pilihan Anda akan dihormati sebelum cookie tersebut digunakan. Menghapus data browser dapat mengatur ulang pilihan ini.</p>

<h3>2. Penggunaan Informasi</h3>
<p>Informasi yang Anda berikan digunakan untuk:</p>
<ul>
<li>Mengelola akun pengguna Anda</li>
<li>Menyajikan konten yang relevan</li>
<li>Meningkatkan layanan dan pengalaman pengguna</li>
<li>Berkomunikasi dengan Anda mengenai pembaruan layanan</li>
</ul>

<h3>3. Keamanan Data</h3>
<p>Kami mengimplementasikan langkah-langkah keamanan teknis dan organisasi untuk melindungi data Anda dari akses tidak sah, pengungkapan, atau perusakan.</p>

<h3>4. Tidak Ada Penjualan Data</h3>
<p>SEHATIN tidak menjual, menyewakan, atau membagikan data pribadi Anda kepada pihak ketiga untuk tujuan pemasaran.</p>

<h3>5. Hubungi Kami</h3>
<p>Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi tim kami melalui halaman kontak yang tersedia.</p>',
            ],
            [
                'slug'    => 'syarat-dan-ketentuan',
                'title'   => 'Syarat dan Ketentuan',
                'content' => '<p><em>Terakhir diperbarui: ' . now()->format('d F Y') . '</em></p>

<h2>Syarat dan Ketentuan Penggunaan SEHATIN</h2>
<p>Dengan mengakses dan menggunakan platform SEHATIN, Anda menyetujui syarat dan ketentuan berikut. Harap baca dengan seksama sebelum menggunakan layanan kami.</p>

<h3>1. Penerimaan Ketentuan</h3>
<p>Penggunaan website SEHATIN berarti Anda setuju untuk terikat oleh Syarat dan Ketentuan ini, Kebijakan Privasi, serta semua peraturan yang berlaku.</p>

<h3>2. Tujuan Informatif</h3>
<p>Seluruh konten di SEHATIN disediakan untuk tujuan informasi dan edukasi semata. <strong>SEHATIN bukan pengganti layanan medis profesional.</strong></p>
<div class="disclaimer-box">
⚠️ Informasi di SEHATIN bersifat edukatif dan tidak menggantikan diagnosis atau konsultasi dengan tenaga kesehatan. Selalu konsultasikan kondisi kesehatan Anda dengan dokter atau tenaga medis yang berkualifikasi.
</div>

<h3>3. Akun Pengguna</h3>
<ul>
<li>Anda bertanggung jawab menjaga kerahasiaan akun Anda</li>
<li>Anda tidak boleh berbagi akun dengan orang lain</li>
<li>Segala aktivitas yang terjadi melalui akun Anda menjadi tanggung jawab Anda</li>
</ul>

<h3>4. Konten dan Hak Kekayaan Intelektual</h3>
<p>Seluruh konten di SEHATIN, termasuk artikel, desain, dan logo, adalah milik SEHATIN dan dilindungi oleh hak cipta. Dilarang menyalin, mendistribusikan, atau menggunakan konten tanpa izin tertulis.</p>

<h3>5. Batasan Tanggung Jawab</h3>
<p>SEHATIN tidak bertanggung jawab atas kerugian yang timbul akibat penggunaan atau ketidakmampuan menggunakan layanan kami, termasuk kerugian yang timbul dari keputusan medis berdasarkan informasi di platform ini.</p>

<h3>6. Perubahan Ketentuan</h3>
<p>SEHATIN berhak mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan diberitahukan melalui website dan berlaku sejak tanggal publikasi.</p>',
            ],
        ];

        foreach ($pages as $page) {
            StaticPage::firstOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
