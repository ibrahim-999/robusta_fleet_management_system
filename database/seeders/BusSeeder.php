<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\BusTrip;
use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bus::factory(2)
            ->create()
            ->each(function (Bus $bus) {
                //Pick city for trip -- missing trip stations
                $cities = City::pluck('id');
                BusTrip::factory(1, ['bus_id' => $bus->id])->create();
            });
    }
}
