<?php

namespace App\Http\Controllers;

use App\Models\Bills_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillsAttachmentsController extends Controller
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
        $this->validate($request, [

        'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $attachments =  new Bills_attachments();
        $attachments->file_name = $file_name;
        $attachments->bill_number = $request->bill_number;
        $attachments->bill_id = $request->bill_id;
        $attachments->Created_by = Auth::user()->name;
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'. $request->bill_number), $imageName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bills_attachments  $bills_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(Bills_attachments $bills_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bills_attachments  $bills_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(Bills_attachments $bills_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bills_attachments  $bills_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bills_attachments $bills_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bills_attachments  $bills_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bills_attachments $bills_attachments)
    {
        //
    }
}
