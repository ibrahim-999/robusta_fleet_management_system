<?php

use App\Models\Booking;
use App\Models\BusTripStation;
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
        Schema::create('booking_stations', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignIdFor(Booking::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(BusTripStation::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_stations');
    }
};
