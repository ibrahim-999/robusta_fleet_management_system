<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = collect(['Cairo', 'Giza', 'Alfayyum', 'Alminya', 'Asyut'])
            ->map(function ($city) {
                return
                    [
                        'name' => $city,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
            })
            ->toArray();

        City::insert($cities);
    }
}
