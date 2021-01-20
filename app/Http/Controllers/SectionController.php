<?php

namespace App\Http\Controllers;

use App\Http\Requests\sections\Update;
use App\Http\Requests\sections\StoreRequest;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        return view('sections.sections' , compact('sections'));
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
     * StoreRequest a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name),
        ]))

            session()->flash('Add' , 'تم اضافة المنتج بنجاح');
            return redirect('/sections');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
//    public function show(Store $section)
//    {
//        //
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update( StoreRequest $request)
    {
        $id = $request->id;
        $sections = Section::find($id);
        $sections->update($request->all());

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Section::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
