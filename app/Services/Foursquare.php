<?php

namespace App\Services;

use App\Services\Data\GeoLocationData;
use App\Services\Data\NearByPlaceData;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Foursquare
{
    const BASE_URL = 'https://api.foursquare.com/v3';
    const MAX_RESULT = 50;
    const RESPONSE_FIELDS = ['photos', 'name', 'location', 'distance', 'categories', 'geocodes'];
    const PHOTO_DIMENSION = '720x720';

    /**
     * Configure Http Client to sen request to Foursquare
     *
     * @var \Illuminate\Http\Client\PendingRequest
     */
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::baseUrl(self::BASE_URL)
            ->withHeaders([
                'Authorization' => config('services.foursquare.api_key')
            ]);
    }

    public function getNearByPlaces(GeoLocationData $geoCode, string $venue, int $limit = self::MAX_RESULT): Collection
    {
        $response = $this->httpClient->get('/places/search', [
            'query' => $venue,
            'll' => $geoCode->lattitude . ',' . $geoCode->longhitude,
            'limit' => $limit,
            'fields' => implode(',', self::RESPONSE_FIELDS)
        ]);

        $result = $response->json();

        return collect(array_map(fn ($place) => new NearByPlaceData(
            empty(Arr::get($place, 'photos')) ? null : Arr::get($place, 'photos.0.prefix')  . self::PHOTO_DIMENSION . Arr::get($place, 'photos.0.suffix'),
            Arr::get($place, 'name'),
            Arr::get($place, 'location.formatted_address'),
            Arr::get($place, 'distance'),
            array_map(fn ($category) => Arr::get($category, 'name'), Arr::get($place, 'categories')),
            new GeoLocationData(Arr::get($place, 'geocodes.main.latitude'), Arr::get($place, 'geocodes.main.longitude'))
        ), Arr::get($result, 'results')));
    }
}
