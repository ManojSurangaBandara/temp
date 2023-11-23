<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Bank;
use App\Models\ApiKey;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
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
            $banks = Bank::select('id','name')
                        ->where('status',1)
                        ->get();

            return response()->json(['banks' => $banks],200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }
    
}
