<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable =[
        'bus_ride_id',
        'user_id',
        'bus_seat_id',
        'start_station',
        'finish_station'
    ];
}
