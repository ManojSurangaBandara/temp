<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\ApiKey;
use App\Models\Bungalow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BungalowController extends Controller
{
    private function validateApiKey($request)
    {
        $apiKey = $request->header('api-key');

        if (!$apiKey) {
            //return response()->json(['message' => 'API key is missing.'], 200);
            return false;
        }

        //$isValid = DB::table('api_keys')->where('key', $apiKey)->exists();
        $isValid = ApiKey::where('api_key',$apiKey)->exists();

        if (!$isValid) {
            //return response()->json(['message' => 'Invalid API key.'], 200);
            return false;
        }

        // API key is valid
        return true;
    }
    
    public function index(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }
        

        $validator = Validator::make($request->all(), [
            'rank' => 'required|string',
        ], [
            'rank.required' => 'The rank is required.',
            'rank.string' => 'The rank must be a string.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        $nameToFilter = $request->rank;
        
        try {            
            $bungalows = Bungalow::select('id','name','no_ac_room','no_none_ac_room','no_guest','serving_price','retired_price','official_price','location')
                        ->whereHas('ranks', function ($query) use ($nameToFilter) {
                            $query->where('name', $nameToFilter);
                        })
                        ->get();

            return response()->json(['bungalows' => $bungalows],200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }
}
