<x-guest-layout>
    <div class="flex flex-col items-center justify-center w-full min-h-[80vh]">
        <div class="w-full max-w-md flex flex-col items-center py-24 px-4">
            <h2 class="text-2xl font-bold text-gray-700 mb-2 text-center">Sign Up Berhasil!!</h2>
            <p class="text-gray-500 text-center mb-10">Silahkan lanjutkan untuk menggunakan fitur</p>
            <form method="GET" action="{{ url('/dashboard') }}" class="w-full flex flex-col items-center">
                <button type="submit" style="background-color: #58C1D1;" class="w-full py-4 rounded-full text-white text-lg font-bold mb-6 transition hover:opacity-90 shadow-none">Confirm</button>
            </form>
        </div>
    </div>
</x-guest-layout>

