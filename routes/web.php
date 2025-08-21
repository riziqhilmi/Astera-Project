<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::middleware(['admin'])->group(function () {
        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('users', UserController::class);
    });
    
    Route::middleware(['admin_or_user'])->group(function () {
        Route::resource('data_barang', BarangController::class);
        Route::resource('data_ruangan', RuanganController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notification routes (Web)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::patch('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Operasional Routes
Route::prefix('operasional')->middleware(['auth', 'admin_or_user_operasional'])->group(function () {
    // Barang Masuk
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang_masuk.store');
    Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy'])->name('barang_masuk.destroy');
    
    // Barang Keluar
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang_keluar.index');
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang_keluar.store');
    Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barang_keluar.destroy');
    
    // Pemeliharaan
    Route::get('/pemeliharaan', [PemeliharaanController::class, 'index'])->name('pemeliharaan.index');
    Route::get('/pemeliharaan/create', [PemeliharaanController::class, 'create'])->name('pemeliharaan.create');
    Route::post('/pemeliharaan', [PemeliharaanController::class, 'store'])->name('pemeliharaan.store');
    Route::get('/pemeliharaan/{pemeliharaan}/edit', [PemeliharaanController::class, 'edit'])->name('pemeliharaan.edit');
    Route::put('/pemeliharaan/{pemeliharaan}', [PemeliharaanController::class, 'update'])->name('pemeliharaan.update');
    Route::delete('/pemeliharaan/{pemeliharaan}', [PemeliharaanController::class, 'destroy'])->name('pemeliharaan.destroy');
    
    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('peminjaman.kembali');
    Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
});

// ✅ Notification routes dengan prefix "/api"
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/count', [NotificationController::class, 'count']);
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead']);
});

require __DIR__.'/auth.php';
