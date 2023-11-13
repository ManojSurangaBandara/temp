<?php

namespace App\Http\Controllers;

use App\Models\Directorate;
use Illuminate\Http\Request;
use App\DataTables\DirectorateDataTable;
use App\Http\Requests\StoreDirectorateRequest;
use App\Http\Requests\UpdateDirectorateRequest;

class DirectorateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DirectorateDataTable $dataTable)
    {
        return $dataTable->render('directorates.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('directorates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDirectorateRequest $request)
    {
        Directorate::create($request->all());
        return redirect()->route('directorates.index')->with('success', 'Directorate Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $directorate = Directorate::find($id);
        return view('directorates.show', compact('directorate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $directorate = Directorate::find($id);

        return view('directorates.edit', compact('directorate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDirectorateRequest $request, Directorate $directorate)
    {
        $directorate->update($request->toArray());
        return redirect()->route('directorates.index')->with('message', 'Directorate Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Directorate $directorate)
    {
        //
    }

    public function inactive($id)
    {
        Directorate::where('id', $id)->update(['status' => '0']);
        return redirect()->route('directorates.index')->with('success', 'Directorate De-Activated');
    }

    public function activate($id)
    {
        Directorate::where('id', $id)->update(['status' => '1']);
        return redirect()->route('directorates.index')->with('success', 'Directorate Activated');
    }
}
