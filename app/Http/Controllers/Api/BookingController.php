<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bungalow_id' => 'required',
        ], [
            'bungalow_id.required' => 'The bungalow is required.',            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }        
        
        try {            
            $bookings = Booking::select('check_in','check_out',)
                        ->where('bungalow_id',$request->bungalow_id)
                        ->get();

            $allDays = [];
            foreach ($bookings as $booking) {
                $checkIn = new Carbon($booking->check_in);
                $checkOut = new Carbon($booking->check_out);

                while ($checkIn->lt($checkOut)) { // Use $checkIn->lt($checkOut) instead of $checkIn->lte($checkOut)
                    $allDays[] = $checkIn->toDateString();
                    $checkIn->addDay();
                }
            }

            //return response()->json(['bookings' => $bookings],200);

            return response()->json(['all_days' => $allDays], 200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }

    public function storeBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'regiment' => 'required|string',
            'eno' => 'required|string',
            'unit'  => 'required|string',
            'svc_no'  => 'required|string',
            'name' => 'required|string',
            'nic'  => 'required|string',
            'contact_no' => 'required|string',
            'army_id' => 'required|string',
            'bungalow_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'type' => 'required',
            'level' => 'required',
        ], [
            'regiment.required' => 'The regiment is required.',
            'regiment.string' => 'The regiment must be a string.',

            'unit.required' => 'The unit is required.',
            'unit.string' => 'The unit must be a string.',

            'svc_no.required' => 'The service no is required.',
            'svc_no.string' => 'The service no must be a string.',

            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',

            'nic.required' => 'The nic is required.',
            'nic.string' => 'The nic must be a string.',

            'contact_no.required' => 'The contact number is required.',
            'contact_no.string' => 'The contact number must be a string.',

            'army_id.required' => 'The army id is required.',
            'army_id.string' => 'The army id must be a string.',

            'bungalow_id.required' => 'The bungalow id is required.',
            'bungalow_id.string' => 'The bungalow id must be a string.',

            'check_in.required' => 'The check in id is required.',
            'check_in.date' => 'The check in id must be a date.',

            'check_out.required' => 'The check out id is required.',
            'check_out.date' => 'The check out id must be a date.',

            'eno.required' => 'The eno is required.',
            'eno.string' => 'The eno must be a string.',

            'type.required' => 'The type id is required.',

            'level.required' => 'The level id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }      
        
        try {

            $booking = Booking::create([
                'regiment' => $request->regiment,
                'unit'  => $request->unit,
                'svc_no'  => $request->svc_no,
                'name' => $request->name,
                'nic'  => $request->nic,
                'contact_no' => $request->contact_no,
                'army_id' => $request->army_id,
                'bungalow_id' => $request->bungalow_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'type' => $request->type,
                'save' => 0,
                'level' => $request->level,
                'eno' => $request->eno,
            ]);
    
            return response()->json([
                'message' => 'Success',
                'status' => 1,
                'booking_id' => $booking->id,
            ], 200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }
}
