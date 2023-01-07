<?php

namespace App\Services\Data;

class NearByPlaceData
{
    public function __construct(
        public ?string $photo,
        public string $name,
        public string $address,
        public int $distance,
        public array $categories,
        public GeoLocationData $geoCode
    ) {
    }
}
