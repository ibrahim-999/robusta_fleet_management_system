<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusTripStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_trip_id',
        'city_id',
        'order'
    ];
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function busTrip(): BelongsTo
    {
        return $this->belongsTo(BusTrip::class);
    }
    public function bookingStations(): HasMany
    {
        return  $this->hasMany(BookingStation::class);
    }
}
