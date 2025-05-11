<?php

namespace Database\Seeders;

use App\Models\Van;
use App\Models\Wagon;
use Illuminate\Database\Seeder;

class WagonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agar Van jadvalida hech qanday ma'lumot bo'lmasa, yangi Van yaratish
        if (Van::count() == 0) {
            Van::factory(5)->create(); // 5 ta tasodifiy van yaratish
        }

        // Van modelidan tasodifiy van_id tanlash
        $vans = Van::all();

        // Agar Van mavjud bo'lsa, 20 ta wagon yaratish
        \App\Models\Wagon::factory(20)->create([
            'van_id' => $vans->random()->id,  // tasodifiy van_id tanlash
            'status' => collect(['active', 'maintenance', 'inactive'])->random(), // tasodifiy status
            'capacity' => rand(100, 1000),  // tasodifiy capacity qiymati
            'wagon_number' => 'WGN' . rand(1000, 9999),  // tasodifiy wagon_number
        ]);
    }
}
