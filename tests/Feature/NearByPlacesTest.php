<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NearByPlacesTest extends TestCase
{
    /** @test */
    public function fetchNearbyPlaces()
    {
        Http::fake([
            '*' => Http::response(Storage::get('mocks/nearby_places.json'), Response::HTTP_OK)
        ]);

        $this->getJson(route('place.nearby', [
            'lattitude' => 1.1,
            'longhitude' => 1.1
        ]))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'photo',
                    'name',
                    'address',
                    'distance',
                    'categories',
                    'geoCode' => ['lattitude', 'longhitude'],
                ]
            ]);
    }

    /**
     * @test
     * @dataProvider validationProviders
     */
    public function validationFailed($lattitude, $longhitude, $establishments)
    {
        $params = [
            'lattitude' => $lattitude,
            'longhitude' => $longhitude
        ];

        if (!is_null($establishments)) {
            $params['establishments'] = $establishments;
        }

        $this->getJson(route('place.nearby', $params))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function validationProviders()
    {
        return [
            [1.0, null, null],
            [null, 1.0, null],
            [1.0, 1.0, '']
        ];
    }
}
