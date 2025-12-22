<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'location' => $this->faker->address(),
            'capacity' => $this->faker->numberBetween(5, 100),
            'is_active' => $this->faker->boolean(80), // 80% chance of being true
        ];
    }
}
