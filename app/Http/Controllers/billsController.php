<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bills_attachments;
use App\Models\Bills_details;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class billsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bill::all();
        return view('bills.bills' , compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('bills.add_bills' , compact('sections'));
    }

    /**
     * StoreRequest a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Bill::create([
            'bill_number' => $request->bill_number,
            'bill_Date' => $request->bill_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $bill_id = Bill::latest()->first()->id;
        Bills_details::create([
            'id_Bill' => $bill_id,
            'bill_number' => $request->bill_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);
        if ($request->hasFile('pic')) {

            $bill_id = Bill::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $bill_number = $request->bill_number;

            $attachments = new Bills_attachments();
            $attachments->file_name = $file_name;
            $attachments->bill_number = $bill_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->bill_id = $bill_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $bill_number), $imageName);
        }

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bills = Bill::where('id', $id)->first();
        return view('bills.status_update', compact('bills'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bills = Bill::where('id', $id)->first();
        $sections = Section::all();
        return view('bills.edit_bills', compact('sections', 'bills'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $bills = Bill::findOrFail($request->bill_id);
        $bills->update([
            'bill_number' => $request->bill_number,
            'bill_Date' => $request->bill_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->bill_id;
        $bills = Bill::where('id',$id)->first();
        $details = Bills_attachments::where('bill_id' , $id)->first();
        if(!empty($details->bill_number)){
            Storage::disk('public_uploads')->deleteDirectory($details->bill_number);
        }
        $bills->forceDelete();
        session()->flash('delete_bill');
        return back();

    }
    public function getproducts($id)
    {
       $products = DB::table('products')->where('section_id' , $id)->pluck('product_name' , 'id');
       return json_encode($products);
    }
    public function Status_Update($id, Request $request)
    {
        $bills = Bill::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $bills->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            Bills_details::create([
                'id_Bill' => $request->bill_id,
                'bill_number' => $request->bill_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $bills->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            Bills_details::create([
                'id_Bill' => $request->bill_id,
                'bill_number' => $request->bill_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/bills');

    }
}
