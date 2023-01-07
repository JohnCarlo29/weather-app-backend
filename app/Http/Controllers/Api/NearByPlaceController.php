<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NearByPlaceRequest;
use App\Services\Data\GeoLocationData;
use Facades\App\Services\Foursquare;

class NearByPlaceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\NearByPlaceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(NearByPlaceRequest $request)
    {
        $nearbyPlaces = Foursquare::getNearByPlaces(
            new GeoLocationData($request->lattitude, $request->longhitude),
            $request->establishments ?? ''
        );

        return response()->json($nearbyPlaces);
    }
}
