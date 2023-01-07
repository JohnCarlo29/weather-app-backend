<?php

namespace App\Services\Data;

class WeatherForecastData
{
    public function __construct(
        public GeoLocationData $geoCode,
        public string $location,
        public string $currentDateTime,
        public string $currentWeather,
        public string $currentWeatherDescription,
        public float $currentTemperature,
        public float $minTemperature,
        public float $maxTemperature,
        public float $pressure,
        public float $humidity,
        public float $visibility,
        public float $windSpeed,
        public float $windDegree,
        public string $sunrise,
        public string $sunset
    ) {
    }
}
