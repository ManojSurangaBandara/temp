<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Calendareligibilty;
use App\Http\Controllers\Controller;

class Calendareligibilty extends Controller
{
    public function index()
    {

        try {
            $no_of_days = Calendareligibilty::select('no_of_days')->where('active','=','1')->latest()->get();

            return response()->json(['no_of_days' => $no_of_days],200);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }

    }
}
