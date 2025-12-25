<x-app-layout>

    <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Header -->
            <div class="border-b border-gray-200 px-4 py-4 sm:px-6">
                <h1 class="flex items-center text-lg font-semibold text-gray-900">
                    <i class="fas fa-plus mr-2 text-sm text-gray-500"></i>
                    Create Room
                </h1>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('dashboard.rooms.store') }}" enctype="multipart/form-data"
                class="space-y-6 p-4 sm:p-6">
                @csrf

                <!-- Name -->
                <div>
                    <x-partials.input-label for="name" :value="__('Name')" />
                    <x-partials.text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus />
                    <x-partials.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Location -->
                <div>
                    <x-partials.input-label for="location" :value="__('Location')" />
                    <x-partials.text-input id="location" class="block mt-1 w-full" type="text" name="location"
                        :value="old('location')" required />
                    <x-partials.input-error :messages="$errors->get('location')" class="mt-2" />
                </div>

                <!-- Capacity -->
                <div>
                    <x-partials.input-label for="capacity" :value="__('Capacity')" />
                    <x-partials.text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity"
                        :value="old('capacity')" required min="1" />
                    <x-partials.input-error :messages="$errors->get('capacity')" class="mt-2" />
                </div>

                <!-- Image -->
                <div>
                    <x-partials.input-label for="image" :value="__('Image')" />
                    <input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
                    <x-partials.input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <!-- Is Active -->
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input id="is_active" name="is_active" type="checkbox" value="1"
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" checked>
                    <label for="is_active" class="ml-2 text-sm text-gray-900">Active</label>
                    <x-partials.input-error :messages="$errors->get('is_active')" class="mt-2" />
                </div>

                <!-- Actions -->
                <div class="flex flex-col-reverse gap-3 border-t pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('dashboard.rooms.index') }}"
                        class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 sm:w-fit">
                        Cancel
                    </a>
                    <x-partials.primary-button>
                        Create Room
                    </x-partials.primary-button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
