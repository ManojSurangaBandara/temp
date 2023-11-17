<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\Bungalow;
use App\Models\District;
use App\Models\DSDivision;
use Illuminate\Http\Request;
use App\Models\RegimentDepartment;

class AjaxController extends Controller
{
    public function getRanks(Request $request){
        if($request->ajax()){
            return Rank::select('*')->where('force_id','=',$request->force_id)->get();
        }else{
             return Rank::where('status',1)->get();
        }
    }    

    public function getBungalow(Request $request){
        //dd($request->rank_id);
        //$rank = Rank::select('name')->where('id',$request->rankId)->get();

        $rank = $request->name;

        //dd($rank);

        // $checkIn = $request->check_in;
        // $checkOut = $request->check_out;

        if($request->ajax()){
            $bungalows = Bungalow::select('id','name')
                        ->whereHas('ranks', function ($query) use ($rank) {
                            $query->where('name', $rank);
                        })
                        ->get();

            // $bungalows = Bungalow::select('id', 'name')
            //             ->whereHas('ranks', function ($query) use ($rank) {
            //                 $query->where('name', $rank);
            //             })
            //             ->whereDoesntHave('bookings', function ($query) use ($checkIn, $checkOut) {
            //                 // Replace $checkIn and $checkOut with your actual date range
            //                 $query->where(function ($subQuery) use ($checkIn, $checkOut) {
            //                     // Check for overlapping date ranges
            //                     $subQuery->whereBetween('check_in', [$checkIn, $checkOut])
            //                         ->orWhereBetween('check_out', [$checkIn, $checkOut])
            //                         ->orWhere(function ($orQuery) use ($checkIn, $checkOut) {
            //                             $orQuery->where('check_in', '<=', $checkIn)
            //                                 ->where('check_out', '>=', $checkOut);
            //                         });
            //                 });
            //             })
            //             ->get();

            return $bungalows;
        }
    }

    public function getPayment(Request $request){        

        $type = $request->type;
        $bungalow = $request->bungalow_id;       

        if($request->ajax()){

            switch($type)
            {
                case  0:
                    return Bungalow::select('serving_price')->where('id',$bungalow)->get();
                    break;
                case  1:
                    return Bungalow::select('retired_price')->where('id',$bungalow)->get();
                    break;
                case  2:
                    return Bungalow::select('official_price')->where('id',$bungalow)->get();
                    break;
                default:
                    return 0.00;
            }
            
        }
    }
}
