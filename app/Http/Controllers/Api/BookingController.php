<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\BookingGuest;
use Illuminate\Http\Request;
use App\Models\BookingVehicle;
use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class BookingController extends Controller
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

    public function index(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

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

            // $allDays = [];
            // foreach ($bookings as $booking) {
            //     $checkIn = new Carbon($booking->check_in);
            //     $checkOut = new Carbon($booking->check_out);

            //     while ($checkIn->lt($checkOut)) { // Use $checkIn->lt($checkOut) instead of $checkIn->lte($checkOut)
            //         $allDays[] = $checkIn->toDateString();
            //         $checkIn->addDay();
            //     }
            // }

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

            //return response()->json(['all_days' => $allDays], 200);

            $allDays = [];
            $uniqueDays = [];

            foreach ($bookings as $booking) {
                $checkIn = new Carbon($booking->check_in);
                $checkOut = new Carbon($booking->check_out);

                while ($checkIn->lt($checkOut)) {
                    $currentDate = $checkIn->toDateString();

                    // Check if the date is not already in the uniqueDays array
                    if (!in_array($currentDate, $uniqueDays)) {
                        $allDays[] = $currentDate;
                        $uniqueDays[] = $currentDate;
                    }

                    $checkIn->addDay();
                }
            }

            return response()->json(['all_days' => $allDays], 200);


        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }

    public function serachbyEno(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'eno' => 'required',
        ], [
            'eno.required' => 'The eno is required.',            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }        
        
        try {            
            // $bookings = Booking::select('check_in', 'check_out', 'paid_amount', 'created_at', 'level', 'bungalow_id', 'id')
            //             ->with('bungalow') // Assuming 'name' is the attribute you want to retrieve from the Bungalow model
            //             ->where('eno', $request->eno)
            //             ->orderBy('created_at', 'asc')
            //             ->get();

            $bookings = Booking::select('check_in', 'check_out', 'paid_amount', 'created_at', 'level','cancel',
                                            'refund','refund_recieve', 'bungalow_id', 'id', 'filpath')
                        ->with('bungalow:id,name') // Specify the attributes you want to retrieve from the Bungalow model
                        ->where('eno', $request->eno)
                        ->orderBy('check_in', 'asc')
                        ->get()
                        ->map(function ($booking) {
                            $booking->bungalow = $booking->bungalow->pluck('name')->first();

                            // Set $has_refund to 1 if $booking->filpath is not null
                            $has_refund = ($booking->filpath && ($booking->cancel == 1 || $booking->cancel == 2)) ? 1 : 0;

                            $booking->has_refund = $has_refund;

                            return $booking->only(['check_in', 'check_out', 'paid_amount', 'created_at', 'level',
                                                    'cancel','refund','refund_recieve', 'id','bungalow_id','bungalow', 'has_refund']);
                        });
            

            return response()->json(['bookings' => $bookings],200);            

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }

    public function storeBooking(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

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

            'level.required' => 'The level is required.',
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
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }
        
        $validator = Validator::make($request->all(), [  

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

            $booking->update([
                'level' => $request->input('level')
            ]);

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

    public function storeGuestOne(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id',
            'name' => 'required|string',
            'nic' => 'nullable|string',
            'level' => 'required',
        ], [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The provided booking ID does not exist.',           
            'name.required' => 'The name field for each guest is required.',
            'name.string' => 'The name field must be a string.',
            'nic.nullable' => 'The NIC field can be nullable.',
            'nic.string' => 'The NIC field must be a string.',
            'level.required' => 'The Level is required.',            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }
        
        $booking = Booking::findOrFail($request->input('booking_id'));

        //$guest = $request->input('guests');       
        
        try {
            
            $booking->update([
                'level' => $request->input('level')
            ]);
            
            $booking->bookingGuests()->create([
                'name' => $request->name,
                'nic' => $request->nic,
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
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id', // Ensure the provided booking_id exists
            'vehicles' => 'required|array|min:1',
            'vehicles.*.reg_no' => 'required|string',
            //'level' => 'required',
        ], [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The provided booking ID does not exist.',
            'vehicles.required' => 'At least one guest is required.',
            'vehicles.array' => 'The vehicles field must be an array.',
            'vehicles.min' => 'At least one vehicle is required.',
            'vehicles.*.reg_no.required' => 'The reg no field for each vehicle is required.',
            'vehicles.*.reg_no.string' => 'The reg no field must be a string.',
            //'level.required' => 'The Level is required.',            
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

    public function storeVehicleOne(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id', 
            'reg_no' => 'required|string', 
            'level' => 'required',           
        ], [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The provided booking ID does not exist.',            
            'reg_no.required' => 'The reg no field for each vehicle is required.',
            'reg_no.string' => 'The reg no field must be a string.',
            'level.required' => 'The Level is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }
        
        $booking = Booking::findOrFail($request->input('booking_id'));        

        //dd($vehicleData);
        
        try { 

            $booking->update([
                'level' => $request->input('level')
            ]);

            $booking->bookingvehicles()->create([
                'reg_no' => $request->reg_no,
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

    public function getVehicles(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
        ], [
            'booking_id.required' => 'The booking id is required.',            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }        
        
        try {

            $vehicles = BookingVehicle::select('id','reg_no')
                        ->where('booking_id',$request->booking_id)
                        ->orderBy('created_at', 'asc')
                        ->get();
            

            return response()->json(['vehicles' => $vehicles],200);            

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function getGuests(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required',
        ], [
            'booking_id.required' => 'The booking id is required.',            
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }        
        
        try {

            $guests = BookingGuest::select('id','name','nic')
                        ->where('booking_id',$request->booking_id)
                        ->orderBy('created_at', 'asc')
                        ->get();
            

            return response()->json(['guests' => $guests],200);            

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }

    }

    public function updateGuest(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'nic' => 'nullable',
        ], [
            'id.required' => 'The guest id is required.',
            'name.required' => 'The name is required.',
            'nic.nullable' => 'The NIC can be nullable.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $guest = BookingGuest::find($request->id);

            if (!$guest) {
                return response()->json(['message' => 'Guest not found.', 'status' => 0], 404);
            }

            // Update guest details
            $guest->name = $request->name;
            $guest->nic = $request->nic;
            $guest->save();

            return response()->json(['message' => 'Guest updated successfully.', 'status' => 1], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function updateVehicle(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'reg_no' => 'required',
        ], [
            'id.required' => 'The vehicle id is required.',
            'reg_no.required' => 'The reg number is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $vehicle = BookingVehicle::find($request->id);

            if (!$vehicle) {
                return response()->json(['message' => 'vehicle not found.', 'status' => 0], 404);
            }

            // Update vehicle details
            $vehicle->reg_no = $request->reg_no;
            $vehicle->save();

            return response()->json(['message' => 'vehicle updated successfully.', 'status' => 1], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function deleteGuest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ], [
            'id.required' => 'The guest id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $guest = BookingGuest::find($request->id);

            if (!$guest) {
                return response()->json(['message' => 'Guest not found.', 'status' => 0], 404);
            }

            // Delete the guest
            $guest->delete();

            return response()->json(['message' => 'Guest deleted successfully.', 'status' => 1], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function deleteVehicle(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ], [
            'id.required' => 'The vehicle id is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }

        try {
            $vehicle = BookingVehicle::find($request->id);

            if (!$vehicle) {
                return response()->json(['message' => 'vehicle not found.', 'status' => 0], 404);
            }

            // Delete the vehicle
            $vehicle->delete();

            return response()->json(['message' => 'vehicle deleted successfully.', 'status' => 1], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    public function storePayment(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id', // Ensure the provided booking_id exists
            // 'bank_id' => 'required|exists:banks,id',
            // 'acc_no' => 'required',
            'payment' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'level' => 'required',
        ], [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The provided booking ID does not exist.',
            // 'bank_id.required' => 'The bank ID is required.',
            // 'bank_id.exists' => 'The provided bank ID does not exist.',
            // 'acc_no.required' => 'The Account number is required.',
            'payment.required' => 'The payment field is required.',
            'payment.image' => 'The payment must be an image.',
            'payment.mimes' => 'The payment must be a file of type: jpeg, png, jpg, gif.',
            'payment.max' => 'The payment may not be greater than 2048 kilobytes.', 
            'level.required' => 'The Level is required.'           
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }
        
        $booking = Booking::findOrFail($request->input('booking_id'));

        $paymentDirectory = public_path('/upload/payment/'.$request->booking_id.'/');

        if (!File::isDirectory($paymentDirectory)) {
            File::makeDirectory($paymentDirectory, 0777, true, true);
        }

        $extpayment = $request->file('payment')->extension();
        $filepayment = $request->booking_id.'.'.$extpayment;

        $request->file('payment')->move($paymentDirectory, $filepayment);

        
        try {
            if ($booking) {
                $booking->update([
                    'filpath' => '/upload/payment/'.$request->booking_id.'/'.$filepayment,
                    // 'bank_id' => $request->bank_id,
                    // 'acc_no' => $request->acc_no,
                    'level' => $request->level,                     
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

    public function cancelBooking(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id', // Ensure the provided booking_id exists                        
            //'cancel_remark_id' => 'required',
        ], [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The provided booking ID does not exist.',            
            //'cancel_remark_id.required' => 'The Level is required.'           
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }
        
        $booking = Booking::findOrFail($request->input('booking_id'));
        $contact = Contact::select('appointment','contact_info')->first();
        $currentDate = Carbon::now();
        
        try {
            if ($booking) {
                $booking->update([
                    'cancelremark_id' => 1,
                    'cancel_time' => $currentDate,
                    'cancel' => 1,                     
                ]);
            }
    
            // return response()->json([
            //     'message' => 'Success',
            //     'status' => 1,
            //     'booking_id' => $booking->id,
            // ], 200);

            $responseData = [
                'status' => 1,
                'booking_id' => $booking->id,
            ];
            
            if ($booking->filpath != null) {
                $responseData['message'] = 'Successfully cancelled, your payment will be refunded due course. for more details contact '
                                            .$contact->appointment.' '.$contact->contact_info;
                $responseData['paid_amount'] = $booking->paid_amount;
            } else {
                $responseData['message'] = 'You have Successfully cancelled your booking';
            }
            
            return response()->json($responseData, 200);

        } catch (Exception $e) {

            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }

    public function refundRecieveBooking(Request $request)
    {
        // if(!$this->validateApiKey($request))
        // {
        //     return response()->json(['message' => 'Invalid API key.'], 200);
        // }

        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|exists:bookings,id', 
        ], [
            'booking_id.required' => 'The booking ID is required.',
            'booking_id.exists' => 'The provided booking ID does not exist.',             
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'status' => 0], 200);
        }
        
        $booking = Booking::findOrFail($request->input('booking_id'));
        $currentDate = Carbon::now();
        
        try {
            if ($booking) {
                $booking->update([
                    'refund_recieve' => 1,
                    'refund_recieve_time' => $currentDate,                     
                ]);
            }

            $responseData = [
                'status' => 1,
                'booking_id' => $booking->id,
            ];            
            
            $responseData['message'] = 'Refund Recieved';
            $responseData['paid_amount'] = $booking->paid_amount;
            
            
            return response()->json($responseData, 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
        
    }
}
