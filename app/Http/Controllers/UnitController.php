<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Regiment;
use Illuminate\Http\Request;
use App\DataTables\UnitDataTable;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UnitDataTable $dataTable)
    {
        return $dataTable->render('units.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        Unit::create($request->all());
        return redirect()->route('units.index')->with('success', 'Unit Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $unit = Unit::find($id);
        return view('units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $unit = Unit::find($id);
        $regiments = Regiment::where('status', 1)->get();

        return view('units.edit', compact('unit','regiments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->update($request->toArray());
        return redirect()->route('units.index')->with('message', 'Unit Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        //
    }

    public function inactive($id)
    {
        Unit::where('id', $id)->update(['status' => '0']);
        return redirect()->route('units.index')->with('success', 'Unit De-Activated');
    }

    public function activate($id)
    {
        Unit::where('id', $id)->update(['status' => '1']);
        return redirect()->route('units.index')->with('success', 'Unit Activated');
    }
}
