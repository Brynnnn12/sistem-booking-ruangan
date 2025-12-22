<x-app-layout>

    <div class="container mx-auto px-4 py-8">
        <div class="w-full mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        Detail Booking
                    </h1>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Booking Information -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Booking</h2>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ruangan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $booking->room->name }} -
                                        {{ $booking->room->location }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Pemesan</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $booking->user->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $booking->start_time->format('d M Y, H:i') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $booking->end_time->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <p class="mt-1">
                                        @if ($booking->status === 'pending')
                                            <span
                                                class="px-2 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                                        @elseif ($booking->status === 'approved')
                                            <span
                                                class="px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Disetujui</span>
                                        @elseif ($booking->status === 'rejected')
                                            <span
                                                class="px-2 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">Ditolak</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full">Dibatalkan</span>
                                        @endif
                                    </p>
                                </div>

                                @if ($booking->approved_by)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Disetujui Oleh</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $booking->approvedBy->name }}</p>
                                    </div>
                                @endif

                                @if ($booking->note)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Catatan</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $booking->note }}</p>
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Dibuat Pada</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $booking->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Diperbarui Pada</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $booking->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h2>
                            <div class="space-y-3">
                                @can('update', $booking)
                                    <a href="{{ route('dashboard.bookings.edit', $booking) }}"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition w-full justify-center">
                                        <i class="fas fa-edit mr-2"></i>
                                        Ubah Booking
                                    </a>
                                @endcan

                                @can('approve', $booking)
                                    <form action="{{ route('dashboard.bookings.approve', $booking) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition w-full justify-center">
                                            <i class="fas fa-check mr-2"></i>
                                            Setujui Booking
                                        </button>
                                    </form>

                                    <form action="{{ route('dashboard.bookings.reject', $booking) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition w-full justify-center">
                                            <i class="fas fa-times mr-2"></i>
                                            Tolak Booking
                                        </button>
                                    </form>
                                @endcan

                                @can('cancel', $booking)
                                    <form action="{{ route('dashboard.bookings.cancel', $booking) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-600 disabled:opacity-25 transition w-full justify-center">
                                            <i class="fas fa-ban mr-2"></i>
                                            Batalkan Booking
                                        </button>
                                    </form>
                                @endcan

                                @can('delete', $booking)
                                    <form action="{{ route('dashboard.bookings.destroy', $booking) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition w-full justify-center"
                                            onclick="return confirm('Yakin ingin menghapus booking ini?')">
                                            <i class="fas fa-trash mr-2"></i>
                                            Hapus Booking
                                        </button>
                                    </form>
                                @endcan

                                <a href="{{ route('dashboard.bookings.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-600 disabled:opacity-25 transition w-full justify-center">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Kembali ke Daftar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
