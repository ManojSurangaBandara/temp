<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Calendareligibilty;
use App\Http\Controllers\Controller;

class CalendareligibiltyController extends Controller
{
    public function index()
    {
        try {
            $no_of_days = Calendareligibilty::select('no_of_days')->where('active','=','1')->latest()->first();

            return response()->json(['calendar_dates' => $no_of_days],200);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
