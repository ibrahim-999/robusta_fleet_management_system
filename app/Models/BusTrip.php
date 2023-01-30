<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'trip_start_date',
        'trip_end_date'
    ];
    protected $casts = [
        'ride_end_date' => 'datetime',
        'ride_start_date' => 'datetime'
    ];
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }
}
