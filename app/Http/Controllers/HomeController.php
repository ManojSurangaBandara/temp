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
                                    ->get()->count();
        
        return view('home',compact('active_users_count'));
    }
}
