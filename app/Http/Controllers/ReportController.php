<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\Forces;
use App\Models\Person;
use App\Models\District;
use App\Models\Province;
use App\Models\Ethnicity;
use App\Models\DSDivision;
use App\Models\RanaviruType;
use Illuminate\Http\Request;
use App\Models\MaritalStatus;
use App\Models\RegimentDepartment;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function person_profile(Request $request)
    {
        //dd('in');
        $forces = Forces::where('status',1)->get();
        $ranaviruTypes = RanaviruType::where('status',1)->get();
        $regimentDepartments = RegimentDepartment::where('status',1)->get();
        $ranks = Rank::where('status',1)->get();
        $maritalStatus = MaritalStatus::where('status',1)->get();
        $ethnicity = Ethnicity::where('status',1)->get();
        $provinces = Province::where('status',1)->get();
        $districts = District::where('status',1)->get();
        $dsDivisions = DSDivision::where('status',1)->get();
        
        if ($request->ajax()) {
            $data = Person::select('*')->with('force','ranaviru_type','regiment_department','rank',
                                                'marital_status','ethnicity','province','district','dsdivision');

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('index', function ($row) {
                        static $i = 1;
                        return $i++;
                    })
                    
                    ->filter(function ($instance) use ($request) {
                        if ($request->get('force_id')) {
                            $instance->where('force_id', $request->get('force_id'));
                        }

                        if ($request->get('regiment_department_id')) {
                            $instance->where('regiment_department_id', $request->get('regiment_department_id'));
                        }                     

                        if ($request->get('rank_id')) {
                            $instance->where('rank_id', $request->get('rank_id'));
                        }

                        if ($request->get('ranaviru_types_id')) {
                            $instance->where('ranaviru_types_id', $request->get('ranaviru_types_id'));
                        }

                        if ($request->get('marital_status_id')) {
                            $instance->where('marital_status_id', $request->get('marital_status_id'));
                        }

                        if ($request->get('ethnicity_id')) {
                            $instance->where('ethnicity_id', $request->get('ethnicity_id'));
                        }

                        if ($request->get('province_id')) {
                            $instance->where('province_id', $request->get('province_id'));
                        }

                        if ($request->get('district_id')) {
                            $instance->where('district_id', $request->get('district_id'));
                        }

                        if ($request->get('dsdivision_id')) {
                            $instance->where('dsdivision_id', $request->get('dsdivision_id'));
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
        
        return view('reports.person_profile',compact('forces','ranaviruTypes','regimentDepartments','ranks',
                                                    'maritalStatus','ethnicity','provinces','districts','dsDivisions'));
    }
}
