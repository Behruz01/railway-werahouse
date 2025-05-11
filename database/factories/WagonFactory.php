<?php

namespace Database\Factories;

use App\Models\Van;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wagon>
 */
class WagonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'van_id' => Van::inRandomOrder()->first()->id, // Tasodifiy van_id tanlash
            'wagon_number' => 'WGN' . $this->faker->unique()->numberBetween(1000, 9999), // Wagon raqami
            'capacity' => $this->faker->numberBetween(100, 1000), // kapasite
            'status' => $this->faker->randomElement(['active', 'maintenance', 'inactive']), // status
        ];
    }
}
