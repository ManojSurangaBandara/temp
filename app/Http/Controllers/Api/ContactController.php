<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\ApiKey;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
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
            $contacts = Contact::select('appointment','contact_info')
                        ->get();

            return response()->json(['contacts' => $contacts],200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }
}
