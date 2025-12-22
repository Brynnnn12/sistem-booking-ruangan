<x-app-layout>

    <div class="container mx-auto px-4 py-8" x-data="{ selectedRoom: null, showModal: false }">
        <div class="w-full mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Pilih Ruangan untuk Booking
                    </h1>
                </div>

                <!-- Rooms Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($rooms as $room)
                            <div
                                class="bg-gray-50 border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                            <i class="fas fa-building mr-2 text-blue-600"></i>
                                            {{ $room->name }}
                                        </h3>
                                        <p class="text-gray-600 mb-3">
                                            <i class="fas fa-map-marker-alt mr-1"></i>
                                            {{ $room->location }}
                                        </p>
                                        <p class="text-sm text-gray-500 mb-4">
                                            Kapasitas: {{ $room->capacity }} orang
                                        </p>
                                    </div>
                                </div>

                                <button @click="selectedRoom = {{ $room->id }}; showModal = true"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Book Sekarang
                                </button>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <i class="fas fa-building text-gray-300 text-6xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada ruangan tersedia</h3>
                                <p class="text-gray-500">Belum ada ruangan yang terdaftar dalam sistem.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
            @click.away="showModal = false; selectedRoom = null">

            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" @click="showModal = false; selectedRoom = null">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form method="POST" action="{{ route('dashboard.bookings.store') }}">
                        @csrf
                        <input type="hidden" name="room_id" x-bind:value="selectedRoom">

                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i class="fas fa-calendar-plus text-blue-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                        Buat Booking Ruangan
                                    </h3>

                                    <div class="space-y-4">
                                        <!-- Start Time -->
                                        <div>
                                            <label for="start_time"
                                                class="block text-sm font-medium text-gray-700 mb-1">
                                                Waktu Mulai
                                            </label>
                                            <input type="datetime-local" id="start_time" name="start_time"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                required>
                                            @error('start_time')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- End Time -->
                                        <div>
                                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">
                                                Waktu Selesai
                                            </label>
                                            <input type="datetime-local" id="end_time" name="end_time"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                required>
                                            @error('end_time')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Note -->
                                        <div>
                                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1">
                                                Catatan (Opsional)
                                            </label>
                                            <textarea id="note" name="note" rows="3"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                placeholder="Tambahkan catatan untuk booking ini..."></textarea>
                                            @error('note')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <i class="fas fa-save mr-2"></i>
                                Buat Booking
                            </button>
                            <button type="button" @click="showModal = false; selectedRoom = null"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
