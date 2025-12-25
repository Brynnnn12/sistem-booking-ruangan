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
                        <div class="block mt-1 w-full rounded-md border-gray-300 bg-gray-100 px-3 py-2 text-gray-700">
                            {{ $booking->room->name }} - {{ $booking->room->location }}
                        </div>
                        <input type="hidden" name="room_id" value="{{ $booking->room_id }}">
                        <x-partials.input-error :messages="$errors->get('room_id')" class="mt-2" />
                    </div>

                    <!-- Booking Date -->
                    <div>
                        <x-partials.input-label for="booking_date" :value="__('Tanggal Booking')" />
                        <x-partials.text-input id="booking_date" class="block mt-1 w-full" type="date"
                            name="booking_date" :value="old('booking_date', $booking->booking_date->format('Y-m-d'))" min="{{ date('Y-m-d') }}" required />
                        <x-partials.input-error :messages="$errors->get('booking_date')" class="mt-2" />
                    </div>

                    <!-- Start Time -->
                    <div>
                        <x-partials.input-label for="start_time" :value="__('Jam Mulai')" />
                        <select id="start_time" name="start_time"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">Pilih Jam Mulai</option>
                            @for ($hour = 7; $hour <= 16; $hour++)
                                <option value="{{ sprintf('%02d:00', $hour) }}"
                                    {{ old('start_time', substr($booking->start_time, 0, 5)) == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                    {{ sprintf('%02d:00', $hour) }}
                                </option>
                            @endfor
                        </select>
                        <x-partials.input-error :messages="$errors->get('start_time')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500">Jam operasional: 07:00 - 17:00</p>
                    </div>

                    <!-- End Time -->
                    <div>
                        <x-partials.input-label for="end_time" :value="__('Jam Selesai')" />
                        <select id="end_time" name="end_time"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                            <option value="">Pilih Jam Selesai</option>
                            @for ($hour = 8; $hour <= 17; $hour++)
                                <option value="{{ sprintf('%02d:00', $hour) }}"
                                    {{ old('end_time', substr($booking->end_time, 0, 5)) == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                    {{ sprintf('%02d:00', $hour) }}
                                </option>
                            @endfor
                        </select>
                        <x-partials.input-error :messages="$errors->get('end_time')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500">Minimal booking 1 jam</p>
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
