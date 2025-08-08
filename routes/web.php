<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/otp', function (Request $request) {
    $email = session('otp_email', 'example@gmail.com');
    return view('auth.otp', ['email' => $email]);
})->name('otp');

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
        // OTP benar, bisa lanjutkan proses (misal redirect dashboard)
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
    \Illuminate\Support\Facades\Mail::raw('Kode OTP Anda: ' . $otp, function ($message) use ($user) {
        $message->to($user->email)
            ->subject('Kode OTP Verifikasi');
    });
    return redirect()->route('otp')->with('status', 'Kode OTP baru telah dikirim ke email Anda.');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
