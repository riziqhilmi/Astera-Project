<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user_input'
        ]);

        event(new Registered($user));
        Auth::login($user);

        $otp = random_int(1000, 9999);
        session(['otp' => $otp, 'otp_email' => $user->email, 'otp_expired' => now()->addMinute()->timestamp]);

        try {
            Mail::to($user->email)->send(new \App\Mail\OtpVerificationMail($user, $otp));
            
            // Log OTP untuk debugging
            \Log::info('OTP sent to ' . $user->email . ': ' . $otp);
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP: ' . $e->getMessage());
            // Tetap lanjutkan meski email gagal - OTP akan ditampilkan di halaman
        }

        // Redirect ke halaman OTP setelah register
        return redirect()->route('otp')->with('info', 'Kode OTP telah dikirim ke email Anda. Silakan cek email dan masukkan kode OTP.');
    }
}
