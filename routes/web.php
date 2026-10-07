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
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::get('/register/session', [AuthController::class, 'refreshRegisterSession'])->name('register.session');
    Route::post('/register', [AuthController::class, 'register']);

    // Google OAuth
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

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
