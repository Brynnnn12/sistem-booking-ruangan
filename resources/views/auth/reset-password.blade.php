<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Reset kata sandi</p>
            <h1 class="text-2xl font-bold text-gray-900">Buat kata sandi baru</h1>
            <p class="text-sm text-gray-500">Pastikan kombinasi kuat untuk keamanan akun Anda.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="space-y-1.5">
                <x-partials.input-label for="email" :value="__('Email')" />
                <x-partials.text-input id="email" class="block w-full" type="email" name="email"
                    :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-partials.input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="space-y-1.5">
                <x-partials.input-label for="password" :value="__('Kata Sandi Baru')" />
                <x-partials.text-input id="password" class="block w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-partials.input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="space-y-1.5">
                <x-partials.input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                <x-partials.text-input id="password_confirmation" class="block w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-partials.input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            <x-partials.primary-button class="w-full justify-center">
                {{ __('Simpan kata sandi baru') }}
            </x-partials.primary-button>
        </form>

        <div class="text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">Kembali ke
                masuk</a>
        </div>
    </div>
</x-guest-layout>
