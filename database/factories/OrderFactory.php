<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wagon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'wagon_id' => Wagon::inRandomOrder()->first()->id ?? null,
            'order_number' => 'ORD-' . $this->faker->unique()->numerify('#####'),
            'description' => $this->faker->sentence(8),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'delivery_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
        ];
    }
}
