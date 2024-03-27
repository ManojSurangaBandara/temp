<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    public function index()
    {

        try {
            $url = Support::select('url')->get();

            return response()->json(['url' => $url],200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }

    }
}
