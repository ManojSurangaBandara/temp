<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Rank;
use App\Models\Unit;
use App\Models\Booking;
use App\Models\Bungalow;
use App\Models\Regiment;
use App\Models\Directorate;
use App\Models\CancelRemark;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use App\DataTables\BookingDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\returnSelf;
use App\DataTables\PendingBookingApproveDataTable;

class BookingController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:booking-list|booking-create|booking-edit|booking-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:booking-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:booking-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:booking-delete', ['only' => ['destroy']]);
    //      $this->middleware('permission:booking-cancel', ['only' => ['cancelBookingView','cancelBooking']]);
    //      $this->middleware('permission:booking-refund', ['only' => ['refundBooking']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bungalows  = Bungalow::where('status','=',1)->where('directorate_id', Auth::user()->directorate_id)->get();
        return view('bookings.bungalows',compact('bungalows'));
    }

    public function bookings(BookingDataTable $dataTable, Bungalow $bungalow){
        //($bungalow);
        return $dataTable->with(['bungalow'=>$bungalow])->render('bookings.index',compact('bungalow'));
    }

    public function bookingPending(PendingBookingApproveDataTable $dataTable)
    {
        return $dataTable->render('bookings.index');
    }

    public function calenderView(Bungalow $bungalow)
    {
        //dd($bungalow->id);
        $bookings = Booking::where('bungalow_id', $bungalow->id)
                    ->where('approve',1)
                    ->where('cancel','!=', 1)
                    ->where('refund','!=', 1)
                    //->where('check_out','<',Carbon::now())
                    ->get();

        // return view('bookings.calender',compact('bookings'));

        // Prepare an array to store FullCalendar events
        $events = [];

        foreach ($bookings as $booking) {
            // Add each booking as an event
            $events[] = [
                'title' => $booking->name,
                'start' => $booking->check_in,
                'end' => $booking->check_out,
                // You can add more properties if needed
            ];
        }
        //dd($events);

        // Pass the events to the view
        return view('bookings.calender', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ranks = Rank::where('status',1)->get();
        return view('bookings.create',compact('ranks'));
    }

    public function createRetired()
    {
        $ranks = Rank::where('status',1)->get();
        $regiments = Regiment::where('status',1)->get();
        $units = Unit::where('status',1)->get();
        //$directorates = Directorate::where('status',1)->get();
        $bungalows = Bungalow::where('status',1)->get();

        return view('bookings.create_retired',compact('ranks','regiments','units','bungalows'));
    }

    public function createRetiredAdmin()
    {
        $ranks = Rank::where('status',1)->get();
        $regiments = Regiment::where('status',1)->get();
        $units = Unit::where('status',1)->get();
        //$directorates = Directorate::where('status',1)->get();
        $bungalows = Bungalow::where('status',1)->get();

        return view('bookings.create_retired_admin',compact('ranks','regiments','units','bungalows'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request,[
            // 'regiment' => 'required|string',
            'eno' => 'required|string',
            // 'unit'  => 'required|string',
            'svc_no'  => 'required|string',
            // 'name' => 'required|string',
            // 'nic'  => 'required|string',
            // 'contact_no' => 'required|string',
            'army_id' => 'required',
            'bungalow_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            // 'type' => 'required',
            // 'level' => 'required',
            'payment' => 'required',
        ], [
            // 'regiment.required' => 'The regiment is required.',
            // 'regiment.string' => 'The regiment must be a string.',

            // 'unit.required' => 'The unit is required.',
            // 'unit.string' => 'The unit must be a string.',

            'svc_no.required' => 'The service no is required.',
            'svc_no.string' => 'The service no must be a string.',

            // 'name.required' => 'The name is required.',
            // 'name.string' => 'The name must be a string.',

            // 'nic.required' => 'The nic is required.',
            // 'nic.string' => 'The nic must be a string.',

            // 'contact_no.required' => 'The contact number is required.',
            // 'contact_no.string' => 'The contact number must be a string.',

            'army_id.required' => 'The army id is required.',

            'bungalow_id.required' => 'The bungalow id is required.',
            'bungalow_id.string' => 'The bungalow id must be a string.',

            'check_in.required' => 'The check in id is required.',
            'check_in.date' => 'The check in id must be a date.',

            'check_out.required' => 'The check out id is required.',
            'check_out.date' => 'The check out id must be a date.',
            'check_out.after' => 'The check out date must be a after check in date.',

            'eno.required' => 'The eno is required.',
            'eno.string' => 'The eno must be a string.',

            // 'type.required' => 'The type id is required.',

            // 'level.required' => 'The level id is required.',
        ]);

        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        //dd($checkIn);

        // $results = Booking::where('bungalow_id', $request->bungalow_id)
        // ->where(function ($query) use ($checkIn, $checkOut) {
        //     $query->where(function ($subquery) use ($checkIn, $checkOut) {
        //         $subquery->where('check_in', '<=', $checkIn)
        //             ->where('check_out', '>=', $checkOut);
        //     });
        // })
        // ->get();

        // $results = Booking::where(function ($query) use ($checkIn, $checkOut) {
        //             $query->where('check_in', '<=', $checkIn)
        //               ->where('check_out', '>=', $checkOut);
        //             })
        //             ->get();

        $results = Booking::where(function ($query) use ($checkIn, $checkOut) {
                    $query->where('check_in', '<=', $checkOut)
                        ->where('check_out', '>=', $checkIn);
                    })
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_in', '>=', $checkIn)
                            ->where('check_in', '<=', $checkOut);
                    })
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_out', '>=', $checkIn)
                            ->where('check_out', '<=', $checkOut);
                    })
                    ->get();

        //dd($results);

        if (!$results->isEmpty())
        {
            return redirect()->back()->with('danger', 'Already booked');
        }

        try {

            $booking = Booking::create([
                // 'regiment' => $request->regiment,
                // 'unit'  => $request->unit,
                // 'svc_no'  => $request->svc_no,
                // 'name' => $request->name,
                // 'nic'  => $request->nic,
                // 'contact_no' => $request->contact_no,
                'regiment' => $request->regiment,
                'unit'  => $request->unit,
                'svc_no'  => $request->svc_no,
                'name' => $request->name,
                'nic'  => $request->nic,
                'contact_no' => $request->contact_no,
                'rank' => $request->rank_id,
                'eno' => $request->eno,
                'army_id' => $request->army_id,
                'bungalow_id' => $request->bungalow_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'type' => $request->type,
                'save' => 0,
                'level' => 3,
                'paid_amount' => $request->payment,
                'approve' => $request->approve,
            ]);

            $guestData = $request->input('guests');

            if($guestData)
            {
                foreach ($guestData as $guest) {
                    $booking->bookingGuests()->create([
                        'name' => $guest['name'],
                        'nic' => $guest['nic'],
                    ]);
                }
            }

            $vehicleData = $request->input('vehicles');

            if($vehicleData)
            {
                foreach ($vehicleData as $vehicle) {
                    $booking->bookingvehicles()->create([
                        'reg_no' => $vehicle['reg_no'],
                    ]);
                }
            }

            return redirect()->route('bookings.index')->with('success', 'Booking Created');

        } catch (Exception $e) {

            return redirect()->back()->with('danger', 'Something went wrong');
        }


    }

    public function storeRetired(Request $request)
    {
        //dd($request);
        $this->validate($request,[
            'svc_no'  => 'required|string',
            'army_id' => 'required',
            'bungalow_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'payment' => 'required',
        ], [
            'svc_no.required' => 'The service no is required.',
            'svc_no.string' => 'The service no must be a string.',

            'army_id.required' => 'The army id is required.',

            'bungalow_id.required' => 'The bungalow id is required.',
            'bungalow_id.string' => 'The bungalow id must be a string.',

            'check_in.required' => 'The check in id is required.',
            'check_in.date' => 'The check in id must be a date.',

            'check_out.required' => 'The check out id is required.',
            'check_out.date' => 'The check out id must be a date.',
            'check_out.after' => 'The check out date must be a after check in date.',

        ]);

        $checkIn = $request->check_in;
        $checkOut = $request->check_out;


        $results = Booking::where(function ($query) use ($checkIn, $checkOut) {
                    $query->where('check_in', '<=', $checkOut)
                        ->where('check_out', '>=', $checkIn);
                    })
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_in', '>=', $checkIn)
                            ->where('check_in', '<=', $checkOut);
                    })
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_out', '>=', $checkIn)
                            ->where('check_out', '<=', $checkOut);
                    })
                    ->get();

        if (!$results->isEmpty())
        {
            return redirect()->back()->with('danger', 'Already booked');
        }

        try {

            $booking = Booking::create([
                'regiment' => $request->regiment,
                'unit'  => $request->unit,
                'svc_no'  => $request->svc_no,
                'name' => $request->name,
                'nic'  => $request->nic,
                'contact_no' => $request->contact_no,
                'rank' => $request->rank_id,
                'army_id' => $request->army_id,
                'bungalow_id' => $request->bungalow_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'type' => $request->type,
                'save' => 0,
                'level' => 3,
                'paid_amount' => $request->payment,
                'approve' => $request->approve,
            ]);

            $guestData = $request->input('guests');

            if($guestData)
            {
                foreach ($guestData as $guest) {
                    $booking->bookingGuests()->create([
                        'name' => $guest['name'],
                        'nic' => $guest['nic'],
                    ]);
                }
            }

            $vehicleData = $request->input('vehicles');

            if($vehicleData)
            {
                foreach ($vehicleData as $vehicle) {
                    $booking->bookingvehicles()->create([
                        'reg_no' => $vehicle['reg_no'],
                    ]);
                }
            }

            $paymentDirectory = public_path('/upload/payment/'.$booking->id.'/');

            if (!File::isDirectory($paymentDirectory)) {
                File::makeDirectory($paymentDirectory, 0777, true, true);
            }

            $extpayment = $request->file('filpath')->extension();
            $filepayment = $booking->id.'.'.$extpayment;

            $request->file('filpath')->move($paymentDirectory, $filepayment);

            $booking->update([
                'filpath' => '/upload/payment/'.$booking->id.'/'.$filepayment,
                'level' => 3,
            ]);

            return redirect()->route('bookings.create_retired')->with('success', 'Booking Created');

        } catch (Exception $e) {

            return redirect()->back()->with('danger', 'Something went wrong');
        }

    }

    public function storeRetiredAdmin(Request $request)
    {
        //dd($request);
        $this->validate($request,[
            'svc_no'  => 'required|string',
            'army_id' => 'required',
            'bungalow_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'payment' => 'required',
        ], [
            'svc_no.required' => 'The service no is required.',
            'svc_no.string' => 'The service no must be a string.',

            'army_id.required' => 'The army id is required.',

            'bungalow_id.required' => 'The bungalow id is required.',
            'bungalow_id.string' => 'The bungalow id must be a string.',

            'check_in.required' => 'The check in id is required.',
            'check_in.date' => 'The check in id must be a date.',

            'check_out.required' => 'The check out id is required.',
            'check_out.date' => 'The check out id must be a date.',
            'check_out.after' => 'The check out date must be a after check in date.',

        ]);

        $checkIn = $request->check_in;
        $checkOut = $request->check_out;


        $results = Booking::where(function ($query) use ($checkIn, $checkOut) {
                    $query->where('check_in', '<=', $checkOut)
                        ->where('check_out', '>=', $checkIn);
                    })
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_in', '>=', $checkIn)
                            ->where('check_in', '<=', $checkOut);
                    })
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('check_out', '>=', $checkIn)
                            ->where('check_out', '<=', $checkOut);
                    })
                    ->get();

        if (!$results->isEmpty())
        {
            return redirect()->back()->with('danger', 'Already booked');
        }

        try {

            $booking = Booking::create([
                'regiment' => $request->regiment,
                'unit'  => $request->unit,
                'svc_no'  => $request->svc_no,
                'name' => $request->name,
                'nic'  => $request->nic,
                'contact_no' => $request->contact_no,
                'rank' => $request->rank_id,
                'army_id' => $request->army_id,
                'bungalow_id' => $request->bungalow_id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'type' => $request->type,
                'save' => 0,
                'level' => 3,
                'paid_amount' => $request->payment,
                'approve' => $request->approve,
            ]);

            $guestData = $request->input('guests');

            if($guestData)
            {
                foreach ($guestData as $guest) {
                    $booking->bookingGuests()->create([
                        'name' => $guest['name'],
                        'nic' => $guest['nic'],
                    ]);
                }
            }

            $vehicleData = $request->input('vehicles');

            if($vehicleData)
            {
                foreach ($vehicleData as $vehicle) {
                    $booking->bookingvehicles()->create([
                        'reg_no' => $vehicle['reg_no'],
                    ]);
                }
            }

            $paymentDirectory = public_path('/upload/payment/'.$booking->id.'/');

            if (!File::isDirectory($paymentDirectory)) {
                File::makeDirectory($paymentDirectory, 0777, true, true);
            }

            $extpayment = $request->file('filpath')->extension();
            $filepayment = $booking->id.'.'.$extpayment;

            $request->file('filpath')->move($paymentDirectory, $filepayment);

            $booking->update([
                'filpath' => '/upload/payment/'.$booking->id.'/'.$filepayment,
                'level' => 3,
            ]);

            return redirect()->route('bookings.create_retired_admin')->with('success', 'Booking Created');

        } catch (Exception $e) {

            return redirect()->back()->with('danger', 'Something went wrong');
        }

    }

    public function checkBookingAvailability(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        // Check if there is a booking overlapping with the specified date range
        $bookingExists = Booking::where(function ($query) use ($checkIn, $checkOut) {
            $query->whereBetween('check_in', [$checkIn, $checkOut])
                ->orWhereBetween('check_out', [$checkIn, $checkOut])
                ->orWhere(function ($orQuery) use ($checkIn, $checkOut) {
                    $orQuery->where('check_in', '<=', $checkIn)
                        ->where('check_out', '>=', $checkOut);
                });
        })->exists();

        if ($bookingExists) {
            return response()->json(['message' => 'Booking not available for the specified dates.'], 200);
        }

        return response()->json(['message' => 'Booking available for the specified dates.'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function upload_payment_view($id)
    {
        $booking = Booking::find($id);

        $banks = Bank::where('status',1)->get();

        return view('bookings.upload_payment',compact('booking','banks'));
    }

    public function upload_payment(Request $request, Booking $booking)
    {
        //dd($booking->id);
        $paymentDirectory = public_path('/upload/payment/'.$booking->id.'/');

        if (!File::isDirectory($paymentDirectory)) {
            File::makeDirectory($paymentDirectory, 0777, true, true);
        }

        $extpayment = $request->file('filpath')->extension();
        $filepayment = $booking->id.'.'.$extpayment;

        $request->file('filpath')->move($paymentDirectory, $filepayment);

        $booking->update([
            'filpath' => '/upload/payment/'.$booking->id.'/'.$filepayment,
            'bank_id' => $request->bank_id,
            'acc_no' => $request->acc_no,
            'level' => 3,
        ]);

        require_once('ESMSWS.php'); // REQUIRED

        $username = 'esmsusr_XyG2K5QR';
        $password = 'W7DwSiQW';

        $session = createSession('', $username, $password, '');
        sendMessages($session, 'DRE&Q-AHQ', "Dear Sir/Madam, \r\n \r\nThank you for choosing bungalows from the Dte of RE & Q. Your reservation has been confirmed on ". date('Y-m-d', strtotime($booking->updated_at)) .". If you have any questions, let us know at 0112075315." , $booking->contact_no, 0);
        closeSession($session);

        return redirect()->route('bookings.bungalow_bookings',$booking->bungalow_id)->with('success', 'Booking Created');
    }

    public function cancelBookingView($id)
    {
        $cancelremakrs = CancelRemark::where('status',1)->whereNotIn('id',[1])->get();
        $booking = Booking::findOrFail($id);

        return view('bookings.cancel_booking',compact('cancelremakrs','booking'));

    }

    public function cancelBooking(Request $request, Booking $booking)
    {
        $booking = Booking::findOrFail($booking->id);

        $currentDate = Carbon::now();

        try {
            if ($booking) {
                $booking->update([
                    'cancelremark_id' => $request->cancelremark_id,
                    'cancel' => 2,
                    'cancel_time' => $currentDate,
                    'cancel_user_id' => Auth::user()->id,
                ]);

                require_once('ESMSWS.php'); // REQUIRED

                $username = 'esmsusr_XyG2K5QR';
                $password = 'W7DwSiQW';

                $session = createSession('', $username, $password, '');
                sendMessages($session, 'DRE&Q-AHQ', "We regretfully info you that your reservation has been cancelled due to an official requirement. Your amount will be refunded. Pl contact 0112075315 for more info." , $booking->contact_no, 0);
                closeSession($session);
            }

            return redirect()->route('bookings.bungalow_bookings',$booking->bungalow_id)->with('success', 'Booking Canceled');

        } catch (Exception $e) {

            return redirect()->back()->with('danger', 'Something went wrong');
        }

    }

    public function refundBookingView($id)
    {
        $booking = Booking::findOrFail($id);

        $banks = Bank::where('status',1)->get();

        return view('bookings.refund_booking',compact('booking','banks'));
    }

    public function refundBooking(Request $request, Booking $booking)
    {
        $booking = Booking::findOrFail($booking->id);

        $currentDate = Carbon::now();

        $refundDirectory = public_path('/upload/refund/'.$booking->id.'/');

        if (!File::isDirectory($refundDirectory)) {
            File::makeDirectory($refundDirectory, 0777, true, true);
        }

        $extrefund = $request->file('filepath')->extension();
        $filerefund = $booking->id.'.'.$extrefund;

        $request->file('filepath')->move($refundDirectory, $filerefund);

        try {
            if ($booking) {
                if ($booking->type == 0) {
                    $booking->update([
                        'refund' => 1,
                        'refund_time' => $currentDate,
                        'refund_user_id' => Auth::user()->id,
                    ]);
                }elseif($booking->type == 1){
                    $booking->update([
                        'refund' => 1,
                        'refund_time' => $currentDate,
                        'refund_user_id' => Auth::user()->id,
                        'refund_recieve' => 1,
                        'refund_recieve_time' => $currentDate,
                    ]);
                }

                $booking->refund()->create([
                    'bank_id' => $request->bank_id,
                    'branch' => $request->branch,
                    'acc_no' => $request->acc_no,
                    'acc_owner' => $request->acc_owner,
                    'deposit_date' => $request->deposit_date,
                    'cheque_no' => $request->cheque_no,
                    'filepath' => '/upload/refund/'.$booking->id.'/'.$filerefund,
                ]);
            }

            return redirect()->route('bookings.bungalow_bookings',$booking->bungalow_id)->with('success', 'Booking Refunded');

        } catch (Exception $e) {

            return redirect()->back()->with('danger', 'Something went wrong');
        }

    }

    public function approveBooking(Booking $booking)
    {
        $currentDate = Carbon::now();

        try {
            if ($booking) {
                $booking->update([
                    'approve' => 1,
                ]);

                $booking->approve()->create([
                    'user_id' => Auth::user()->id,
                    'approve_date' => $currentDate,
                ]);

                require_once('ESMSWS.php'); // REQUIRED

                $username = 'esmsusr_XyG2K5QR';
                $password = 'W7DwSiQW';

                $session = createSession('', $username, $password, '');
                sendMessages($session, 'DRE&Q-AHQ', "Dear Sir/Madam, \r\n \r\nThank you for choosing bungalows from the Dte of RE & Q. Your reservation has been confirmed on ". date('Y-m-d', strtotime($currentDate)) .". If you have any questions, let us know at 0112075315." , $booking->contact_no, 0);
                closeSession($session);
            }

            return redirect()->route('bookings.booking_pending')->with('success', 'Booking Approved');

        } catch (Exception $e) {

            return redirect()->back()->with('danger', 'Something went wrong');
        }
    }
}
