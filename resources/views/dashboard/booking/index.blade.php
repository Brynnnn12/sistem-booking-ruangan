<x-app-layout>

    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-900">Daftar Booking</h2>
            <a href="{{ route('dashboard.bookings.create') }}"
                class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-fit">
                <i class="fas fa-plus mr-2 text-xs"></i>
                Tambah Booking
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
            <form method="GET" action="{{ route('dashboard.bookings.index') }}"
                class="grid grid-cols-1 gap-4 sm:grid-cols-6">
                <div class="sm:col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-400 focus:ring-gray-300">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu
                        </option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui
                        </option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak
                        </option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>

                <div class="sm:col-span-4 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-end">
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-fit">
                        <i class="fas fa-filter mr-2 text-xs"></i>Terapkan
                    </button>
                    <a href="{{ route('dashboard.bookings.index') }}"
                        class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-fit">
                        <i class="fas fa-rotate-left mr-2 text-xs"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 ltr:text-left rtl:text-right">
                        <tr class="*:font-medium *:text-gray-900">
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Ruangan</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">User</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Tanggal</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Waktu</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Status</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($bookings as $booking)
                            <tr class="*:text-gray-900">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium sm:px-6">
                                    {{ $booking->room->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 sm:px-6">
                                    {{ $booking->user->name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 sm:px-6">
                                    {{ $booking->booking_date->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 sm:px-6">
                                    {{ $booking->start_time }} - {{ $booking->end_time }} WIB</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm sm:px-6">
                                    @if ($booking->status === 'pending')
                                        <span
                                            class="inline-flex rounded-full bg-yellow-100 px-2 py-1 text-xs font-semibold text-yellow-800">Menunggu</span>
                                    @elseif ($booking->status === 'approved')
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Disetujui</span>
                                    @elseif ($booking->status === 'rejected')
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Ditolak</span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-800">Dibatalkan</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm sm:px-6">
                                    <div class="flex flex-wrap items-center gap-3">
                                        <a href="{{ route('dashboard.bookings.show', $booking) }}"
                                            class="text-gray-600 transition hover:text-gray-900" aria-label="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @can('update', $booking)
                                            <a href="{{ route('dashboard.bookings.edit', $booking) }}"
                                                class="text-gray-600 transition hover:text-gray-900" aria-label="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('approve', $booking)
                                            <form action="{{ route('dashboard.bookings.approve', $booking) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="text-green-700 transition hover:text-green-900">
                                                    <i class="fas fa-check"></i>
                                                    <span class="hidden sm:inline">Setujui</span>
                                                </button>
                                            </form>
                                            <form action="{{ route('dashboard.bookings.reject', $booking) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-red-700 transition hover:text-red-900">
                                                    <i class="fas fa-times"></i>
                                                    <span class="hidden sm:inline">Tolak</span>
                                                </button>
                                            </form>
                                        @endcan

                                        @can('cancel', $booking)
                                            <form action="{{ route('dashboard.bookings.cancel', $booking) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-gray-600 transition hover:text-gray-900">
                                                    <i class="fas fa-ban"></i>
                                                    <span class="hidden sm:inline">Batalkan</span>
                                                </button>
                                            </form>
                                        @endcan

                                        @can('delete', $booking)
                                            @if (!$booking->isActiveApproved())
                                                <form action="{{ route('dashboard.bookings.destroy', $booking) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-700 transition hover:text-red-900"
                                                        onclick="return confirm('Yakin ingin menghapus booking ini?')"
                                                        aria-label="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500 sm:px-6">
                                    Tidak Ada Booking Yang Tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                {{ $bookings->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
