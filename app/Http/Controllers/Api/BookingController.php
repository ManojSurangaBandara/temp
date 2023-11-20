<?php

namespace App\Http\Controllers\Api;

use Exception;
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

            // $allDays = [];
            // foreach ($bookings as $booking) {
            //     $checkIn = new Carbon($booking->check_in);
            //     $checkOut = new Carbon($booking->check_out);

            //     while ($checkIn->lt($checkOut)) {
            //         $allDays[] = ['date' => $checkIn->toDateString()];
            //         $checkIn->addDay();
            //     }
            // }

            //return response()->json(['bookings' => $bookings],200);

            return response()->json(['all_days' => $allDays], 200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }

    public function serachbyEno(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'eno' => 'required',
        ], [
            'eno.required' => 'The eno is required.',            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }        
        
        try {            
            $bookings = Booking::select('check_in','check_out','paid_amount','created_at','level')
                        ->where('eno',$request->eno)
                        ->where('save',0)
                        ->orderBy('created_at', 'asc')
                        ->get();
            

            return response()->json(['bookings' => $bookings],200);            

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
            'army_id' => 'nullable|string',
            'bungalow_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'type' => 'required',
            'level' => 'required',
            'paid_amount' => 'required',
            'rank' => 'required|string',
            'no_of_days' => 'required',
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

            'army_id.nullable' => 'The army id is required.',
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

            'paid_amount.required' => 'The paid amount is required.',

            'rank.required' => 'The rank is required.',
            'rank.string' => 'The rank must be a string.',

            'no_of_days.required' => 'The number of days is required.',
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
                'paid_amount' =>$request->paid_amount,
                'rank' => $request->rank,
                'no_of_days' => $request->no_of_days,
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

    public function storeGuest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'booking_id' => 'required',
            // 'name' => 'required|string|array',
            // 'nic'  => 'string|array',

            'booking_id' => 'required|exists:bookings,id', // Ensure the provided booking_id exists
            'guests' => 'required|array|min:1',
            'guests.*.name' => 'required|string',
            'guests.*.nic' => 'nullable|string',
            'level' => 'required',
        ], [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The provided booking ID does not exist.',
            'guests.required' => 'At least one guest is required.',
            'guests.array' => 'The guests field must be an array.',
            'guests.min' => 'At least one guest is required.',
            'guests.*.name.required' => 'The name field for each guest is required.',
            'guests.*.name.string' => 'The name field must be a string.',
            'guests.*.nic.nullable' => 'The NIC field must be nullable.',
            'guests.*.nic.string' => 'The NIC field must be a string.',
            'level.required' => 'The Level is required.',            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }
        
        $booking = Booking::findOrFail($request->input('booking_id'));

        $guestData = $request->input('guests');

        //dd($guestData);

        // // Find the existing BookingGuest records for the specified booking_id
        // $bookingGuests = BookingGuest::where('booking_id', $request->input('booking_id'))->get();

        // // Delete the existing BookingGuest records
        // foreach ($bookingGuests as $bookingGuest) {
        //     $bookingGuest->delete();
        // }
        
        try {
            foreach ($guestData as $guest) {
                $booking->bookingGuests()->create([
                    'name' => $guest['name'],
                    'nic' => $guest['nic'],
                ]);
            }
    
            return response()->json([
                'message' => 'Success',
                'status' => 1,
                'booking_id' => $booking->id,
            ], 200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }

    // public function storeGuest(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'booking_id' => 'required|exists:bookings,id',
    //         'guests' => 'required|array|min:1',
    //         'guests.*.name' => 'required|string',
    //         'guests.*.nic' => 'nullable|string',
    //         'level' => 'required',
    //     ], [
    //         'booking_id.required' => 'The booking ID is required.',
    //         'booking_id.exists' => 'The provided booking ID does not exist.',
    //         'guests.required' => 'At least one guest is required.',
    //         'guests.array' => 'The guests field must be an array.',
    //         'guests.min' => 'At least one guest is required.',
    //         'guests.*.name.required' => 'The name field for each guest is required.',
    //         'guests.*.name.string' => 'The name field must be a string.',
    //         'guests.*.nic.nullable' => 'The NIC field must be nullable.',
    //         'guests.*.nic.string' => 'The NIC field must be a string.',
    //         'level.required' => 'The Level is required.',            
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
    //     }
        
    //     $booking = Booking::findOrFail($request->input('booking_id'));

    //     $guestData = $request->input('guests');

    //     // Find the existing BookingGuest records for the specified booking_id
    //     $existingBookingGuests = BookingGuest::where('booking_id', $request->input('booking_id'))->get();

    //     // Compare the existing and new guest data
    //     $guestsToDelete = $existingBookingGuests->filter(function ($existingGuest) use ($guestData) {
    //         foreach ($guestData as $newGuest) {
    //             if ($existingGuest->name === $newGuest['name'] && $existingGuest->nic === $newGuest['nic']) {
    //                 return false; // Details match, do not delete
    //             }
    //         }
    //         return true; // Details are different, delete
    //     });

    //     // Delete the filtered existing BookingGuest records
    //     foreach ($guestsToDelete as $guestToDelete) {
    //         $guestToDelete->delete();
    //     }
        
    //     try {
    //         // Create and associate new BookingGuest records
    //         foreach ($guestData as $guest) {
    //             $booking->bookingGuests()->create([
    //                 'name' => $guest['name'],
    //                 'nic' => $guest['nic'],
    //             ]);
    //         }

    //         return response()->json([
    //             'message' => 'Success',
    //             'status' => 1,
    //             'booking_id' => $booking->id,
    //         ], 200);

    //     } catch (Exception $e) {

    //         return response()->json(['error' => 'An error occurred.'], 500);
    //     }
    // }


    public function storeVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id', // Ensure the provided booking_id exists
            'vehicles' => 'required|array|min:1',
            'vehicles.*.reg_no' => 'required|string',
            'level' => 'required',
        ], [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The provided booking ID does not exist.',
            'vehicles.required' => 'At least one guest is required.',
            'vehicles.array' => 'The vehicles field must be an array.',
            'vehicles.min' => 'At least one vehicle is required.',
            'vehicles.*.reg_no.required' => 'The reg no field for each vehicle is required.',
            'vehicles.*.reg_no.string' => 'The reg no field must be a string.',
            'level.required' => 'The Level is required.',            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }
        
        $booking = Booking::findOrFail($request->input('booking_id'));

        $vehicleData = $request->input('vehicles');

        //dd($vehicleData);
        
        try {
            foreach ($vehicleData as $vehicle) {
                $booking->bookingvehicles()->create([
                    'reg_no' => $vehicle['reg_no'],
                ]);
            }
    
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
