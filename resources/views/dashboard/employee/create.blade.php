<x-app-layout>
    <div class=" py-8">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-xl">
                <div
                    class="flex flex-col gap-4 border-b border-gray-200 px-6 py-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-teal-500">People Ops</p>
                        <h1 class="mt-1 flex items-center text-2xl font-semibold text-gray-900">
                            <i class="fas fa-plus mr-3 text-base text-gray-400"></i>
                            Tambah Karyawan
                        </h1>
                        <p class="mt-2 text-sm text-gray-500">Lengkapi identitas pegawai dan set kredensialnya secara
                            ringkas.</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-gray-50 px-5 py-3 text-sm text-gray-700">
                        <p class="text-xs uppercase tracking-[0.25em] text-gray-400">Status</p>
                        <p class="mt-1 font-semibold">Draft onboarding</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('dashboard.employees.store') }}" enctype="multipart/form-data"
                    class="space-y-10 px-6 py-8 sm:px-10">
                    @csrf

                    <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr]">
                        <section class="space-y-6">
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-teal-500">Identitas</p>
                                <p class="mt-1 text-lg font-medium text-gray-900">Detail dasar pegawai</p>
                            </div>

                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="col-span-2">
                                    <x-partials.input-label for="name" :value="__('Name')" />
                                    <x-partials.text-input id="name"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400"
                                        type="text" name="name" :value="old('name')" required autofocus />
                                    <x-partials.input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <x-partials.input-label for="email" :value="__('Email')" />
                                    <x-partials.text-input id="email"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400"
                                        type="email" name="email" :value="old('email')" required />
                                    <x-partials.input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                        </section>

                        <section class="space-y-6 rounded-2xl border border-gray-200 bg-gray-50 p-6">
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-teal-500">Akses Akun</p>
                                <p class="mt-1 text-lg font-medium text-gray-900">Password & role</p>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <x-partials.input-label for="password" :value="__('Password')" />
                                    <x-partials.text-input id="password"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400"
                                        type="password" name="password" required />
                                    <x-partials.input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-partials.input-label for="role" :value="__('Role')" />
                                    <select id="role" name="role"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-gray-900 focus:border-teal-500 focus:ring-teal-500"
                                        required>
                                        <option value="">Pilih Role</option>
                                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="Staff" {{ old('role') == 'Staff' ? 'selected' : '' }}>Staff
                                        </option>
                                    </select>
                                    <x-partials.input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>
                            </div>
                        </section>
                    </div>

                    <div class="flex flex-col gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:justify-between">
                        <a href="{{ route('dashboard.employees.index') }}"
                            class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-300 sm:w-auto">
                            <i class="fas fa-arrow-left mr-2 text-xs"></i>Kembali ke daftar
                        </a>
                        <x-partials.primary-button
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-teal-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-white shadow-lg shadow-teal-500/30 transition hover:bg-teal-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-500 sm:w-auto">
                            <i class="fas fa-save mr-3"></i>Simpan
                        </x-partials.primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
