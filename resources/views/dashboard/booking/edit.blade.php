<x-app-layout>

    <div class="container mx-auto px-4 py-8">
        <div class="w-full mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white flex items-center">
                        <i class="fas fa-edit mr-2"></i>
                        Ubah Booking
                    </h1>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('dashboard.bookings.update', $booking) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Room -->
                    <div>
                        <x-partials.input-label for="room_id" :value="__('Ruangan')" />
                        <select id="room_id" name="room_id"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">Pilih Ruangan</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}"
                                    {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} - {{ $room->location }}
                                </option>
                            @endforeach
                        </select>
                        <x-partials.input-error :messages="$errors->get('room_id')" class="mt-2" />
                    </div>

                    <!-- Start Time -->
                    <div>
                        <x-partials.input-label for="start_time" :value="__('Waktu Mulai')" />
                        <x-partials.text-input id="start_time" class="block mt-1 w-full" type="datetime-local"
                            name="start_time" :value="old('start_time', $booking->start_time->format('Y-m-d\TH:i'))" required />
                        <x-partials.input-error :messages="$errors->get('start_time')" class="mt-2" />
                    </div>

                    <!-- End Time -->
                    <div>
                        <x-partials.input-label for="end_time" :value="__('Waktu Selesai')" />
                        <x-partials.text-input id="end_time" class="block mt-1 w-full" type="datetime-local"
                            name="end_time" :value="old('end_time', $booking->end_time->format('Y-m-d\TH:i'))" required />
                        <x-partials.input-error :messages="$errors->get('end_time')" class="mt-2" />
                    </div>

                    <!-- Note -->
                    <div>
                        <x-partials.input-label for="note" :value="__('Catatan')" />
                        <textarea id="note" name="note" rows="3"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('note', $booking->note) }}</textarea>
                        <x-partials.input-error :messages="$errors->get('note')" class="mt-2" />
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <a href="{{ route('dashboard.bookings.index') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <x-partials.primary-button>
                            Simpan Perubahan
                        </x-partials.primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
