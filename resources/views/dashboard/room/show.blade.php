<x-app-layout>

    <div class="container mx-auto px-4 py-8">
        <div class="w-full mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-building mr-2"></i>
                        Room Details
                    </h1>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Room Information -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Room Information</h2>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $room->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Location</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $room->location }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Capacity</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $room->capacity }} people</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <p class="mt-1">
                                        @if ($room->is_active)
                                            <span
                                                class="px-2 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Image</label>
                                    <p class="mt-1">
                                        @if ($room->image)
                                            <img src="{{ $room->image }}" alt="Room Image"
                                                class="w-32 h-32 object-cover rounded">
                                        @else
                                            <span class="text-gray-500">No image</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created At</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $room->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Updated At</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $room->updated_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                            <div class="space-y-3">
                                <a href="{{ route('dashboard.rooms.edit', $room) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 active:bg-blue-600 disabled:opacity-25 transition w-full justify-center">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Room
                                </a>

                                <form action="{{ route('dashboard.rooms.destroy', $room) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition w-full justify-center"
                                        onclick="return confirm('Are you sure you want to delete this room?')">
                                        <i class="fas fa-trash mr-2"></i>
                                        Delete Room
                                    </button>
                                </form>

                                <a href="{{ route('dashboard.rooms.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-600 disabled:opacity-25 transition w-full justify-center">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
