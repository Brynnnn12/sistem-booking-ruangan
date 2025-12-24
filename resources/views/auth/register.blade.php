<x-guest-layout>
    <div class="space-y-6">
        <div class="text-center space-y-2">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Sistem Booking Ruangan</p>
            <h1 class="text-2xl font-bold text-gray-900">Buat akun baru</h1>
            <p class="text-sm text-gray-500">Daftar untuk mengelola permintaan booking dengan mudah.</p>
        </div>
        <x-guest-layout>
            <div class="space-y-6 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-600">Akses dibuat oleh admin</p>
                <h1 class="text-2xl font-bold text-gray-900">Registrasi ditutup</h1>
                <p class="text-sm text-gray-500">Silakan hubungi admin untuk dibuatkan akun.</p>
            </div>
        </x-guest-layout>
        :value="old('name')" required autofocus autocomplete="name" />
