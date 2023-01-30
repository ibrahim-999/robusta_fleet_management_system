<?php

namespace Database\Factories;

use App\Models\BusTrip;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BusTrip>
 */
class BusTripFactory extends Factory
{
    protected $model = BusTrip::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'trip_start_date' => Carbon::now(),
            'trip_end_date' => Carbon::now()->addHours($this->faker->numberBetween(1,9)),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
