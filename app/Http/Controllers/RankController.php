<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use Illuminate\Http\Request;
use App\DataTables\RankDataTable;
use App\Http\Requests\StoreRankRequest;
use App\Http\Requests\UpdateRankRequest;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RankDataTable $dataTable)
    {
        return $dataTable->render('ranks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        return view('ranks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRankRequest $request)
    {
        Rank::create($request->all());
        return redirect()->route('ranks.index')->with('success', 'Rank Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $rank = Rank::find($id);
        return view('district.show', compact('rank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rank = Rank::find($id);

        return view('ranks.edit', compact('rank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRankRequest $request, Rank $rank)
    {
        $rank->update($request->toArray());
        return redirect()->route('ranks.index')->with('message', 'Rank Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inactive($id)
    {
        Rank::where('id', $id)->update(['status' => '0']);
        return redirect()->route('ranks.index')->with('success', 'Rank De-Activated');
    }

    public function activate($id)
    {
        Rank::where('id', $id)->update(['status' => '1']);
        return redirect()->route('ranks.index')->with('success', 'Rank Activated');
    }
}
