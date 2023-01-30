<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\BusTrip;
use App\Models\BusTripStation;
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
            ->hasSeats(random_int(30,50))
            ->create()
            ->each(function (Bus $bus) {
                $cities = City::pluck('id');
                BusTrip::factory(1, ['bus_id' => $bus->id])
                    ->create()
                    ->each(function (BusTrip $busRide) use (&$order, &$cities) {
                        for ($i = 0; $i <= 3; $i++) {
                            $random_city = $cities->random();
                            BusTripStation::factory(1, [
                                'city_id' => $random_city,
                                'bus_ride_id' => $busRide->id,
                                'order' => $i
                            ])->create();
                            $cities->forget($cities->search($random_city));
                        }
                    });
            });
    }
}
