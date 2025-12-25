<x-error-layout>
    <h1 class="text-6xl md:text-[300px] w-full select-none text-center font-black text-gray-400">
        429</h1>
    <p class="text-xl font-bold capitalize">Terlalu Banyak Permintaan</p>
    <p class="text-lg font-medium break-words text-gray-500">Terlalu banyak permintaan dalam waktu singkat. Silakan
        tunggu sebentar lalu coba lagi.</p>
    <div class="flex flex-col justify-between w-full gap-4 md:flex-row md:gap-8 xl:px-8">
        <a href="{{ url()->previous() }}"
            class="flex items-center justify-center w-full gap-3 p-3 font-semibold capitalize border-2 border-blue-500 rounded shadow-lg md:w-fit hover:bg-blue-500 md:p-4 focus:outline-none hover:scale-105 active:scale-90 hover:shadow-xl transition-all">
            <span class="rotate-180 material-symbols-outlined">arrow_right_alt</span>
            Kembali ke Halaman Sebelumnya
        </a>
        <a href="{{ route('dashboard.index') }}"
            class="rounded flex w-full md:w-fit group items-center gap-3 justify-center border-2 border-green-500 font-semibold hover:bg-green-500 p-3 md:p-4 capitalize focus:outline-none hover:scale-105 active:scale-90 shadow-lg hover:shadow-xl transition-all">
            <span class="material-symbols-outlined">home</span>
            Kembali ke Dashboard
        </a>
    </div>
</x-error-layout>
