# SEHATIN - Portal Informasi Kesehatan

SEHATIN adalah aplikasi web portal informasi kesehatan berbasis Laravel yang menyediakan artikel edukasi, direktori obat, informasi penyakit, panduan hidup sehat, FAQ, halaman statis, autentikasi pengguna, serta panel admin untuk mengelola seluruh konten. Project ini disiapkan agar mudah dijalankan saat demo penjurian maupun dikembangkan lebih lanjut.

## Daftar Isi

- [Ringkasan Project](#ringkasan-project)
- [Teknologi](#teknologi)
- [Fitur Utama](#fitur-utama)
- [Akun Demo](#akun-demo)
- [Panduan Instalasi](#panduan-instalasi)
- [Panduan Demo untuk Juri](#panduan-demo-untuk-juri)
- [Struktur Halaman dan Route](#struktur-halaman-dan-route)
- [Laporan Detail Sistem](#laporan-detail-sistem)
- [Database](#database)
- [Struktur Folder Penting](#struktur-folder-penting)
- [Space Screenshot Tampilan](#space-screenshot-tampilan)
- [Troubleshooting](#troubleshooting)

## Ringkasan Project

| Item | Keterangan |
| --- | --- |
| Nama aplikasi | SEHATIN |
| Jenis aplikasi | Portal informasi kesehatan dan manajemen konten |
| Framework | Laravel 12 |
| Bahasa utama | PHP 8.2+, Blade, JavaScript, CSS |
| Database default | MySQL |
| Build asset | Vite + Tailwind CSS |
| Autentikasi | Login manual, register, logout, Google OAuth opsional |
| Hak akses | User dan Admin |

## Teknologi

- **Backend:** Laravel 12, PHP 8.2+, Eloquent ORM, Laravel Validation, Middleware.
- **Frontend:** Blade Template, Vite, Tailwind CSS.
- **Database:** MySQL dengan migration dan seeder.
- **Autentikasi:** Laravel Auth session dan Laravel Socialite untuk Google OAuth.
- **Testing:** PHPUnit melalui konfigurasi bawaan Laravel.
- **Asset & Storage:** Laravel public storage untuk upload thumbnail artikel.

## Fitur Utama

### 1. Landing Page dan Beranda

- Menampilkan ringkasan portal kesehatan SEHATIN.
- Menampilkan konten unggulan seperti artikel terbaru, kategori, layanan, dan informasi penting.
- Menjadi pintu masuk utama untuk user umum maupun juri saat demo.

### 2. Artikel Kesehatan

- Daftar artikel kesehatan yang sudah dipublikasikan.
- Detail artikel menggunakan slug agar URL lebih rapi dan mudah dibaca.
- Artikel dikelompokkan berdasarkan kategori.
- Artikel terkait ditampilkan pada halaman detail.
- Admin dapat membuat, mengubah, menghapus, mengunggah thumbnail, dan mengubah status artikel menjadi draft atau published.

### 3. Kategori Artikel

- Kategori membantu user menemukan artikel sesuai topik.
- Admin dapat mengelola data kategori dari panel admin.
- Setiap kategori memiliki slug, deskripsi, ikon, urutan tampil, dan status featured.

### 4. Layanan Kesehatan

- Halaman layanan berisi daftar layanan/informasi utama yang disediakan SEHATIN.
- Setiap layanan memiliki halaman detail.
- Admin dapat mengelola layanan, termasuk judul, deskripsi, ikon, urutan, dan status aktif.

### 5. Direktori Obat

- User dapat melihat daftar obat aktif.
- Fitur pencarian obat berdasarkan nama.
- Filter obat berdasarkan kategori: obat resep, obat bebas, dan obat bebas terbatas.
- Filter alfabet berdasarkan huruf awal nama obat.
- Detail obat berisi nama generik, bentuk obat, produsen, kandungan, indikasi, dosis, cara pakai, efek samping, kontraindikasi, peringatan, dan estimasi harga.
- Admin dapat melakukan CRUD data obat.

### 6. Informasi Penyakit

- User dapat melihat daftar penyakit aktif.
- Fitur pencarian penyakit berdasarkan nama.
- Detail penyakit berisi gambaran umum, gejala, penyebab, faktor risiko, diagnosis, pengobatan, pencegahan, dan kapan harus ke dokter.
- Admin dapat melakukan CRUD data penyakit.

### 7. Panduan Hidup Sehat

- Menampilkan panduan kesehatan dengan kategori seperti nutrisi, olahraga, mental, tidur, kebersihan, dan lainnya.
- User dapat memfilter panduan berdasarkan kategori.
- Detail panduan menampilkan ringkasan, isi panduan, estimasi waktu baca, tips, dan panduan terkait.
- Admin dapat melakukan CRUD data panduan kesehatan.

### 8. FAQ

- Halaman pertanyaan yang sering diajukan.
- Data FAQ diurutkan berdasarkan field order.
- Admin dapat menambah, mengubah, menghapus, dan mengaktifkan/nonaktifkan FAQ.

### 9. Halaman Statis

- Mendukung halaman statis seperti Tentang SEHATIN, Kebijakan Privasi, dan Syarat & Ketentuan.
- Konten halaman statis dapat dikelola dari panel admin.

### 10. Autentikasi dan Profil User

- User dapat register, login, logout, dan mengelola profil.
- User dapat mengubah data profil dan password.
- Tersedia Google OAuth sebagai opsi login/register jika credentials Google sudah dikonfigurasi.

### 11. Panel Admin

- Dashboard statistik konten.
- Manajemen artikel, kategori, layanan, FAQ, halaman statis, obat, penyakit, panduan kesehatan, dan profil admin.
- Middleware admin memastikan hanya akun dengan role admin yang dapat mengakses panel admin.

### 12. Multi Bahasa

- Aplikasi menyediakan file bahasa Indonesia dan Inggris.
- User dapat mengganti bahasa melalui route `/lang/{locale}`.

## Akun Demo

Seeder menyediakan akun berikut untuk kebutuhan demo:

| Role | Email | Password | Keterangan |
| --- | --- | --- | --- |
| Admin | `admin@sehatin.id` | `admin123` | Akses panel admin dan manajemen konten |
| User | `user@sehatin.id` | `user123` | Akses sebagai pengguna biasa |

> Catatan: Akun demo tersedia setelah menjalankan `php artisan migrate --seed`.

## Panduan Instalasi

### Prasyarat

Pastikan perangkat demo sudah memiliki:

- PHP `^8.2`
- Composer
- Node.js dan npm
- MySQL/MariaDB
- Git
- Ekstensi PHP umum Laravel: `openssl`, `pdo`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, dan `curl`

### 1. Clone Repository

```bash
git clone <url-repository-sehatin>
cd sehatin
```

Jika project sudah diberikan dalam bentuk folder/ZIP, cukup ekstrak lalu masuk ke folder project:

```bash
cd sehatin
```

### 2. Install Dependency Backend

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Buat File Environment

```bash
cp .env.example .env
```

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buat database MySQL baru, contoh:

```sql
CREATE DATABASE sehatin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Sesuaikan konfigurasi berikut pada file `.env`:

```env
APP_NAME=SEHATIN
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sehatin
DB_USERNAME=root
DB_PASSWORD=
```

Jika MySQL lokal memiliki password, isi `DB_PASSWORD` sesuai konfigurasi perangkat.

### 7. Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

Perintah ini membuat tabel database dan mengisi data awal seperti user demo, kategori, artikel, layanan, FAQ, halaman statis, obat, penyakit, dan panduan kesehatan.

### 8. Buat Storage Link

```bash
php artisan storage:link
```

Perintah ini diperlukan agar file upload seperti thumbnail artikel dapat diakses dari browser.

### 9. Jalankan Aplikasi

Buka dua terminal terpisah.

Terminal 1 - Laravel server:

```bash
php artisan serve
```

Terminal 2 - Vite development server:

```bash
npm run dev
```

Akses aplikasi di browser:

```text
http://localhost:8000
```

### 10. Build Asset untuk Mode Produksi

Jika ingin demo tanpa Vite dev server, jalankan:

```bash
npm run build
```

Lalu jalankan Laravel server:

```bash
php artisan serve
```

## Konfigurasi Google OAuth Opsional

Google OAuth tidak wajib untuk demo utama. Jika ingin mengaktifkannya:

1. Buka Google Cloud Console.
2. Buat OAuth 2.0 Client ID untuk Web Application.
3. Tambahkan redirect URI berikut:

```text
http://localhost:8000/auth/google/callback
```

4. Isi variabel berikut di `.env`:

```env
GOOGLE_CLIENT_ID=isi-client-id
GOOGLE_CLIENT_SECRET=isi-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## Panduan Demo untuk Juri

### Alur Demo Singkat

1. Buka `http://localhost:8000` untuk melihat landing page SEHATIN.
2. Masuk ke menu artikel untuk melihat daftar artikel kesehatan.
3. Buka salah satu artikel untuk menunjukkan detail artikel dan artikel terkait.
4. Buka menu layanan, lalu coba fitur direktori obat, informasi penyakit, dan panduan hidup sehat.
5. Coba pencarian obat/penyakit dan filter kategori panduan.
6. Login sebagai user menggunakan `user@sehatin.id` / `user123`.
7. Buka halaman profil user dan tunjukkan fitur edit profil/password.
8. Logout, lalu login sebagai admin menggunakan `admin@sehatin.id` / `admin123`.
9. Buka `/admin` untuk melihat dashboard admin.
10. Demonstrasikan CRUD konten, misalnya membuat artikel baru atau mengubah status artikel dari draft ke published.

### Alur Demo Admin yang Disarankan

1. Login sebagai admin.
2. Buka dashboard untuk melihat statistik konten.
3. Masuk ke menu artikel.
4. Buat artikel baru dengan status `published`.
5. Upload thumbnail artikel jika diperlukan.
6. Buka halaman publik artikel untuk membuktikan konten langsung tampil.
7. Tunjukkan manajemen obat, penyakit, panduan, FAQ, layanan, dan halaman statis.

### Checklist Demo

- [ ] Server Laravel berjalan dengan `php artisan serve`.
- [ ] Asset frontend berjalan dengan `npm run dev` atau sudah dibuild dengan `npm run build`.
- [ ] Database sudah dimigrasi dan diseed.
- [ ] Akun admin dan user bisa login.
- [ ] Halaman publik dapat dibuka.
- [ ] Panel admin dapat diakses.
- [ ] CRUD konten berjalan.
- [ ] Upload thumbnail berjalan setelah `php artisan storage:link`.

## Struktur Halaman dan Route

### Halaman Publik

| URL | Fungsi |
| --- | --- |
| `/` | Beranda SEHATIN |
| `/artikel` | Daftar artikel kesehatan |
| `/artikel/{article}` | Detail artikel |
| `/artikel/kategori/{category}` | Artikel berdasarkan kategori |
| `/layanan` | Daftar layanan |
| `/layanan/detail/{service}` atau `/layanan/{service}` | Detail layanan |
| `/layanan/info-obat` | Direktori obat |
| `/layanan/info-obat/{drug}` | Detail obat |
| `/layanan/info-penyakit` | Daftar penyakit |
| `/layanan/info-penyakit/{disease}` | Detail penyakit |
| `/layanan/panduan-kesehatan` | Daftar panduan hidup sehat |
| `/layanan/panduan-kesehatan/{guide}` | Detail panduan hidup sehat |
| `/faq` | FAQ |
| `/tentang-sehatin` | Halaman tentang SEHATIN |
| `/kebijakan-privasi` | Halaman kebijakan privasi |
| `/syarat-dan-ketentuan` | Halaman syarat dan ketentuan |
| `/lang/{locale}` | Mengganti bahasa aplikasi |

### Autentikasi dan Profil

| URL | Fungsi |
| --- | --- |
| `/login` | Login user/admin |
| `/register` | Registrasi user |
| `/auth/google` | Redirect login Google |
| `/auth/google/callback` | Callback Google OAuth |
| `/logout` | Logout |
| `/profil` | Detail profil user |
| `/profil/edit` | Edit profil user |
| `/profil/password` | Update password user |

### Panel Admin

| URL | Fungsi |
| --- | --- |
| `/admin` atau `/admin/dashboard` | Dashboard admin |
| `/admin/artikel` | Manajemen artikel |
| `/admin/kategori` | Manajemen kategori |
| `/admin/layanan` | Manajemen layanan |
| `/admin/faq` | Manajemen FAQ |
| `/admin/halaman` | Manajemen halaman statis |
| `/admin/obat` | Manajemen data obat |
| `/admin/penyakit` | Manajemen data penyakit |
| `/admin/panduan` | Manajemen panduan kesehatan |
| `/admin/profil` | Profil admin |

## Laporan Detail Sistem

### Latar Belakang

Informasi kesehatan sering tersebar di banyak sumber sehingga user membutuhkan platform yang terstruktur, mudah diakses, dan memiliki konten yang dapat dikelola secara mandiri. SEHATIN dibuat sebagai portal informasi kesehatan yang menggabungkan edukasi artikel, informasi obat, penyakit, panduan hidup sehat, dan halaman bantuan dalam satu aplikasi web.

### Tujuan

- Menyediakan pusat informasi kesehatan yang mudah digunakan.
- Memudahkan admin dalam mengelola konten kesehatan.
- Menyediakan pengalaman pengguna yang rapi melalui pencarian, filter, kategori, dan halaman detail.
- Mendukung demo kompetisi dengan data awal dari seeder dan akun demo siap pakai.

### Sasaran Pengguna

- **Pengunjung umum:** membaca artikel, melihat layanan, mencari obat, mencari informasi penyakit, membaca panduan, dan melihat FAQ.
- **User terdaftar:** mengakses fitur umum dan mengelola profil pribadi.
- **Admin:** mengelola seluruh data dan konten aplikasi.

### Arsitektur Singkat

SEHATIN menggunakan pola MVC Laravel:

- **Model:** merepresentasikan data seperti `Article`, `Category`, `Drug`, `Disease`, `HealthGuide`, `Faq`, `Service`, `StaticPage`, dan `User`.
- **View:** menggunakan Blade di folder `resources/views` untuk tampilan publik, auth, profil, dan admin.
- **Controller:** mengatur alur request, validasi, query database, dan pemilihan view.
- **Middleware:** mengatur locale dan membatasi akses admin.
- **Migration & Seeder:** membuat struktur database dan data awal untuk demo.

### Hak Akses

| Role | Akses |
| --- | --- |
| Guest | Melihat halaman publik, artikel, layanan, obat, penyakit, panduan, FAQ, login, dan register |
| User | Semua akses guest, ditambah halaman profil dan update akun |
| Admin | Semua akses user, ditambah dashboard admin dan CRUD seluruh konten |

### Validasi dan Keamanan

- Password disimpan menggunakan hashing Laravel.
- Route admin dilindungi middleware `admin`.
- Form menggunakan CSRF protection bawaan Laravel.
- Upload thumbnail artikel divalidasi sebagai gambar dengan format `jpg`, `jpeg`, `png`, atau `webp` dan ukuran maksimal 2 MB.
- Konten publik hanya menampilkan data aktif/published sesuai konteks fitur.

### Manfaat Sistem

- Admin tidak perlu mengubah kode untuk memperbarui konten.
- User dapat menemukan informasi kesehatan lebih cepat melalui kategori, pencarian, filter, dan halaman detail.
- Data demo dapat dibuat ulang dengan migration dan seeder sehingga proses penilaian lebih stabil.

## Database

### Tabel Utama

| Tabel | Fungsi |
| --- | --- |
| `users` | Menyimpan akun user/admin, role, avatar, dan data Google OAuth |
| `categories` | Kategori artikel |
| `articles` | Artikel kesehatan |
| `services` | Layanan/informasi utama aplikasi |
| `faqs` | Pertanyaan yang sering diajukan |
| `static_pages` | Halaman statis |
| `drugs` | Direktori obat |
| `diseases` | Informasi penyakit |
| `health_guides` | Panduan hidup sehat |

### Seeder

Seeder yang tersedia:

- `UserSeeder`
- `CategorySeeder`
- `ServiceSeeder`
- `FaqSeeder`
- `StaticPageSeeder`
- `ArticleSeeder`
- `DrugSeeder`
- `DiseaseSeeder`
- `HealthGuideSeeder`

Untuk mengulang database dari awal:

```bash
php artisan migrate:fresh --seed
```

> Perhatian: perintah tersebut menghapus seluruh data lama dan membuat ulang database dari awal.

## Struktur Folder Penting

```text
app/
  Http/Controllers/        Controller publik, auth, profil, dan admin
  Http/Middleware/         Middleware admin dan locale
  Models/                  Model Eloquent
database/
  migrations/              Struktur tabel database
  seeders/                 Data awal untuk demo
lang/
  id/                      Terjemahan bahasa Indonesia
  en/                      Terjemahan bahasa Inggris
resources/
  views/                   Blade template publik, auth, profil, dan admin
routes/
  web.php                  Definisi route aplikasi web
public/
  images/                  Aset gambar publik
storage/
  app/public/              Lokasi file upload sebelum storage link
```

## Space Screenshot Tampilan

Gunakan bagian ini untuk menempelkan screenshot halaman aplikasi saat laporan dikumpulkan. Simpan gambar di folder dokumentasi, misalnya `docs/screenshots/`, lalu ganti placeholder path di bawah.

### 1. Landing Page

![Screenshot Landing Page](docs/screenshots/landing-page.png)

Keterangan: Tampilan awal SEHATIN yang memperkenalkan fitur utama portal kesehatan.

### 2. Daftar Artikel

![Screenshot Daftar Artikel](docs/screenshots/daftar-artikel.png)

Keterangan: Halaman daftar artikel kesehatan yang dapat dibaca oleh pengunjung.

### 3. Detail Artikel

![Screenshot Detail Artikel](docs/screenshots/detail-artikel.png)

Keterangan: Halaman detail artikel dengan konten lengkap dan artikel terkait.

### 4. Direktori Obat

![Screenshot Direktori Obat](docs/screenshots/direktori-obat.png)

Keterangan: Halaman daftar obat dengan fitur pencarian, filter kategori, dan filter alfabet.

### 5. Detail Obat

![Screenshot Detail Obat](docs/screenshots/detail-obat.png)

Keterangan: Halaman informasi lengkap obat, termasuk dosis, cara pakai, efek samping, dan peringatan.

### 6. Informasi Penyakit

![Screenshot Informasi Penyakit](docs/screenshots/informasi-penyakit.png)

Keterangan: Halaman daftar penyakit dengan fitur pencarian.

### 7. Detail Penyakit

![Screenshot Detail Penyakit](docs/screenshots/detail-penyakit.png)

Keterangan: Halaman detail penyakit berisi gejala, penyebab, diagnosis, pengobatan, dan pencegahan.

### 8. Panduan Hidup Sehat

![Screenshot Panduan Hidup Sehat](docs/screenshots/panduan-hidup-sehat.png)

Keterangan: Halaman panduan kesehatan dengan filter kategori.

### 9. Login dan Register

![Screenshot Login](docs/screenshots/login.png)

Keterangan: Halaman autentikasi user/admin.

### 10. Profil User

![Screenshot Profil User](docs/screenshots/profil-user.png)

Keterangan: Halaman profil pengguna untuk melihat dan memperbarui data akun.

### 11. Dashboard Admin

![Screenshot Dashboard Admin](docs/screenshots/dashboard-admin.png)

Keterangan: Dashboard admin yang menampilkan statistik konten dan artikel terbaru.

### 12. Manajemen Artikel Admin

![Screenshot Manajemen Artikel](docs/screenshots/manajemen-artikel.png)

Keterangan: Halaman admin untuk membuat, mengubah, menghapus, dan mengatur status artikel.

### 13. Manajemen Obat/Penyakit/Panduan

![Screenshot Manajemen Data Kesehatan](docs/screenshots/manajemen-data-kesehatan.png)

Keterangan: Halaman admin untuk mengelola data obat, penyakit, dan panduan kesehatan.

## Troubleshooting

### 1. Halaman Tidak Bisa Dibuka

Pastikan server Laravel berjalan:

```bash
php artisan serve
```

Lalu buka `http://localhost:8000`.

### 2. Tampilan CSS Tidak Muncul

Jalankan Vite:

```bash
npm run dev
```

Atau build asset:

```bash
npm run build
```

### 3. Error Database Connection

Periksa konfigurasi `.env`, pastikan MySQL berjalan, database `sehatin` sudah dibuat, dan username/password benar.

### 4. Tabel Belum Ada atau Data Demo Kosong

Jalankan:

```bash
php artisan migrate --seed
```

Jika ingin reset total:

```bash
php artisan migrate:fresh --seed
```

### 5. Gambar Upload Tidak Muncul

Jalankan:

```bash
php artisan storage:link
```

### 6. Login Google Tidak Berjalan

Pastikan `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, dan `GOOGLE_REDIRECT_URI` sudah benar di `.env`. Untuk demo cepat, gunakan login email/password dari akun demo.

## Perintah Penting

| Perintah | Fungsi |
| --- | --- |
| `composer install` | Install dependency PHP |
| `npm install` | Install dependency frontend |
| `php artisan key:generate` | Membuat application key |
| `php artisan migrate --seed` | Membuat tabel dan data awal |
| `php artisan migrate:fresh --seed` | Reset database dan isi ulang data demo |
| `php artisan storage:link` | Membuat akses publik ke file upload |
| `php artisan serve` | Menjalankan server Laravel |
| `npm run dev` | Menjalankan Vite development server |
| `npm run build` | Build asset production |
| `php artisan route:list` | Melihat daftar route aplikasi |
| `php artisan test` | Menjalankan test |

## Catatan Demo

- Gunakan akun admin untuk menunjukkan kemampuan manajemen konten.
- Gunakan akun user untuk menunjukkan halaman profil pengguna.
- Google OAuth bersifat opsional, sehingga demo utama tetap dapat berjalan tanpa konfigurasi Google Cloud.
- Jika waktu demo terbatas, prioritaskan beranda, artikel, direktori obat, informasi penyakit, panduan hidup sehat, dan dashboard admin.

---

SEHATIN dikembangkan sebagai solusi portal informasi kesehatan yang informatif, mudah digunakan, dan mudah dikelola melalui panel admin.
