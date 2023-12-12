<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Rank;
use App\Models\Forces;
use App\Models\Person;
use App\Models\Bungalow;
use App\Models\District;
use App\Models\Province;
use App\Models\Ethnicity;
use App\Models\DSDivision;
use App\Models\RanaviruType;
use Illuminate\Http\Request;
use App\Models\MaritalStatus;
use App\Models\RegimentDepartment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function booking_report(Request $request)
    {
        //dd('in');
        $bungalows  = Bungalow::where('status','=',1)
                        ->where('directorate_id', Auth::user()->directorate_id)
                        ->get();
        
        if ($request->ajax()) {

            $data = Booking::whereHas('bungalow.directorate', function ($query) {
                        $query->where('id', Auth::user()->directorate_id);
                    })->with('bungalow');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('index', function ($row) {
                        static $i = 1;
                        return $i++;
                    })
                    
                    ->filter(function ($instance) use ($request) {
                        if ($request->get('bungalow_id')) {
                            $instance->where('bungalow_id', $request->get('bungalow_id'));
                        }

                        if ($request->get('type')) {
                            $instance->where('type', $request->get('type'));
                        }

                        // Date range filter
                        // if ($request->get('check_in') && $request->get('check_out')) {
                        //     $instance->whereBetween('check_in', [$request->get('check_in'), $request->get('check_out')])
                        //         ->orWhereBetween('check_out', [$request->get('check_in'), $request->get('check_out')]);
                        // } elseif ($request->get('check_in')) {
                        //     $instance->where('check_in', '>=', $request->get('check_in'));
                        // } elseif ($request->get('check_out')) {
                        //     $instance->where('check_out', '<=', $request->get('check_out'));
                        // }

                        // Add date filtering conditions
                        if ($request->get('check_in')) {
                            $instance->where('check_in', '>=', $request->get('check_in'));
                        }

                        if ($request->get('check_out')) {
                            $instance->where('check_out', '<=', $request->get('check_out'));
                        }
                        
                        if (!empty($request->get('search'))) {
                             $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                 $w->orWhere('svc_no', 'LIKE', "%$search%");
                                // ->orWhere('manufac_year', 'LIKE', "%$search%")
                                // ->orWhere('register_year', 'LIKE', "%$search%")
                                // ->orWhere('reg_no', 'LIKE', "%$search%")
                                // ->orWhere('engine_capacity', 'LIKE', "%$search%")
                                //  ->orWhere('engine_number', 'LIKE', "%$search%")
                                //  ->orWhere('chasis_number', 'LIKE', "%$search%")
                                //  ->orWhere('register_year', 'LIKE', "%$search%");
                            });
                        }
                    })
                    ->make(true);
        }
        
        return view('reports.booking_report',compact('bungalows'));
    }
}
