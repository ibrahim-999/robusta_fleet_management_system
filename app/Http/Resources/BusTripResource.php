<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusTripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'trip_start_date' => $this->trip_start_date->toDateTimeString(),
            'trip_end_date' => $this->trip_end_date->toDateTimeString(),
            'stations_count' => $this->stations_count,
            'bus' => new BusResource($this->whenLoaded('bus')),
            'stations' => BusTripStationResource::collection($this->whenLoaded('stations')),
        ];
    }
}
