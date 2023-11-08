<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        $locations = Location::getLocationsFromAPI();

        $regiments = array_filter($locations, function ($location) {
            return $location['type'] === '10';
        });

        $directorates = array_filter($locations, function ($location) {
            return $location['type'] === '4';
        });

        //dd($directorates);

        return view('users.create',compact('roles','regiments','directorates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'regiment_id' => 'required',
            'location_id' => 'required',
            'rank_id' => 'required',
            'svc_no' => 'required|unique:users,svc_no',
            'mobile_no' => 'required|unique:users,mobile_no',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->toArray();

        $locations = Location::getLocationsFromAPI();

        $regiments = array_filter($locations, function ($location) {
            return $location['type'] === '10';
        });

        $directorates = array_filter($locations, function ($location) {
            return $location['type'] === '4';
        });
        

        return view('users.edit',compact('user','roles','userRole','regiments','directorates'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|unique:users,username'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'regiment_id' => 'required',
            'location_id' => 'required',
            'rank_id' => 'required',
            'svc_no' => 'required|unique:users,svc_no'.$id,
            'mobile_no' => 'required|unique:users,mobile_no'.$id,
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function suspend($user){
        User::where('id',$user)->update(['status'=>'0']);
         return redirect()->route('users.index')->with( 'success',' account suspended');
    }

    public function activate($user){
        User::where('id',$user)->update(['status'=>'1']);
        return redirect()->route('users.index')->with( 'success',' account activated');
    }

    public function resetpass($user){
        User::where('id',$user)->update(['password' => Hash::make('abc@123')]);
        return redirect()->route('users.index')->with( 'success', ' Password Reset as abc@123');
    }
}
