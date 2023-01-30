<?php

use App\Models\BusTrip;
use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_trip_stations', function (Blueprint $table) {
            $table->id();
            $table->integer('order');

            $table
                ->foreignIdFor(BusTrip::class)
                ->constrained()
                ->cascadeOnDelete();

            $table
                ->foreignIdFor(City::class)
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_trip_stations');
    }
};
