<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
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
        return view('users.changepass');
    } 
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => ['required','min:8', Password::min(8)->mixedCase()->numbers()
            ->symbols()->uncompromised(),'confirmed'],
            //'password_confirmation' => ['required','min:8'],
        ]);

       User::find(auth()->user()->id)->update(['password'=> Hash::make($request->password)]); 

       return redirect()->route('change.index')->with('success','Password change successfully.');
    }
}
