<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Rank extends Model
{
    use HasFactory;

    public static function getRanksFromAPI()
    {
        return Cache::remember('ranks', now()->addHours(24), function () {
            $response = Http::get('your-api-endpoint-here');
            return $response->json();
        });
    }
}
