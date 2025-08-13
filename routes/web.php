<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group (function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');});
    Route::get('/data_barang', [BarangController::class, 'index'])->name('data_barang.index');
    Route::get('/data_ruangan', [RuanganController::class, 'index'])->name('data_ruangan.index');
    Route::get('/data_users', [UsersController::class, 'index'])->name('data_users.index');

Route::get('/otp', function (Request $request) {
    $email = session('otp_email', 'example@gmail.com');
    return view('auth.otp', ['email' => $email]);
})->name('otp');

Route::get('/otp/back-to-register', function () {
    // Logout user dan clear session OTP
    auth()->logout();
    session()->forget(['otp', 'otp_email', 'otp_expired']);
    return redirect()->route('register');
})->name('otp.back-to-register');

Route::get('/otp-success', function () {
    return view('auth.otp-success');
})->name('otp.success');

Route::post('/otp', function (Request $request) {
    $request->validate([
        'otp1' => 'required|numeric|digits:1',
        'otp2' => 'required|numeric|digits:1',
        'otp3' => 'required|numeric|digits:1',
        'otp4' => 'required|numeric|digits:1',
    ]);
    $inputOtp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;
    $sessionOtp = session('otp');
    $expired = session('otp_expired');
    if (now()->timestamp > $expired) {
        return back()->withErrors(['otp' => 'Kode OTP sudah expired, silakan klik resend OTP!']);
    }
    if ($inputOtp == $sessionOtp) {
        // OTP benar, tandai email sebagai terverifikasi agar bisa melewati middleware 'verified'
        $user = auth()->user();
        if ($user) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }
        session()->forget(['otp', 'otp_email', 'otp_expired']);
        return redirect()->route('otp.success');
    } else {
        return back()->withErrors(['otp' => 'Kode OTP salah!']);
    }
});

Route::post('/otp/resend', function (Request $request) {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('register');
    }
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
});

Route::resource('data_barang', BarangController::class);
Route::resource('data_ruangan', RuanganController::class);
Route::resource('data_users', UsersController::class);
require __DIR__.'/auth.php';
