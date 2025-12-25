<x-app-layout>

    <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Header -->
            <div class="border-b border-gray-200 px-4 py-4 sm:px-6">
                <h1 class="flex items-center text-lg font-semibold text-gray-900">
                    <i class="fas fa-building mr-2 text-sm text-gray-500"></i>
                    Room Details
                </h1>
            </div>

            <!-- Content -->
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                        <h2 class="mb-4 text-lg font-semibold text-gray-900">Actions</h2>
                        <div class="space-y-3">
                            <a href="{{ route('dashboard.rooms.edit', $room) }}"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Room
                            </a>

                            <form action="{{ route('dashboard.rooms.destroy', $room) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-200"
                                    onclick="return confirm('Are you sure you want to delete this room?')">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete Room
                                </button>
                            </form>

                            <a href="{{ route('dashboard.rooms.index') }}"
                                class="inline-flex w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
