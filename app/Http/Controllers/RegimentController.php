<?php

namespace App\Http\Controllers;

use App\Models\Regiment;
use Illuminate\Http\Request;
use App\DataTables\RegimentDataTable;
use App\Http\Requests\StoreRegimentRequest;
use App\Http\Requests\UpdateRegimentRequest;

class RegimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RegimentDataTable $dataTable)
    {
        return $dataTable->render('regiments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('regiments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegimentRequest $request)
    {
        Regiment::create($request->all());
        return redirect()->route('regiments.index')->with('success', 'Regiment Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $regiment = Regiment::find($id);
        return view('regiments.show', compact('regiment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $regiment = Regiment::find($id);

        return view('regiments.edit', compact('regiment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegimentRequest $request, Regiment $regiment)
    {
        $regiment->update($request->toArray());
        return redirect()->route('regiments.index')->with('message', 'Regiment Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Regiment $regiment)
    {
        //
    }

    public function inactive($id)
    {
        Regiment::where('id', $id)->update(['status' => '0']);
        return redirect()->route('regiments.index')->with('success', 'Regiment De-Activated');
    }

    public function activate($id)
    {
        Regiment::where('id', $id)->update(['status' => '1']);
        return redirect()->route('regiments.index')->with('success', 'Regiment Activated');
    }
}
