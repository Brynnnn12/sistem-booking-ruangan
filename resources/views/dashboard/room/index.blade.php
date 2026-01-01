<x-app-layout>

    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-900">Daftar Ruangan</h2>
            <a href="{{ route('dashboard.rooms.create') }}"
                class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-fit">
                <i class="fas fa-plus mr-2 text-xs"></i>
                Tambah Ruangan
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
            <form method="GET" action="{{ route('dashboard.rooms.index') }}"
                class="grid grid-cols-1 gap-4 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <x-partials.input-label for="search" :value="__('Search')" />

                    <x-partials.text-input id="search" class="block mt-1 w-full" type="text" name="search"
                        value="{{ request('search') }}" placeholder="Cari berdasarkan nama dan lokasi..." />
                </div>

                <div class="sm:col-span-2">
                    <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="is_active" id="is_active"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-gray-400 focus:ring-gray-300">
                        <option value="">Semua</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <div class="sm:col-span-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-end">
                    <x-partials.primary-button type="submit">Cari</x-partials.primary-button>

                    <a href="{{ route('dashboard.rooms.index') }}"
                        class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-fit">
                        <i class="fas fa-times mr-2 text-xs"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 ltr:text-left rtl:text-right">
                        <tr class="*:font-medium *:text-gray-900">
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Nama</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Gambar</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Lokasi</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Kapasitas</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Status</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($rooms as $room)
                            <tr class="*:text-gray-900">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium sm:px-6">{{ $room->name }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm sm:px-6">
                                    @if ($room->image)
                                        <img src="{{ $room->image }}" alt="Room Image"
                                            class="h-12 w-12 rounded-lg object-cover">
                                    @else
                                        <span class="text-sm text-gray-500">No image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 sm:px-6">
                                    {{ $room->location }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 sm:px-6">
                                    {{ $room->capacity }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm sm:px-6">
                                    @if ($room->is_active)
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Active</span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('dashboard.rooms.show', $room) }}"
                                            class="text-gray-600 transition hover:text-gray-900" aria-label="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.rooms.edit', $room) }}"
                                            class="text-gray-600 transition hover:text-gray-900" aria-label="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dashboard.rooms.destroy', $room) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 transition hover:text-red-800"
                                                onclick="return confirm('Are you sure you want to delete this room?')"
                                                aria-label="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 sm:px-6">
                                    Tidak Ada Ruangan Yang Tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                {{ $rooms->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
