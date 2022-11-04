<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $section=sections::all();
        $product=products::all();
//        dd($product);
      return view('products.products',compact('section','product'));
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
      $this->validate($request,[
          'product_name' => 'required|max:255|unique:products,product_name,',
          'section_id' => 'required',

      ],[

          'product_name.required' =>'يرجي ادخال اسم المنتج',
          'product_name.unique' =>'اسم المنتج مسجل مسبقا',


      ]);

        $product=products::create([
            'product_name'=>$request->product_name,
            'section_id'=>$request->section_id,
            'description'=>$request->description,



        ]);
        session()->flash('Add','تم اضافة المنتج  بنجاح');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'product_name' => 'required|max:255|unique:products,product_name,',
            'section_id' => 'required',

        ],[

            'product_name.required' =>'يرجي ادخال اسم المنتج',
            'product_name.unique' =>'اسم المنتج مسجل مسبقا',
            'section_id.required' =>'يرجي اختيار القسم',

        ]);
       $id=$request->id;
        $Products = Products::findOrFail($id);

        $Products->update([
            'Product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,

        ]);
  session()->flash('edit', 'تم تعديل المنتج بنجاح');
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        $Products = Products::findOrFail($id)->delete();
        session()->flash('delete','تم الحذف بنجاح');
        return back();

    }
}
