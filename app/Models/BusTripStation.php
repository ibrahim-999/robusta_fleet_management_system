<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusTripStation extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_ride_id',
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
}
