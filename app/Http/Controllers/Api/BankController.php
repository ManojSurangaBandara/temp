<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Exception;

class BankController extends Controller
{
    public function index()
    {        
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
