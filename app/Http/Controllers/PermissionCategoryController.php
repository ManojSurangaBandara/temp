<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermissionCategory;
use App\Http\Requests\StorePermissionCategory;
use App\DataTables\PermissionCategoryDataTable;
use App\Http\Requests\StorePermissionCategoryRequest;
use App\Http\Requests\UpdatePermissionCategoryRequest;

class PermissionCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:permission-category-list|permission-category-create|permission-category-edit|permission-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:permission-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:permission-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-category-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PermissionCategoryDataTable $dataTable)
    {
        return $dataTable->render('permission_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionCategoryRequest $request)
    {
        PermissionCategory::create($request->all());
        return redirect()->route('permissioncategories.index')->with('success','Permission Category Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $permissioncategory = PermissionCategory::find($id);

        return view('permission_categories.show',compact('permissioncategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permissioncategory = PermissionCategory::find($id);

        return view('permission_categories.edit',compact('permissioncategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionCategoryRequest $request, PermissionCategory $permissioncategory)
    {
        $permissioncategory->update($request->toArray());
        return redirect()->route('permissioncategories.index')->with('message', 'Permission Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermissionCategory $permissionCategory)
    {
        //
    }

    public function inactive($id)
    {
        PermissionCategory::where('id',$id)->update(['status'=>'0']);
        return redirect()->route('permissioncategories.index')->with( 'success','Permission Category De-Activated');
    }

    public function activate($id)
    {
        PermissionCategory::where('id',$id)->update(['status'=>'1']);
        return redirect()->route('permissioncategories.index')->with( 'success','Permission Category Activated');
    }
}
