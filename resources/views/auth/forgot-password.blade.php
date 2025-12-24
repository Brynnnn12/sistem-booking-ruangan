<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Reset kata sandi</p>
            <h1 class="text-2xl font-bold text-gray-900">Kirim tautan pemulihan</h1>
            <p class="text-sm text-gray-500">Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang
                kata sandi.</p>
        </div>

        <x-partials.auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <x-partials.input-label for="email" :value="__('Email')" />
                <x-partials.text-input id="email" class="block w-full" type="email" name="email"
                    :value="old('email')" required autofocus />
                <x-partials.input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <x-partials.primary-button class="w-full justify-center">
                {{ __('Kirim tautan reset') }}
            </x-partials.primary-button>
        </form>

        <div class="text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Kembali ke
                masuk</a>
        </div>
    </div>
</x-guest-layout>
