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
        return [
            'room_id' => Room::factory(),
            'user_id' => User::factory(),
            'start_time' => $this->faker->dateTimeBetween('+1 days', '+10 days'),
            'end_time' => $this->faker->dateTimeBetween('+11 days', '+20 days'),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'cancelled']),
            'note' => $this->faker->optional()->paragraph(),
        ];
    }
}
