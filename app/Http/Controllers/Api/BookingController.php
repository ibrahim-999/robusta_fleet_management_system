<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetAvailableSeatsRequest;
use App\Http\Resources\BusTripResource;
use App\Http\Resources\CitiesResource;
use App\Models\BusTrip;
use App\Models\City;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function getCities()
    {
        return JsonResponse::success([
            'cities' => CitiesResource::collection(City::paginate())
        ]);
    }

    public function getAvailableSeats(GetAvailableSeatsRequest $request)
    {
        $busy_seats = $this->bookingService
            ->setStartAndFinishStations(
                $request->get('start_station'),
                $request->get('finish_station'))
            ->getBusySeats();

        $buses = BusTrip::whereDay('trip_start_date', today())
            ->whereHas('stations', function ($stations_query) use ($busy_seats) {
                $stations_query
                    ->whereIn('city_id', [
                        request('start_station'),
                        request('finish_station')
                    ]);
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
