<x-app-layout>

    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Booking
        </h2>
        <div>
            <a href="{{ route('dashboard.bookings.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                Tambah Booking
            </a>

        </div>
    </div>

    <!-- Search and Filter -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <form method="GET" action="{{ route('dashboard.bookings.index') }}" class="flex flex-wrap gap-4">
            <div class="min-w-32">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan
                    </option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search mr-2"></i>Terapkan
                </button>
                <a href="{{ route('dashboard.bookings.index') }}"
                    class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>


    <div class="max-h-46 overflow-x-auto py-12">
        <table class="min-w-full divide-y-2 divide-gray-200">
            <thead class="sticky top-0 bg-white ltr:text-left rtl:text-right">
                <tr class="*:font-medium *:text-gray-900">
                    <th class="px-3 py-2 whitespace-nowrap">Ruangan</th>
                    <th class="px-3 py-2 whitespace-nowrap">User</th>
                    <th class="px-3 py-2 whitespace-nowrap">Tanggal</th>
                    <th class="px-3 py-2 whitespace-nowrap">Waktu</th>
                    <th class="px-3 py-2 whitespace-nowrap">Status</th>
                    <th class="px-3 py-2 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($bookings as $booking)
                    <tr class="*:text-gray-900 *:first:font-medium">
                        <td class="px-3 py-2 whitespace-nowrap">{{ $booking->room->name }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $booking->user->name }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $booking->booking_date->format('d/m/Y') }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $booking->start_time }} - {{ $booking->end_time }}
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap">
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
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap space-x-2">
                            <a href="{{ route('dashboard.bookings.show', $booking) }}"
                                class="text-green-600 hover:text-green-900 mr-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('update', $booking)
                                <a href="{{ route('dashboard.bookings.edit', $booking) }}"
                                    class="text-blue-600 hover:text-blue-900 mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('approve', $booking)
                                <form action="{{ route('dashboard.bookings.approve', $booking) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">
                                        <i class="fas fa-check"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('dashboard.bookings.reject', $booking) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-600 hover:text-red-900 mr-2">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </form>
                            @endcan
                            @can('cancel', $booking)
                                <form action="{{ route('dashboard.bookings.cancel', $booking) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-gray-600 hover:text-gray-900 mr-2">
                                        <i class="fas fa-ban"></i> Batalkan
                                    </button>
                                </form>
                            @endcan
                            @can('delete', $booking)
                                <form action="{{ route('dashboard.bookings.destroy', $booking) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Yakin ingin menghapus booking ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-3 py-2 text-center text-gray-500">
                            Tidak Ada Booking Yang Tersedia.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4">
            {{ $bookings->withQueryString()->links() }} <!-- Pagination with query strings -->
        </div>
    </div>
</x-app-layout>
