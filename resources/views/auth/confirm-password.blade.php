<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Konfirmasi keamanan</p>
            <h1 class="text-2xl font-bold text-gray-900">Masukkan kata sandi Anda</h1>
            <p class="text-sm text-gray-500">Area ini membutuhkan verifikasi ulang demi keamanan akun.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <x-partials.input-label for="password" :value="__('Kata Sandi')" />
                <x-partials.text-input id="password" class="block w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-partials.input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <x-partials.primary-button class="w-full justify-center">
                {{ __('Konfirmasi') }}
            </x-partials.primary-button>
        </form>
    </div>
</x-guest-layout>
