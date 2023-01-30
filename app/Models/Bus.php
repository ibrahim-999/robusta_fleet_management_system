<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function trips(): HasMany
    {
        return $this->hasMany(BusTrip::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(BusSeat::class);
    }
}
