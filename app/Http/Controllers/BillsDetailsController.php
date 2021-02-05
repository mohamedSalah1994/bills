<?php

namespace App\Http\Controllers;

use App\Http\Requests\sections\StoreRequest;
use App\Models\Bill;
use App\Models\Bills_attachments;
use App\Models\Bills_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class BillsDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bills_details  $bills_details
     * @return \Illuminate\Http\Response
     */
    public function show(Bills_details $bills_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bills_details  $bills_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bills = Bill::where('id',$id)->first();
        $details  = Bills_details::where('id_bill',$id)->get();
        $attachments  = Bills_attachments::where('bill_id',$id)->get();

        return view('bills.details',compact('bills','details','attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bills_details  $bills_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bills_details $bills_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bills_details  $bills_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $bills = Bills_attachments::findOrFail($request->id_file);
        $bills->delete();
        Storage::disk('public_uploads')->delete($request->bill_number.'/'.$request->file_name);
        session()->flash('delete','تم حذف الفاتوره بنجاح');
        return back();
    }

    public function open_file($bill_number,$file_name)

    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($bill_number.'/'.$file_name);
        return response()->file($files);
    }

    public function get_file($bill_number , $file_name){
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($bill_number .'/'. $file_name);
        return response()->download($files);

}
}
// mohamed
