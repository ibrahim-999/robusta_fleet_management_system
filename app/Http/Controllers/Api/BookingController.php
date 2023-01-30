<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetAvailableSeatsRequest;
use App\Http\Resources\BusTripResource;
use App\Http\Resources\CitiesResource;
use App\Models\Booking;
use App\Models\BusTrip;
use App\Models\BusTripStation;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $start_station;
    protected $finish_station;
    protected $booking;

    public function setStartAndFinishStations($start_station, $finish_station): static
    {
        $this->start_station = $start_station;
        $this->finish_station = $finish_station;
        return $this;
    }
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function getStations(): array
    {
        return BusTripStation::whereBetween('id', [$this->start_station, $this->finish_station])
            ->orderBy('order')->pluck('id')->toArray();
    }
    public function getCities()
    {
        return JsonResponse::success([
            'cities' => CitiesResource::collection(City::paginate())
        ]);
    }

    public function getBusySeats($trip_id = null): array
    {
        $stations = $this->getStations();
        return Booking::query()
            ->when($trip_id, function ($query) use ($trip_id) {
                $query->where('bus_trip_id', $trip_id);
            })
            ->where(function ($query) {
                $query->where('finish_station', '!=', $this->start_station)
                    ->orWhere('start_station', $this->start_station);
            })
            ->whereHas('bookingStations', function ($booking_stations_query) use ($stations) {
                $booking_stations_query->whereIn('bus_trip_station_id', $stations);
            })
            ->distinct('bus_seat_id')
            ->pluck('bus_seat_id')
            ->toArray();
    }
    public function getAvailableSeats(GetAvailableSeatsRequest $request)
    {
        $busy_seats = $this->booking
            ->setStartAndFinishStations(
                $request
                    ->get('start_station'),
                $request
                    ->get('finish_station'))
            ->getBusySeats();

        $buses = BusTrip::whereDay('trip_start_date', today())
            ->whereHas('stations', function ($stations_query) use ($busy_seats) {
                $stations_query
                    ->whereIn('city_id', [
                        request('start_station'),
                        request('finish_station')]);
            })
            ->with('bus', function ($bus_query) use ($busy_seats) {
                $bus_query
                    ->with('seats', function ($seats_query) use ($busy_seats) {
                    $seats_query
                        ->whereNotIn('id', $busy_seats);
                });
            })
            ->with('stations.city')
            ->withCount('stations')
            ->paginate();
        return BusTripResource::collection($buses);
    }

}
