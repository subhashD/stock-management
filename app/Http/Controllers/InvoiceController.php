<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Client;
use App\State;
use App\CompanyDetail;
use App\Products;
use App\StockLog;
use App\Vendor;
use Session;
use Redirect;
use PDF;

class InvoiceController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(){
      $this->middleware('auth');
  }

  public function getPendingInvoice(){
    $invoices=Invoice::where('status','pending')->orderBy('created_at','desc')->paginate(10);
    return view('admin.pendingInvoice')->with('invoices',$invoices);
  }

  public function getPaidInvoice(){
    $invoices=Invoice::where('status','paid')->orderBy('created_at','desc')->get();
    return view('admin.paidInvoice')->with('invoices',$invoices);
  }

  public function getGSTInvoice(){
    $clients = Client::where('tax','yes')->get();
    return view('admin.gstInvoice',compact('clients'));
  }

  public function getNonGstInvoice(){
    $clients = Client::where('tax','!=','yes')->get();
    return view('admin.nonGstInvoice',compact('clients'));
  }

  public function getNewInvoice(Request $request){
    if($request->client_id=='new_customer'){
      return redirect::to('/new_client');
    }

    $client = Client::find($request->client_id);
    $states = State::all();
    $tax = $client->tax;
    $invoice_no = "";
    if($tax == 'yes')
    {
      $invoice_tax=Invoice::orderBy('tax_invoice','desc')->first();
      if($invoice_tax == null)
      {
        $invoice_no="INVT-1";
      }
      else
      {
        $tax_no = (int)substr($invoice_tax->tax_invoice,-1,strlen($invoice_tax->tax_invoice));
        $invoice_no="INVT-".($tax_no+1);
      }
    }
    else
    {
      $invoice_notax=Invoice::orderBy('notax_invoice','desc')->first();

      if($invoice_notax==null)
      {
        $invoice_no="INV-1";
      }
      else
      {
        $notax = (int)substr($invoice_notax->notax_invoice,-1,strlen($invoice_notax->notax_invoice));
        $invoice_no="INV-".($notax+1);
      }
    }
    $items = Products::orderBy('qty_avail','desc')->get();
    return view('admin.newInvoice',compact('client','states','invoice_no','tax','items'));
  }

  public function saveInvoice(Request $request)
  {
      $est =null;
      $client = Client::find($request->client_id);
      $item_stock = implode(',', $request->item_name);

      if($request->invoice_id!="")
      {
        if($client->tax == 'yes')
        {
          Invoice::where('id',$request->invoice_id)->update(['tax_invoice'=>$request->inv_no]);
        }
        else
        {
          Invoice::where('id',$request->invoice_id)->update(['notax_invoice'=>$request->inv_no]);
        }
        $est = Invoice::where('id',$request->invoice_id)->update([
        'invoice_date'=>date('Y-m-d',strtotime($request->estimate_date)),
        'due_date'=>date('Y-m-d',strtotime($request->due_date)),
        'items'=>implode(',',$request->item_name),
        'description'=>implode(',',$request->descriptions),
        'qtys'=>implode(',',$request->item_qty),
        'price'=>implode(',',$request->item_rate),
        'tax'=>implode(',',$request->item_tax),
        'gst' => $request->gst,
        'discount'=>$request->discount,
        'adjustment'=>implode(',', $request->adjustment),
        'total'=>$request->total_amount,
        'state'=>$request->states,
        'terms_condition' => $request->terms,
        'product_id'=>implode(',', $request->product_id)
        ]);

      }
      else
      {
        $invoice = new Invoice;
        if($client->tax == 'yes')
        {
          $invoice->tax_invoice=$request->inv_no;
        }
        else
        {
          $invoice->notax_invoice=$request->inv_no;
        }
        $invoice->client_id=$request->client_id;
        $invoice->product_id=implode(',', $request->product_id);
        $invoice->invoice_date=date('Y-m-d',strtotime($request->estimate_date));
        $invoice->due_date=date('Y-m-d',strtotime($request->due_date));
        $invoice->items=implode(',',$request->item_name);
        if($request->descriptions){
        $invoice->description =implode(',',$request->descriptions);}
        $invoice->qtys=implode(',',$request->item_qty);
        $invoice->price=implode(',',$request->item_rate);
        $invoice->tax=implode(',',$request->item_tax);
        $invoice->gst = $request->gst;
        $invoice->discount=$request->discount;
        $invoice->adjustment=implode(',', $request->adjustment);
        $invoice->total=$request->total_amount;
        $invoice->state=$request->states;
        $invoice->terms_condition = $request->terms;
        $invoice->save();
        $est = $invoice;
      }
      
      if($request->Preview=='Preview')
      {
        $pdf = $this->invoicePdf($est->id,true);
        Invoice::where('id',$est->id)->delete();
        return $pdf->stream();
      }

      for($i=0;$i<count($request->product_id);$i++){
        if($request->product_id[$i]!=0){
         $products = Products::find($request->product_id[$i]);
          if($products->qty_avail >= $request->item_qty[$i]){
            $product=Products::where('id',$request->product_id[$i])->decrement('qty_avail',intVal($request->item_qty[$i]));
            StockLog::create([
            'product_id'=>$products->id,
            'client_id'=>$client->id,
            'godown_id'=>$products->godown_id,
            'qty'=>$request->item_qty[$i],
            'type'=>'removed'
          ]);
          }
          else
          {
            Invoice::where('id',$est->id)->delete();
            Session::flash('error','You have Entered Quantity more Than Available');
            return redirect()->to('/home');
          }
        }
      }

      Session::flash('success','Invoice Processed successfully');
      if($client->tax =='yes')
      {
        return redirect()->to('/gst_payments');
      }
      else
      {
        return redirect()->to('/non_gst_payments');
      }
     
  }


  public function getClientInvoice($id)
  {
      $invoices=Invoice::where('client_id',$id)->paginate(10);
      $client=Client::find($id);
      $request=array('client_name'=>'','client_phone'=>'','status_search'=>'');
      if($invoices->count() > 0){
        return view('admin.payments',compact('invoices','client','request'));
      }
      else{

        Session::flash('error','No Invoice created for Selected Customer');
        return back();
      }
  }

  public function payInvoice(Request $request)
  {
    $invoice = Invoice::where('id',$request->id)->update(['status'=>'paid']);
    if($invoice)
      return '0';
  }

  public function deleteInvoice(Request $request)
  {
    $delete =Invoice::where('id',$request->id)->delete();
    if($delete)
      return '0';
  }

  public function editInvoice($id)
  {
    $invoice = Invoice::find($id);
    $client = Client::find($invoice->client_id);
    $tax = $client->tax;
    $states = State::all();
    $item_name = explode(',', $invoice->items);
    $qtys = explode(',', $invoice->qtys);
    $price = explode(',', $invoice->price);
    $item_tax = explode(',', $invoice->tax);
    $description = explode(',', $invoice->description);
    $adjustment = explode(',', $invoice->adjustment);
    $items = Products::orderBy('qty_avail','desc')->get();
    return view('admin.newInvoice',compact('client','states','tax','items','invoice','item_name','qtys','price','item_tax','description','adjustment'));
  }

  public function invoicePdf($id,$inv=null)
  {
    $invoice=Invoice::find($id);
    $client = Client::find($invoice->client_id);
    $company=CompanyDetail::first();
    $item_name=explode(",",$invoice->items);
    $qtys = explode(",",$invoice->qtys);
    $price = explode(",",$invoice->price);
    $item_tax = explode(",",$invoice->tax);
    $adjustment = explode(",",$invoice->adjustment);
    $description = explode(",",$invoice->description);
    $pdf_name = ('Invoice-'.mt_rand(0,99999).'.pdf');
    $pdf = PDF::loadView('pdf.invoicePdf', compact('invoice','company','client','item_name','qtys','price','item_tax','adjustment','description'));
    if($inv==null)
    {
      return $pdf->stream();
    }
    return $pdf;
  }

  public function filterPending(Request $request)
  {
    if($request->start_date!="" || $request->end_date!="")
    {
      $start = date('Y-m-d',strtotime($request->start_date));
      $end = date('Y-m-d',strtotime($request->end_date));
      $invoices=Invoice::where('status','pending')->whereBetween('due_date',[$start,$end])->get();
      return view('admin.pendingInvoice',compact('invoices'));
    }
    elseif($request->status_search!='')
    {
      if($request->status_search=='expired'){
          $invoices=Invoice::where('status','pending')->whereDate('due_date','<',date('Y-m-d'))->get();
          return view('admin.pendingInvoice',compact('invoices'));
      }
      elseif($request->status_search=='running')
      {
          $invoices=Invoice::where('status','pending')->whereDate('due_date','>=',date('Y-m-d'))->get();
          return view('admin.pendingInvoice',compact('invoices'));
      }
    }
    else
    {
      Session::flash('error','Select Date.');
      return redirect()->to('/pending_inv');
    }
  }

  public function filterPaid(Request $request)
  {
    if ($request->start_date!="" || $request->end_date!="")
    {
      $start = date('Y-m-d',strtotime($request->start_date));
      $end = date('Y-m-d',strtotime($request->end_date));
      $invoices=Invoice::where('status','paid')->whereBetween('due_date',[$start,$end])->get();
      return view('admin.paidInvoice',compact('invoices'));
    }
    elseif($request->status_search!='')
    {
      if($request->status_search=='expired'){
          $invoices=Invoice::where('status','paid')->whereDate('due_date','<',date('Y-m-d'))->get();
          return view('admin.paidInvoice',compact('invoices'));
      }
      elseif($request->status_search=='running')
      {
          $invoices=Invoice::where('status','paid')->  whereDate('due_date','>=',date('Y-m-d'))->get();
          return view('admin.paidInvoice',compact('invoices'));
      }
    }
    else
    {
      Session::flash('error','Select Search Field');
      return redirect()->to('/paid_inv');
    }
  }
}
