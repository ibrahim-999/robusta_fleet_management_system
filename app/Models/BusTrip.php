<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'trip_start_date',
        'trip_end_date'
    ];
    protected $casts = [
        'trip_end_date' => 'datetime',
        'trip_start_date' => 'datetime'
    ];
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function stations(): HasMany
    {
        return $this
            ->hasMany(BusTripStation::class)
            ->orderBy('order');
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
