<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'bus_trip_station_id'
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function busTripStation(): BelongsTo
    {
        return $this->belongsTo(BusTripStation::class);
    }
}
