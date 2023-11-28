<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\DataTables\BankDataTable;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BankDataTable $dataTable)
    {
        return $dataTable->render('banks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBankRequest $request)
    {
        Bank::create($request->all());
        return redirect()->route('banks.index')->with('success', 'Bank Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bank = Bank::find($id);
        return view('banks.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bank = Bank::find($id);

        return view('banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $bank->update($request->toArray());
        return redirect()->route('banks.index')->with('message', 'Bank Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        //
    }

    public function inactive($id)
    {
        Bank::where('id', $id)->update(['status' => '0']);
        return redirect()->route('banks.index')->with('success', 'Bank De-Activated');
    }

    public function activate($id)
    {
        Bank::where('id', $id)->update(['status' => '1']);
        return redirect()->route('banks.index')->with('success', 'Bank Activated');
    }
}
