<x-app-layout>

    <div class="space-y-6">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-900">Daftar Karyawan</h2>
            <a href="{{ route('dashboard.employees.create') }}"
                class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-fit">
                <i class="fas fa-plus mr-2 text-xs"></i>
                Tambah Karyawan
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
            <form method="GET" action="{{ route('dashboard.employees.index') }}"
                class="grid grid-cols-1 gap-6 sm:grid-cols-12 lg:grid-cols-12">
                <div class="sm:col-span-8 lg:col-span-9">
                    <x-partials.input-label for="search" :value="__('Search')" />

                    <x-partials.text-input id="search"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                        type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama dan email..." />
                </div>

                <div class="sm:col-span-4 lg:col-span-3 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-end">
                    <x-partials.primary-button type="submit" class="w-full sm:w-auto">
                        <i class="fas fa-search mr-2"></i>Cari
                    </x-partials.primary-button>

                    <a href="{{ route('dashboard.employees.index') }}"
                        class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-auto">
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
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Email</th>
                            <th class="px-4 py-3 text-xs uppercase tracking-wider text-gray-500 sm:px-6">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($employees as $staff)
                            <tr class="*:text-gray-900">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium sm:px-6">{{ $staff->name }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600 sm:px-6">
                                    {{ $staff->email }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm sm:px-6">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('dashboard.employees.show', $staff) }}"
                                            class="text-gray-600 transition hover:text-gray-900" aria-label="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dashboard.employees.edit', $staff) }}"
                                            class="text-gray-600 transition hover:text-gray-900" aria-label="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('dashboard.employees.destroy', $staff) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 transition hover:text-red-900"
                                                aria-label="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 sm:px-6">
                                    Tidak Ada Pegawai Yang Tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                {{ $employees->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
