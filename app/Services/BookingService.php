<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BusTripStation;

class BookingService
{
    protected $start_station;
    protected $finish_station;
    public function setStartAndFinishStations($start_station, $finish_station): static
    {
        $this->start_station = $start_station;
        $this->finish_station = $finish_station;
        return $this;
    }
    public function getStations(): array
    {
        return BusTripStation::whereBetween('id', [$this->start_station, $this->finish_station])
            ->orderBy('order')
            ->pluck('id')
            ->toArray();
    }
    public function getBusySeats($trip_id = null): array
    {
        $stations = $this->getStations();
        return Booking::query()
            ->when($trip_id, function ($query) use ($trip_id) {
                $query
                    ->where('bus_trip_id', $trip_id);
            })
            ->where(function ($query) {
                $query
                    ->where('finish_station', '!=', $this->start_station)
                    ->orWhere('start_station', $this->start_station);
            })
            ->whereHas('bookingStations', function ($booking_stations_query) use ($stations) {
                $booking_stations_query
                    ->whereIn('bus_trip_station_id', $stations);
            })
            ->distinct('bus_seat_id')
            ->pluck('bus_seat_id')
            ->toArray();
    }
}
