<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



Route::get('/', function () {
    return view('welcome');
});

// Register khusus untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Dashboard berdasarkan role
Route::middleware(['auth', 'verified', 'otp.verified'])->group(function () {
    // Dashboard untuk semua role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route untuk admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('users', UserController::class);
    });
    
    // Route untuk admin dan user input
    Route::middleware(['admin_or_user_input'])->group(function () {
        Route::resource('data_barang', BarangController::class);
        Route::resource('data_ruangan', RuanganController::class);
    });
    
    // Profile untuk semua role
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Operasional Routes untuk admin dan user operasional
Route::prefix('operasional')->middleware(['auth', 'verified', 'otp.verified', 'admin_or_user_operasional'])->group(function () {
    // Barang Masuk
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang_masuk.index');
    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang_masuk.store');
    Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy'])->name('barang_masuk.destroy');
    
    // Barang Keluar
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang_keluar.index');
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang_keluar.store');
    Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barang_keluar.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/otp', function (Request $request) {
        
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        
        $email = session('otp_email', $request->user()->email);
        return view('auth.otp', ['email' => $email]);
    })->name('otp');

    Route::get('/otp/back-to-register', function () {
        
        auth()->logout();
        session()->forget(['otp', 'otp_email', 'otp_expired']);
        return redirect()->route('register');
    })->name('otp.back-to-register');

    Route::post('/otp', function (Request $request) {
    
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        
        $request->validate([
            'otp1' => 'required|numeric|digits:1',
            'otp2' => 'required|numeric|digits:1',
            'otp3' => 'required|numeric|digits:1',
            'otp4' => 'required|numeric|digits:1',
        ]);
        
        $inputOtp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;
        $sessionOtp = session('otp');
        $expired = session('otp_expired');
        
        if (!$sessionOtp) {
            return redirect()->route('otp')->withErrors(['otp' => 'Kode OTP tidak ditemukan. Silakan request OTP baru.']);
        }
        
        if (now()->timestamp > $expired) {
            return redirect()->route('otp')->withErrors(['otp' => 'Kode OTP sudah expired, silakan klik resend OTP!']);
        }
        
        if ($inputOtp == $sessionOtp) {
            // OTP benar, tandai email sebagai terverifikasi
            $user = $request->user();
            $user->forceFill(['email_verified_at' => now()])->save();
            session()->forget(['otp', 'otp_email', 'otp_expired']);
            return redirect()->route('otp.success');
        } else {
            return redirect()->route('otp')->withErrors(['otp' => 'Kode OTP salah!']);
        }
    });

    Route::post('/otp/resend', function (Request $request) {
        // Cek apakah user sudah terverifikasi
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }
        
        $user = $request->user();
        $otp = random_int(1000, 9999);
        session(['otp' => $otp, 'otp_email' => $user->email, 'otp_expired' => now()->addMinute()->timestamp]);
        
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($user, $otp));
            
            // Log OTP untuk debugging
            \Log::info('OTP resend to ' . $user->email . ': ' . $otp);
            
            return redirect()->route('otp')->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            \Log::error('Failed to resend OTP: ' . $e->getMessage());
            return redirect()->route('otp')->with('error', 'Gagal mengirim OTP. Silakan coba lagi.');
        } 
    });
});

Route::get('/otp-success', function () {
    // Hanya bisa diakses jika sudah terverifikasi
    if (!auth()->check() || !auth()->user()->hasVerifiedEmail()) {
        return redirect()->route('otp');
    }
    return view('auth.otp-success');
})->name('otp.success');

require __DIR__.'/auth.php';
