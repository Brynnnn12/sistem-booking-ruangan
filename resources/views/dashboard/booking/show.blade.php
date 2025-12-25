<x-app-layout>

    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Header -->
            <div class="border-b border-gray-200 px-4 py-4 sm:px-6">
                <h1 class="flex items-center text-lg font-semibold text-gray-900">
                    <i class="fas fa-calendar mr-2 text-sm text-gray-500"></i>
                    Detail Booking
                </h1>
            </div>

            <!-- Content -->
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                                <label class="block text-sm font-medium text-gray-700">Tanggal Booking</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-calendar mr-1 text-gray-500"></i>
                                    {{ $booking->booking_date->format('d M Y') }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Waktu</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-clock mr-1 text-gray-500"></i>
                                    {{ substr($booking->start_time, 0, 5) }} -
                                    {{ substr($booking->end_time, 0, 5) }}
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
                                    class="inline-flex items-center justify-center w-full rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300">
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
                                        class="inline-flex items-center justify-center w-full rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                                        <i class="fas fa-check mr-2"></i>
                                        Setujui Booking
                                    </button>
                                </form>

                                <form action="{{ route('dashboard.bookings.reject', $booking) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-full rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-200">
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
                                        class="inline-flex items-center justify-center w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                        <i class="fas fa-ban mr-2"></i>
                                        Batalkan Booking
                                    </button>
                                </form>
                            @endcan

                            @can('delete', $booking)
                                @if (!$booking->isActiveApproved())
                                    <form action="{{ route('dashboard.bookings.destroy', $booking) }}" method="POST"
                                        class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-full rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-200"
                                            onclick="return confirm('Yakin ingin menghapus booking ini?')">
                                            <i class="fas fa-trash mr-2"></i>
                                            Hapus Booking
                                        </button>
                                    </form>
                                @endif
                            @endcan

                            <a href="{{ route('dashboard.bookings.index') }}"
                                class="inline-flex items-center justify-center w-full rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
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
