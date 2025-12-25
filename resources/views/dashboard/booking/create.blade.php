<x-app-layout>

    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8" x-data="{ selectedRoom: null, showModal: false }">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <!-- Header -->
            <div class="border-b border-gray-200 px-4 py-4 sm:px-6">
                <h1 class="flex items-center text-lg font-semibold text-gray-900">
                    <i class="fas fa-calendar-plus mr-2 text-sm text-gray-500"></i>
                    Pilih Ruangan untuk Booking
                </h1>
            </div>

            <!-- Rooms Grid -->
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($rooms as $room)
                        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Room Image -->
                                    @if ($room->image)
                                        <div class="mb-4">
                                            <img src="{{ $room->image }}" alt="{{ $room->name }}"
                                                class="w-full h-32 object-cover rounded-lg">
                                        </div>
                                    @endif

                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        <i class="fas fa-building mr-2 text-gray-500"></i>
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
                                class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300">
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
                                class="mx-auto flex-shrink-0 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-calendar-plus text-gray-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                    Buat Booking Ruangan
                                </h3>

                                <div class="space-y-4">
                                    <!-- Booking Date -->
                                    <div>
                                        <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Tanggal Booking
                                        </label>
                                        <input type="date" id="booking_date" name="booking_date"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" required>
                                        @error('booking_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Start Time -->
                                    <div>
                                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="fas fa-clock mr-1"></i>
                                            Jam Mulai
                                        </label>
                                        <select id="start_time" name="start_time"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                            <option value="">Pilih Jam Mulai</option>
                                            @for ($hour = 7; $hour <= 16; $hour++)
                                                <option value="{{ sprintf('%02d:00', $hour) }}"
                                                    {{ old('start_time') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d:00', $hour) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('start_time')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Jam operasional: 07:00 - 17:00</p>
                                    </div>

                                    <!-- End Time -->
                                    <div>
                                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="fas fa-clock mr-1"></i>
                                            Jam Selesai
                                        </label>
                                        <select id="end_time" name="end_time"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            required>
                                            <option value="">Pilih Jam Selesai</option>
                                            @for ($hour = 8; $hour <= 17; $hour++)
                                                <option value="{{ sprintf('%02d:00', $hour) }}"
                                                    {{ old('end_time') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d:00', $hour) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('end_time')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">Minimal booking 1 jam</p>
                                    </div>

                                    <!-- Note -->
                                    <div>
                                        <label for="note" class="block text-sm font-medium text-gray-700 mb-1">
                                            <i class="fas fa-sticky-note mr-1"></i>
                                            Catatan (Opsional)
                                        </label>
                                        <textarea id="note" name="note" rows="3"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Tambahkan catatan untuk booking ini...">{{ old('note') }}</textarea>
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
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-900 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 sm:ml-3 sm:w-auto sm:text-sm">
                            <i class="fas fa-save mr-2"></i>
                            Buat Booking
                        </button>
                        <button type="button" @click="showModal = false; selectedRoom = null"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

</x-app-layout>
