<x-error-layout>
    <h1 class="w-full select-none text-center text-6xl sm:text-7xl md:text-8xl font-black leading-none text-gray-400">
        429</h1>
    <p class="text-center text-xl font-bold capitalize">Terlalu Banyak Permintaan</p>
    <p class="mx-auto max-w-2xl text-center text-base sm:text-lg font-medium break-words text-gray-500">Terlalu banyak
        permintaan dalam waktu singkat. Silakan
        tunggu sebentar lalu coba lagi.</p>
    <div class="flex w-full justify-center">
        <a href="{{ route('dashboard.index') }}"
            class="rounded flex w-full sm:w-fit group items-center gap-3 justify-center border-2 border-green-500 font-semibold hover:bg-green-500 px-4 py-3 sm:px-6 sm:py-3 capitalize focus:outline-none hover:scale-105 active:scale-90 shadow-lg hover:shadow-xl transition-all">
            <span class="material-symbols-outlined">home</span>
            Kembali ke Dashboard
        </a>
    </div>
</x-error-layout>
