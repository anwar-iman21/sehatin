<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HealthGuideController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HealthToolsController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Language Switcher
|--------------------------------------------------------------------------
*/
Route::post('/lang/{locale}', [LanguageController::class, 'switch'])
    ->middleware('throttle:30,1')
    ->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::get('/register/session', [AuthController::class, 'refreshRegisterSession'])->name('register.session');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');

    // Google OAuth
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/offline', fn () => response()->view('pages.offline'))->name('offline');
Route::get('/cari', [SearchController::class, 'index'])->name('search.index');
Route::get('/api/cari/saran', [SearchController::class, 'suggestions'])->name('search.suggestions');
Route::get('/dampak-sdg', [HealthToolsController::class, 'sdg'])->name('sdg');
Route::get('/kalkulator-bmi', [HealthToolsController::class, 'bmi'])->name('health-tools.bmi');
Route::get('/kuis-kesehatan-mental', [HealthToolsController::class, 'mentalHealthQuiz'])->name('health-tools.mental-quiz');
Route::get('/konsultasi', [HealthToolsController::class, 'consultation'])->name('consultation.index');
Route::get('/komunitas', [CommunityController::class, 'index'])->name('community.index');
Route::get('/komunitas/{thread}', [CommunityController::class, 'show'])->whereNumber('thread')->name('community.show');

Route::middleware('auth')->group(function () {
    Route::post('/api/konsultasi', [HealthToolsController::class, 'chat'])->middleware('throttle:10,1')->name('consultation.chat');
    Route::get('/api/konsultasi/pesan', [HealthToolsController::class, 'consultationMessages'])->middleware('throttle:120,1')->name('consultation.messages');
    Route::post('/artikel/{article}/bookmark', [ArticleController::class, 'toggleBookmark'])->name('artikel.bookmark');
    Route::delete('/artikel/{article}/bookmark', [ArticleController::class, 'removeBookmark'])->name('artikel.bookmark.remove');
    Route::delete('/dashboard/riwayat/{history}', function (Illuminate\Http\Request $request, App\Models\SearchHistory $history) {
        abort_unless($history->user_id === $request->user()->id, 403);
        $history->delete();
        return back()->with('success', __('app.history_deleted'));
    })->name('profile.history.destroy');
    Route::delete('/dashboard/riwayat', function (Illuminate\Http\Request $request) {
        $request->user()->searchHistories()->delete();
        return back()->with('success', __('app.history_cleared'));
    })->name('profile.history.clear');
    Route::post('/komunitas', [CommunityController::class, 'store'])->name('community.store');
    Route::post('/komunitas/{thread}/balasan', [CommunityController::class, 'reply'])->whereNumber('thread')->name('community.reply');
    Route::post('/komunitas/laporkan', [CommunityController::class, 'report'])->name('community.report');
});

/*
|--------------------------------------------------------------------------
| User Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| Frontend Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Artikel
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel.index');
Route::get('/artikel/kategori/{category}', [ArticleController::class, 'byCategory'])->name('artikel.category');
Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('artikel.show');

// Info kesehatan
Route::get('/layanan/info-obat', [DrugController::class, 'index'])->name('obat.index');
Route::get('/layanan/info-obat/{drug}', [DrugController::class, 'show'])->name('obat.show');
Route::get('/layanan/info-penyakit', [DiseaseController::class, 'index'])->name('penyakit.index');
Route::get('/layanan/info-penyakit/{disease}', [DiseaseController::class, 'show'])->name('penyakit.show');
Route::get('/layanan/panduan-kesehatan', [HealthGuideController::class, 'index'])->name('panduan.index');
Route::get('/layanan/panduan-kesehatan/{guide}', [HealthGuideController::class, 'show'])->name('panduan.show');

// Pusat layanan kesehatan
Route::get('/layanan', [ServiceController::class, 'index'])->name('layanan.index');
Route::get('/layanan/detail/{service}', [ServiceController::class, 'show'])->name('layanan.detail');
Route::get('/layanan/{service}', [ServiceController::class, 'show'])->name('layanan.show');

// FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq');

// Static Pages
Route::get('/tentang-sehatin', [StaticPageController::class, 'show'])->defaults('slug', 'tentang-sehatin')->name('tentang');
Route::get('/kebijakan-privasi', [StaticPageController::class, 'show'])->defaults('slug', 'kebijakan-privasi')->name('kebijakan-privasi');
Route::get('/syarat-dan-ketentuan', [StaticPageController::class, 'show'])->defaults('slug', 'syarat-dan-ketentuan')->name('syarat-ketentuan');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [Admin\DashboardController::class, 'index']);
    Route::get('/komunitas/moderasi', [Admin\CommunityModerationController::class, 'index'])->name('community.moderation');
    Route::post('/komunitas/laporan/{report}/selesai', [Admin\CommunityModerationController::class, 'resolve'])->name('community.reports.resolve');
    Route::post('/komunitas/laporan/{report}/hapus-konten', [Admin\CommunityModerationController::class, 'destroyReportedContent'])->name('community.reports.destroy-content');
    Route::post('/komunitas/dokter/{user}/verifikasi', [Admin\CommunityModerationController::class, 'verifyDoctor'])->name('community.doctors.verify');
    Route::get('/konsultasi', [Admin\ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/konsultasi/pembaruan', [Admin\ConsultationController::class, 'updates'])->middleware('throttle:120,1')->name('consultations.updates');
    Route::delete('/konsultasi/{user}', [Admin\ConsultationController::class, 'destroy'])->whereNumber('user')->name('consultations.destroy');
    Route::get('/konsultasi/{user}/pesan', [Admin\ConsultationController::class, 'messages'])->whereNumber('user')->middleware('throttle:120,1')->name('consultations.messages');
    Route::get('/konsultasi/{user}', [Admin\ConsultationController::class, 'show'])->whereNumber('user')->name('consultations.show');
    Route::post('/konsultasi/{user}', [Admin\ConsultationController::class, 'reply'])->whereNumber('user')->name('consultations.reply');

    // Profil admin
    Route::get('/profil', [Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profil/edit', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profil/password', [Admin\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Artikel
    Route::resource('artikel', Admin\ArticleController::class);
    Route::post('artikel/{artikel}/toggle-status', [Admin\ArticleController::class, 'toggleStatus'])
        ->name('artikel.toggle-status');

    // Kategori
    Route::resource('kategori', Admin\CategoryController::class);

    // Layanan
    Route::resource('layanan', Admin\ServiceController::class);

    // Informasi kesehatan
    Route::resource('obat', Admin\DrugController::class)->except('show');
    Route::post('obat/{obat}/toggle', [Admin\DrugController::class, 'toggleActive'])->name('obat.toggle');
    Route::resource('penyakit', Admin\DiseaseController::class)->except('show');
    Route::post('penyakit/{penyakit}/toggle', [Admin\DiseaseController::class, 'toggleActive'])->name('penyakit.toggle');
    Route::resource('panduan', Admin\HealthGuideController::class)->except('show');
    Route::post('panduan/{panduan}/toggle', [Admin\HealthGuideController::class, 'toggleActive'])->name('panduan.toggle');

    // FAQ
    Route::resource('faq', Admin\FaqController::class);

    // Halaman Statis
    Route::get('halaman', [Admin\StaticPageController::class, 'index'])->name('halaman.index');
    Route::get('halaman/{halaman}/edit', [Admin\StaticPageController::class, 'edit'])->name('halaman.edit');
    Route::put('halaman/{halaman}', [Admin\StaticPageController::class, 'update'])->name('halaman.update');
});
