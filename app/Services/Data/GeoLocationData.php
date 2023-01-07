<?php

namespace App\Services\Data;

class GeoLocationData
{
    public function __construct(
        public float $lattitude,
        public float $longhitude,
    ) {
    }
}
