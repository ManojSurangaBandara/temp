<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\Bungalow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DataTables\BungalowDataTable;
use App\Http\Requests\StoreBungalowRequest;

class BungalowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BungalowDataTable $dataTable)
    {
        return $dataTable->render('bungalows.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ranks = Rank::where('status', 1)->get(); 
        return view('bungalows.create',compact('ranks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBungalowRequest $request)
    {
        //dd($request);
        $bungalow = Bungalow::create([
            'name' => $request->name,
            'no_ac_room' => $request->no_ac_room,
            'no_none_ac_room'=> $request->no_none_ac_room,
            'no_guest'=> $request->no_guest,
            'serving_price'=> $request->serving_price,
            'retired_price'=> $request->retired_price,
            'death_price'=> $request->death_price,
            'directorate_id'=> Auth::user()->directorate_id,
        ]);

        if($request->ranks){
            $bungalow->ranks()->sync($request->ranks);
        }

        return redirect()->route('bungalows.index')->with('success','Bungalow Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bungalow = Bungalow::find($id);

        return view('bungalows.show',compact('bungalow'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bungalow = Bungalow::find($id);

        $ranks = Rank::where('status', 1)->get();

        $bungalow_rank = $bungalow->ranks->pluck('name','name')->toArray();

        //dd($bungalow_rank);

        return view('bungalows.edit',compact('ranks','bungalow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bungalow $bungalow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bungalow $bungalow)
    {
        //
    }
}
