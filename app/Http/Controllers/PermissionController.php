<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionCategory;
use App\DataTables\PermissionDataTable;

class PermissionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:permission-list|permission-edit|permission-delete', ['only' => ['index']]);
         //$this->middleware('permission:permission-create', ['only' => ['create','store']]);
         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permissioncategories = PermissionCategory::where('status',1)->get();

        $permission = Permission::find($id);

        return view('permissions.edit',compact('permission','permissioncategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'permission_category_id' => 'required',
            'visible_name' => 'required',            
        ]);

        $permission->update($request->toArray());
        return redirect()->route('permissions.index')->with('message', 'Permission Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }

    public function inactive($id)
    {
        Permission::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('permissions.index')->with( 'success','Permission De-Activated');
    }

    public function activate($id)
    {
        Permission::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('permissions.index')->with( 'success','Permission Activated');
    }
}
