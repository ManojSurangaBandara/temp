<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;

class Cron extends Controller
{
    public function autoCancelBookings()
    {
        $twentyFourHoursAgo = Carbon::now()->subDay();
        
        $bookingsToUpdate = Booking::where('created_at', '<', $twentyFourHoursAgo)
                            ->where('cancel',0)
                            ->get();

        //dd($bookingsToUpdate);

        foreach ($bookingsToUpdate as $booking) {
            // Update logic goes here
            $booking->update([
                'cancel'=>1,
                'cancel_time'=>Carbon::now(),
            ]);
        }

        return response()->json(['message' => 'Bookings updated successfully'], 200);
    }
}
