<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VenueService
{
    public function getVenueData($city)
    {
        // Get venue data from Foursquare
        $response = Http::withHeaders([
            'Authorization' => env('FOURSQUARE_API_KEY'),
            'Accept' => 'application/json'
        ])->get("https://api.foursquare.com/v3/places/search", [
            'near' => $city.', JP',
            'limit' => 12,
        ]);

        return $response->json();
    }
}