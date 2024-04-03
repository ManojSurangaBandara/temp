<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CYBSPEBBasicService;
//use App\Services\CYBSPEBBasicService;

class PaymentController extends Controller
{
    protected $cybersourceService;

    public function __construct(CYBSPEBBasicService $cybersourceService)
    {
        $this->cybersourceService = $cybersourceService;
    }

    public function generateForm(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'booking_id' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        // Generate the form text using the service class
        $formText = $this->cybersourceService->getDefaultForm($request->booking_id, $request->amount);

        // Pass the form text to the view
        return view('payment.form', ['formText' => $formText]);
    }
}
