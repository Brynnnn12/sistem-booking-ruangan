<x-app-layout>
    <div class="bg-gray-50 py-10">
        <div class="mx-auto w-full max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-xl">
                <div class="border-b border-gray-200 px-6 py-6">
                    <h1 class="flex items-center text-2xl font-semibold text-gray-900">
                        <i class="fas fa-user-edit mr-3 text-base text-gray-400"></i>
                        Edit Pegawai
                    </h1>
                    <p class="mt-2 text-sm text-gray-500">Perbarui informasi identitas, kredensial, dan role pegawai.</p>
                </div>

                <form method="POST" action="{{ route('dashboard.employees.update', $employee) }}"
                    class="space-y-10 px-6 py-8 sm:px-10">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr]">
                        <section class="space-y-6">
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-teal-500">Identitas</p>
                                <p class="mt-1 text-lg font-medium text-gray-900">Profil dasar</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <x-partials.input-label for="name" :value="__('Name')" />
                                    <x-partials.text-input id="name"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white text-gray-900"
                                        type="text" name="name" :value="old('name', $employee->name)" required autofocus />
                                    <x-partials.input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div>
                                    <x-partials.input-label for="email" :value="__('Email')" />
                                    <x-partials.text-input id="email"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white text-gray-900"
                                        type="email" name="email" :value="old('email', $employee->email)" required />
                                    <x-partials.input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                        </section>

                        <section class="space-y-6 rounded-2xl border border-gray-200 bg-gray-50 p-6">
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-teal-500">Akses Akun</p>
                                <p class="mt-1 text-lg font-medium text-gray-900">Atur ulang password & role</p>
                            </div>

                            <div class="space-y-5">
                                <div>
                                    <x-partials.input-label for="password" :value="__('Password Baru (opsional)')" />
                                    <x-partials.text-input id="password"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white text-gray-900"
                                        type="password" name="password"
                                        placeholder="Biarkan kosong jika tidak diubah" />
                                    <x-partials.input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <div>
                                    <x-partials.input-label for="role" :value="__('Role')" />
                                    <select id="role" name="role"
                                        class="mt-1 w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-gray-900 focus:border-teal-500 focus:ring-teal-500"
                                        required>
                                        @php($activeRole = old('role', $employee->roles->first()->name ?? null))
                                        <option value="">Pilih Role</option>
                                        <option value="Admin" {{ $activeRole === 'Admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="Staff" {{ $activeRole === 'Staff' ? 'selected' : '' }}>Staff
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
                            Batal
                        </a>
                        <x-partials.primary-button
                            class="inline-flex w-full items-center justify-center rounded-2xl bg-teal-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.2em] text-white shadow-lg shadow-teal-500/30 transition hover:bg-teal-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-500 sm:w-auto">
                            Simpan Perubahan
                        </x-partials.primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
