<x-app-layout>
    <div class="bg-gray-50 py-10">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-xl">
                <div
                    class="flex flex-col gap-4 border-b border-gray-200 px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-teal-500">Employee Profile</p>
                        <h1 class="mt-1 flex items-center text-2xl font-semibold text-gray-900">
                            <i class="fas fa-user mr-3 text-base text-gray-400"></i>
                            {{ $employee->name }}
                        </h1>
                        <p class="mt-2 text-sm text-gray-500">Detail lengkap identitas pegawai dan peran aktifnya.</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-gray-50 px-5 py-3 text-sm text-gray-700">
                        <p class="text-xs uppercase tracking-[0.25em] text-gray-400">Terdaftar</p>
                        <p class="mt-1 font-semibold">{{ $employee->created_at?->format('d M Y, H:i') ?? '-' }}</p>
                    </div>
                </div>

                <div class="grid gap-8 px-6 py-8 lg:grid-cols-[1.15fr_0.85fr]">
                    <section class="space-y-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-teal-500">Identitas</p>
                            <p class="mt-1 text-lg font-medium text-gray-900">Data dasar pegawai</p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="col-span-2">
                                <p class="text-sm font-semibold text-gray-500">Nama Lengkap</p>
                                <p class="mt-1 text-base text-gray-900">{{ $employee->name }}</p>
                            </div>

                            <div class="col-span-2">
                                <p class="text-sm font-semibold text-gray-500">Email</p>
                                <p class="mt-1 text-base text-gray-900">{{ $employee->email }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-gray-500">Terakhir diperbarui</p>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $employee->updated_at?->format('d M Y, H:i') ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-gray-500">Email diverifikasi</p>
                                <span
                                    class="mt-1 inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $employee->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $employee->email_verified_at ? 'Sudah' : 'Belum' }}
                                </span>
                            </div>
                        </div>
                    </section>

                    <section class="space-y-6 rounded-2xl border border-gray-200 bg-gray-50 p-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.25em] text-teal-500">Peran & akses</p>
                            <p class="mt-1 text-lg font-medium text-gray-900">Role, permissions, dan tindakan</p>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <p class="text-sm font-semibold text-gray-500">Role aktif</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @forelse($employee->roles as $role)
                                        <span
                                            class="rounded-full bg-teal-100 px-3 py-1 text-sm font-medium text-teal-800">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-sm text-gray-500">Belum memiliki role</span>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-gray-500">ID Pegawai</p>
                                <p class="mt-1 text-base text-gray-900">#{{ $employee->id }}</p>
                            </div>

                            <div class="space-y-3">
                                <a href="{{ route('dashboard.employees.edit', $employee) }}"
                                    class="inline-flex w-full items-center justify-center rounded-2xl bg-gray-900 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    <i class="fas fa-edit mr-2"></i>Edit Pegawai
                                </a>

                                <form action="{{ route('dashboard.employees.destroy', $employee) }}" method="POST"
                                    class="w-full" onsubmit="return confirm('Yakin ingin menghapus pegawai ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex w-full items-center justify-center rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-200">
                                        <i class="fas fa-trash mr-2"></i>Hapus Pegawai
                                    </button>
                                </form>

                                <a href="{{ route('dashboard.employees.index') }}"
                                    class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke daftar
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
