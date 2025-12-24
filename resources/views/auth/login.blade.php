<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Sistem Booking Ruangan</p>
            <h1 class="text-2xl font-bold text-gray-900">Masuk ke dashboard</h1>
            <p class="text-sm text-gray-500">Atur dan pantau permintaan booking dengan cepat.</p>
        </div>

        <x-partials.auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <x-partials.input-label for="email" :value="__('Email')" />
                <x-partials.text-input id="email" class="block w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
                <x-partials.input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="space-y-1.5">
                <x-partials.input-label for="password" :value="__('Password')" />
                <x-partials.text-input id="password" class="block w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-partials.input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-gray-600">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span>{{ __('Ingat saya') }}</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-700"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa kata sandi?') }}
                    </a>
                @endif
            </div>

            <x-partials.primary-button class="w-full justify-center">
                {{ __('Masuk') }}
            </x-partials.primary-button>
        </form>

        <div class="text-center text-sm text-gray-500">
            Akun dibuat oleh admin. Hubungi admin jika butuh akses.
        </div>
    </div>
</x-guest-layout>
