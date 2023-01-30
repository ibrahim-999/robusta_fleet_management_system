<?php

use App\Models\BusSeat;
use App\Models\BusTrip;
use App\Models\User;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignIdFor(BusTrip::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(BusSeat::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignId('start_station')
                ->constrained('cities')
                ->cascadeOnDelete();
            $table
                ->foreignId('finish_station')
                ->constrained('cities')
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
        Schema::dropIfExists('bookings');
    }
};
