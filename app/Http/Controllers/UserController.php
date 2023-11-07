<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\User;
use App\Models\Forces;
use App\Models\Usertype;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use App\Models\RegimentDepartment;
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
        $forces = Forces::where('status',1)->get();        

        $roles = Role::pluck('name','name')->all();

        $usertypes = Usertype::where('status',1)->get();

        return view('users.create',compact('roles','forces','usertypes'));
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
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'force_id' => 'required',
            'rank_id' => 'required',
            'svc_no' => 'required|unique:users,svc_no',
            'regiment_department_id' => 'required',
            'user_type_id' => 'required',
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
        $forces = Forces::where('status',1)->get();
        $ranks = Rank::where('status',1)->get();
        $regimentDepartments = RegimentDepartment::where('status',1)->get();
        $usertypes = Usertype::where('status',1)->get();

        $userForce = Auth::user()->force_id;

        return view('users.edit',compact('user','roles','userRole','forces','ranks','regimentDepartments','usertypes','userForce'));
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
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'force_id' => 'required',
            'rank_id' => 'required',
            'svc_no' => 'required|unique:users,svc_no,'.$id,
            'regiment_department_id' => 'required',
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
