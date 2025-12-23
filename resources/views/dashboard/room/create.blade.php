<x-app-layout>

    <div class="container mx-auto px-4 py-8">
        <div class="w-full mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Create Room
                    </h1>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('dashboard.rooms.store') }}" enctype="multipart/form-data"
                    class="p-6 space-y-6">
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
                        <input id="image" class="block mt-1 w-full" type="file" name="image"
                            accept="image/*" />
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
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('dashboard.rooms.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </a>
                        <x-partials.primary-button>
                            Create Room
                        </x-partials.primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
