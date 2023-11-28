<?php

namespace App\Http\Controllers;

use App\Models\CancelRemark;
use Illuminate\Http\Request;
use App\DataTables\CancelRemarkDataTable;
use App\Http\Requests\StoreCancelRemarkRequest;
use App\Http\Requests\UpdateCancelRemarkRequest;

class CancelRemarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CancelRemarkDataTable $dataTable)
    {
        return $dataTable->render('cancel_remarks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cancel_remarks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCancelRemarkRequest $request)
    {
        CancelRemark::create($request->all());
        return redirect()->route('cancel_remarks.index')->with('success', 'Cancel Remarks Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cancelRemark = CancelRemark::find($id);
        return view('cancel_remarks.show', compact('cancelRemark'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cancelRemark = CancelRemark::find($id);

        return view('cancel_remarks.edit', compact('cancelRemark'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCancelRemarkRequest $request, CancelRemark $cancelRemark)
    {
        $cancelRemark->update($request->toArray());
        return redirect()->route('cancel_remarks.index')->with('message', 'Cancel Remark Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CancelRemark $cancelRemark)
    {
        //
    }

    public function inactive($id)
    {
        CancelRemark::where('id', $id)->update(['status' => '0']);
        return redirect()->route('cancel_remarks.index')->with('success', 'Cancel Remark De-Activated');
    }

    public function activate($id)
    {
        CancelRemark::where('id', $id)->update(['status' => '1']);
        return redirect()->route('cancel_remarks.index')->with('success', 'Cancel Remark Activated');
    }
}
