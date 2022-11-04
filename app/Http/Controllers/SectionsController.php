<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditeSectionRequest;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $section=sections::all();
      return view('sections.sections',compact('section'));
    }
    public function index2()
    {
        return view('modals');
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
       $input=$request->all();

       $exists=sections::where('section_name','=',$input['section_name'])->exists();
       if ($exists){
           session()->flash('Error', 'خطأ القسم مسجل مسبقا!');
           return redirect('sections');
       }
       else{
           sections::create([
               'section_name'=>$request->section_name,
               'description'=>$request->description,
               'Created_by'=>(Auth::user()->name),
           ]);
           session()->flash('Add','تم اضافة القسم بنجاح');
           return redirect('sections');
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,

        ],[

            'section_name.required' =>'يرجي ادخال اسم القسم',
            'section_name.unique' =>'اسم القسم مسجل مسبقا',


        ]);

        $sections = sections::findorFail($id);
        $sections->update([
          'section_name'=>$request->section_name,
            'description'=>$request->description,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id=$request->id;

sections::findorFail($id)->delete();
        session()->flash('delete','تم الحذف بنجاح');
return redirect()->route('sections.index');
    }
}
