<x-guest-layout>
    <div class="flex flex-col items-center justify-center w-full min-h-[80vh]">
        <div class="w-full max-w-md flex flex-col items-center py-24 px-4">
            <h2 class="text-2xl font-bold text-gray-700 mb-2 text-center">Check your email</h2>
            <p class="text-gray-500 text-center mb-1">Tolong enter digit verifikasi kode yang kita kirim ke</p>
            <p class="text-gray-700 font-semibold text-center mb-8">{{ $email }}</p>



            <!-- OTP Form -->
            <form method="POST" action="{{ url('/otp') }}" class="w-full flex flex-col items-center">
                @csrf
                <div class="flex items-center justify-between w-72 mb-8">
                    <input name="otp1" type="text" inputmode="numeric" maxlength="1" class="otp-input w-16 h-16 rounded-full bg-gray-200 text-center text-xl outline-none focus:ring-2 focus:ring-cyan-400"/>
                    <input name="otp2" type="text" inputmode="numeric" maxlength="1" class="otp-input w-16 h-16 rounded-full bg-gray-200 text-center text-xl outline-none focus:ring-2 focus:ring-cyan-400"/>
                    <input name="otp3" type="text" inputmode="numeric" maxlength="1" class="otp-input w-16 h-16 rounded-full bg-gray-200 text-center text-xl outline-none focus:ring-2 focus:ring-cyan-400"/>
                    <input name="otp4" type="text" inputmode="numeric" maxlength="1" class="otp-input w-16 h-16 rounded-full bg-gray-200 text-center text-xl outline-none focus:ring-2 focus:ring-cyan-400"/>
                </div>

                @error('otp')
                    <div class="text-red-600 text-sm mb-4">{{ $message }}</div>
                @enderror
                @if (session('status'))
                    <div class="text-green-600 text-sm mb-4">{{ session('status') }}</div>
                @endif
                @if (session('error'))
                    <div class="text-red-600 text-sm mb-4">{{ session('error') }}</div>
                @endif
                @if (session('info'))
                    <div class="text-blue-600 text-sm mb-4 text-center">{{ session('info') }}</div>
                @endif

                <button type="submit" style="background-color: #58C1D1;" class="w-full py-4 rounded-full text-white text-lg font-bold mb-6 transition hover:opacity-90 shadow-none">Confirm</button>
            </form>

            <!-- Resend OTP -->
            <form method="POST" action="{{ url('/otp/resend') }}" class="w-full flex flex-col items-center">
                @csrf
                <button id="resendBtn" type="submit" class="w-full py-4 rounded-full text-gray-600 text-lg font-semibold mb-2 bg-gray-200 cursor-not-allowed" disabled>Resend OTP</button>
                <p class="text-gray-500 text-sm mb-8">Tidak mendapatkan email? Coba lagi dalam <span id="timer">01:00</span></p>
            </form>

            <a href="{{ route('otp.back-to-register') }}" class="text-gray-600 flex items-center gap-2"><span>←</span> back</a>
        </div>
    </div>

    @php
        $remaining = max(0, (int) (session('otp_expired', now()->timestamp) - now()->timestamp));
    @endphp

    <script>
        (function () {
            const inputs = Array.from(document.querySelectorAll('.otp-input'));
            inputs.forEach((input, idx) => {
                input.addEventListener('input', (e) => {
                    e.target.value = e.target.value.replace(/\D/g,'').slice(0,1);
                    if (e.target.value && idx < inputs.length - 1) inputs[idx + 1].focus();
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                        inputs[idx - 1].focus();
                    }
                });
            });
            if (inputs.length) inputs[0].focus();

            let remaining = {{ $remaining }}; // seconds
            const timerEl = document.getElementById('timer');
            const resendBtn = document.getElementById('resendBtn');

            function format(sec){
                const m = String(Math.floor(sec/60)).padStart(2,'0');
                const s = String(sec%60).padStart(2,'0');
                return `${m}:${s}`;
            }

            function tick(){
                if (remaining <= 0){
                    timerEl.textContent = '00:00';
                    resendBtn.classList.remove('cursor-not-allowed','bg-gray-200','text-gray-600');
                    resendBtn.classList.add('bg-gray-300','text-gray-800','hover:opacity-90');
                    resendBtn.disabled = false;
                    return;
                }
                timerEl.textContent = format(remaining);
                remaining -= 1;
                setTimeout(tick, 1000);
            }
            tick();
        })();
    </script>
</x-guest-layout>


