<?php

namespace App\Http\Controllers\Api;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CancelRemark;
use Exception;

class CancelRemarkController extends Controller
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
    
    public function index()
    {  
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        try {            
            $cancelremarks = CancelRemark::select('id','name')
                        ->where('status',1)
                        ->get();

            return response()->json(['cancelremarks' => $cancelremarks],200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }
}
