<x-app-layout>

    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Ruangan
        </h2>
        <div>
            <a href="{{ route('dashboard.rooms.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition">
                Tambah Ruangan
            </a>

        </div>
    </div>

    <!-- Search and Filter -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <form method="GET" action="{{ route('dashboard.rooms.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Search by name or location...">
            </div>

            <div class="min-w-32">
                <label for="is_active" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="is_active" id="is_active"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
                <a href="{{ route('dashboard.rooms.index') }}"
                    class="ml-2 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <i class="fas fa-times mr-2"></i>Clear
                </a>
            </div>
        </form>
    </div>


    <div class="max-h-46 overflow-x-auto py-12">
        <table class="min-w-full divide-y-2 divide-gray-200">
            <thead class="sticky top-0 bg-white ltr:text-left rtl:text-right">
                <tr class="*:font-medium *:text-gray-900">
                    <th class="px-3 py-2 whitespace-nowrap">Nama</th>
                    <th class="px-3 py-2 whitespace-nowrap">Lokasi</th>
                    <th class="px-3 py-2 whitespace-nowrap">Kapasitas</th>
                    <th class="px-3 py-2 whitespace-nowrap">Status Aktif</th>
                    <th class="px-3 py-2 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse ($rooms as $room)
                    <tr class="*:text-gray-900 *:first:font-medium">
                        <td class="px-3 py-2 whitespace-nowrap">{{ $room->name }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $room->location }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">{{ $room->capacity }}</td>
                        <td class="px-3 py-2 whitespace-nowrap">
                            @if ($room->is_active)
                                <span
                                    class="px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                            @else
                                <span
                                    class="px-2 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 whitespace-nowrap space-x-2">
                            <a href="{{ route('dashboard.rooms.show', $room) }}"
                                class="text-green-600 hover:text-green-900 mr-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('dashboard.rooms.edit', $room) }}"
                                class="text-blue-600 hover:text-blue-900 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('dashboard.rooms.destroy', $room) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Are you sure you want to delete this room?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 py-2 text-center text-gray-500">
                            Tidak Ada Ruangan Yang Tersedia.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="mt-4">
            {{ $rooms->withQueryString()->links() }} <!-- Pagination with query strings -->
        </div>
    </div>
</x-app-layout>
