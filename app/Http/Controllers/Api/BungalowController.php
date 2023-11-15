<?php

namespace App\Http\Controllers\Api;

use App\Models\Bungalow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BungalowController extends Controller
{
    public function index(Request $request)
    {
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
            $bungalows = Bungalow::select('id','name','no_ac_room','no_none_ac_room','no_guest','serving_price','retired_price','death_price')
                        ->whereHas('bunglowrank.rank', function ($query) use ($nameToFilter) {
                            $query->where('name', $nameToFilter);
                        })
                        ->get();

            return response()->json(['bungalows' => $bungalows],200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }
}
