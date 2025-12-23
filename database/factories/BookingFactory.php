<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookingDate = $this->faker->dateTimeBetween('+1 days', '+30 days');

        return [
            'room_id' => Room::factory(),
            'user_id' => User::factory(),
            'booking_date' => $bookingDate->format('Y-m-d'),
            'start_time' => $this->faker->time('H:i', '17:00'),
            'end_time' => $this->faker->time('H:i', '18:00'),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'cancelled']),
            'note' => $this->faker->optional()->paragraph(),
        ];
    }
}
