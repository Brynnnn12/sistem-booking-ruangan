<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Verifikasi email</p>
            <h1 class="text-2xl font-bold text-gray-900">Cek kotak masuk Anda</h1>
            <p class="text-sm text-gray-500">Kami telah mengirim tautan verifikasi. Jika belum menerima, kirim ulang di
                bawah ini.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div
                class="flex items-center gap-3 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-green-600"><i
                        class="fas fa-check"></i></span>
                <div>
                    <p class="font-semibold">Tautan baru dikirim.</p>
                    <p>Periksa email yang Anda gunakan saat pendaftaran.</p>
                </div>
            </div>
        @endif

        <div class="flex items-center justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                @csrf
                <x-partials.primary-button class="w-full justify-center">
                    {{ __('Kirim ulang tautan') }}
                </x-partials.primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                    {{ __('Keluar') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
