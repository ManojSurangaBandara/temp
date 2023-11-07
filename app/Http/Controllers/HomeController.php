<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Forces;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $active_users_count = User::where('status',1)
                                ->where('force_id', Auth::user()->force_id)
                                ->where('user_type_id', Auth::user()->user_type_id)
                                ->get()->count();
        
        if(Auth::user()->user_type_id == 1)
        {
            $forces = Forces::where('status',1)->get();

            $counts = Person::select('force_id', 'ranaviru_types_id')
                ->selectRaw('count(*) as count')
                ->groupBy('force_id', 'ranaviru_types_id')
                ->get();

        }else{
            $forces = Forces::where('status',1)
                        ->where('id',Auth::user()->force_id)->get();

            $counts = Person::select('force_id', 'ranaviru_types_id')
                        ->where('force_id',Auth::user()->force_id)
                        ->selectRaw('count(*) as count')
                        ->groupBy('force_id', 'ranaviru_types_id')
                        ->get();
        }
        
        return view('home',compact('active_users_count','forces','counts'));
    }
}
