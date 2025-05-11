<?php

namespace Database\Factories;

use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Van>
 */
class VanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = (new \Faker\Factory())::create();
        $faker->addProvider(new Fakecar($faker));

        $vehicle = $faker->vehicleArray;

        return [
            'name' => $vehicle['brand'],
            'year' => $faker->year(),  // Yil
            'reg' => $faker->vehicleRegistration(),
            'capacity' => $faker->numberBetween(500, 5000),  // Kapanatlikni tasodifiy ravishda yaratish
            'status' => $faker->randomElement(['active', 'inactive', 'maintenance']),  // Statusni tasodifiy ravishda tanlash
        ];
    }
}
