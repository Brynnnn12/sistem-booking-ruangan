<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Hapus Akun
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Setelah akun Anda dihapus, semua data dan sumber daya akan terhapus permanen. Sebelum menghapus akun,
            pastikan Anda sudah menyimpan data yang diperlukan.
        </p>
    </header>

    <x-partials.danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">Hapus Akun</x-partials.danger-button>

    <x-partials.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('dashboard.profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                Yakin ingin menghapus akun Anda?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Setelah akun dihapus, semua data akan terhapus permanen. Masukkan kata sandi untuk mengonfirmasi
                penghapusan akun.
            </p>

            <div class="mt-6">
                <x-partials.input-label for="password" value="Kata Sandi" class="sr-only" />

                <x-partials.text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="Kata Sandi" />

                <x-partials.input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-partials.secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-partials.secondary-button>

                <x-partials.danger-button class="ms-3">
                    Hapus Akun
                </x-partials.danger-button>
            </div>
        </form>
    </x-partials.modal>
</section>
