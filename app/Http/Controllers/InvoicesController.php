<?php

namespace App\Http\Controllers;

use App\Mail\Add_Invoices;
use App\Models\invoice_attachments;
use App\Models\invoices;
use App\Models\invoices_details;
use App\Models\sections;
use App\Models\User;
use App\Notifications\add_invoicese;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoice=invoices::all();
        return view('invoices.invoices',compact('invoice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections=sections::all();
        return view('invoices.add_invoices',compact('sections'));
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
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_Date' => 'required',
            'Due_date' => 'required',
            'product' => 'required',
            'Amount_collection' => 'required',
            'Rate_VAT' => 'required',
  ],[
          'invoice_number.required' =>'يرجي ادخال رقم الفاتوره',
           'invoice_number.unique' =>'رقم الفاتوره موجود مسبقا',
            'invoice_Date.required' =>'يرجي ادخال تاريخ الفاتوره',
            'Due_date.required' =>'يرجي ادخال تاريخ الاستحقاق',
            'product.required' =>'يرجي ادخال المنتج ',
            'Amount_collection.required' =>'يرجي ادخال مبلغ التحصيل ',
            'Rate_VAT.required' =>'يرجي ادخال نسبة الضريبه ',
  ]);

     $invoice=   invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
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
            'user' => (Auth::user()->name),
        ]);
        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;


            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic


            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }



        $user=Auth::user()->name;
        Mail::to('iuggaza1999996@gmail.com')->send(new Add_Invoices($invoice_id,$user),compact('invoice_id'));



        $users=User::where('id','!=',auth()->user()->id)->get();
        $user_created=auth()->user()->name;
        Notification::send($users,new add_invoicese($invoice->id,$user_created));
        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id,invoices $invoices)
    {
        $invoices=invoices::where('id',$id)->first();
return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit_details(invoices $invoices)
    {


        $attachments  = invoice_attachments::where('invoice_id',$invoices->id)->get();
       $details  = invoices_Details::where('invoice_id',$invoices->id)->get();
        return view('invoices.details_invoice',compact('invoices','details','attachments'));
    }
    public function edit($id)
    {

        $invoice=invoices::where('id',$id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('sections','invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id=$request->invoice_id;
        $inv=invoices::findOrFail($id);
        $inv->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
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
            'user' => (Auth::user()->name),
        ]);
        session()->flash('edit','تم تعديل الفاتوره بنجاح');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Request $request)
    {
$id=$request->id;

$invoice = invoices::findOrFail($id)->first();
$attachment=invoice_attachments::where('invoice_id',$id)->first();
        if (!empty($attachment->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($attachment->invoice_number);
        }

        $invoice->forceDelete();

        session()->flash('delete_invoice','تم الحذف بنجاح');
        return redirect()->back();

    }


    public function getproducts($id){
        $product=DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($product);
    }
    public function Status_Update($id,Request $request){
$invoice=invoices::findOrFail($id);
if ($request->Status==='مدفوعة'){
    $invoice->update([
        'Value_Status'=>1,
        'Status'=>$request->Status,
        'Payment_Date'=>$request->Payment_Date,
    ]);
    invoices_details::create([
        'invoice_id'=>$request->invoice_id,
        'invoice_number'=>$request->invoice_number,
        'product'=>$request->product,
        'Section'=>$request->invoice_id,
        'Status'=>$request->Status,
        'Value_Status'=>1,
        'Payment_Date'=>$request->Payment_Date,
        'note'=>$request->note,
        'user' => (Auth::user()->name),

    ]);
}
else {
    $invoice->update([
        'Value_Status' => 3,
        'Status' => $request->Status,
        'Payment_Date' => $request->Payment_Date,
    ]);
    invoices_Details::create([
        'invoice_id' => $request->invoice_id,
        'invoice_number' => $request->invoice_number,
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
        return redirect('invoices');

    }
    public function Invoice_Paid(){
        $invoice=invoices::where('Value_Status',1)->get();
        return view('invoices.invoice_paid',compact('invoice'));
    }
    public function Invoice_UnPaid(){
        $invoice=invoices::where('Value_Status',2)->get();
        return view('invoices.invoice_unpaid',compact('invoice'));
    }
    public function Invoice_Partial(){
        $invoice=invoices::where('Value_Status',3)->get();
        return view('invoices.invoice_partial',compact('invoice'));
    }

public function destroy(Request $request)
{
    $invoice = invoices::where('id',$request->invoice_id)->first();
    $invoice->delete();
    session()->flash('Archive_invoice','تمت الارشفه بنجاح');
    return redirect()->back();
}
public function print($id){
        $invoices=invoices::where('id',$id)->first();
    return view('invoices.Print_invoice',compact('invoices'));
}
    public function markAsRead(){
        $user_id=User::find(auth()->user()->id);
        foreach ($user_id->unreadNotifications as $notifications){
            $notifications->markAsRead();
        }
        return redirect()->back();
    }
    public function show_notification($id){
        $invoices=invoices::findorFail($id);
        $getID=DB::table('notifications')->where('data->id',$id)->pluck('id');
        DB::table('notifications')->where('id',$getID)->update(['read_at'=>now()]);

        return  redirect()->back();
    }
}



