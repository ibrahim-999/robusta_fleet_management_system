<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;
    protected $fillable =[
        'bus_trip_id',
        'user_id',
        'bus_seat_id',
        'start_station',
        'finish_station'
    ];

    public function busSeat(): BelongsTo
    {
        return $this->belongsTo(BusSeat::class);
    }
    public function busTrip(): BelongsTo
    {
        return $this->belongsTo(BusTrip::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
