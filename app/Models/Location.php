<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'abb',
        'type',
    ];

    // Method to retrieve and cache the location data from your API
    public static function getLocationsFromAPI()
    {
        return Cache::remember('locations', now()->addHours(24), function () {    
            try {
                $client = new Client([
                    'verify' => false,
                ]);
                
                $response = $client->get('https://str.army.lk/api/get_establishments/?str-token=1189d8dde195a36a9c4a721a390a74e6');

                if ($response->getStatusCode() === 200) {
                    $jsonContent = $response->getBody()->getContents();
                    return json_decode($jsonContent, true);
                } else {
                    // Handle the case where the response status code is not 200
                    // You can log the error or perform other error-handling actions here
                    return [];
                }
            } catch (GuzzleException $e) {
                // Handle any Guzzle exceptions here
                // You can log the exception or perform other error-handling actions here
                return [];
            }
        });
    }
}
