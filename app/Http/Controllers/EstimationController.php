<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\State;
use App\CompanyDetail;
use App\Estimates;
use App\Invoice;
use App\Products;
use App\Mail\SendEstimate;
use Session;
use Redirect;
use PDF;
use Mail;

class EstimationController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(){
      $this->middleware('auth');
  }

  public function new_estimation(Request $request){
    if($request->client_id=='new_customer'){
      return redirect::to('/new_client');
    }
    $client = Client::find($request->client_id);
    $states = State::all();
    $estimate_no = "";
    $est_no = Estimates::orderBy('estimate_no','desc')->first();
    if($est_no==null)
    {
      $estimate_no="EST-1";
    }
    else
    {
      $no =(int)substr($est_no->estimate_no,-1,strlen($est_no->estimate_no));
      $estimate_no="EST-".($no+1);
    }
    $items = Products::orderBy('qty_avail','desc')->get();
    return view('admin.new_est',compact('client','states','estimate_no','items'));
  }

  public function getAllEstimation(){
    // $estimates = Estimates::all();
    $est_clients= Client::whereHas('estimate')->get();
    // dd($est_clients);
    $clients = Client::all();
    return view('admin.all_est',compact('est_clients','clients'));
  }

  public function getClientEstimate($id){
      $estimates=Estimates::where('client_id',$id)->paginate(10);
      $client=Client::find($id);
      $request=array('client_name'=>'','client_phone'=>'','status_search'=>'');
      if($estimates->count() > 0){
        return view('admin.clientEstimate',compact('estimates','client','request'));
      }
      else{
        Session::flash('error','No Estimate created for Selected Client');
        return back();
      }
  }

  public function saveEstimate(Request $request){
    $est = null;
    if($request->estimate_id != "")
    {
      $est = Estimates::where('id',$request->estimate_id)->update([
      'estimate_date'=>date('Y-m-d',strtotime($request->estimate_date)),
      'expiry_date'=>date('Y-m-d',strtotime($request->expiry_date)),
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
      'terms_condition' => $request->terms]);
    }
    else
    {
      $est = Estimates::create([
        'client_id'=>$request->client_id,
        'estimate_no'=>$request->est_no,
        'estimate_date'=>date('Y-m-d',strtotime($request->estimate_date)),
        'expiry_date'=>date('Y-m-d',strtotime($request->expiry_date)),
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
        'terms_condition' => $request->terms]);
    }

    if($request->Preview=='Preview')
    {
      $pdf=$this->estimatePdf($est->id,true);
      Estimates::where('id',$est->id)->delete();
      return $pdf->stream();
    }
    else{
    Session::flash('success','Estimate Processed successfully');
    return redirect()->to('/all_estimation');
    }
  }

  public function editEstimate($id){
    $estimate = Estimates::find($id);
    $client = Client::find($estimate->client_id);
    $states = State::all();
    $item_name = explode(',', $estimate->items);
    $qtys = explode(',', $estimate->qtys);
    $price = explode(',', $estimate->price);
    $item_tax = explode(',', $estimate->tax);
    $description = explode(',', $estimate->description);
    $adjustment = explode(',', $estimate->adjustment);
    $items = Products::orderBy('qty_avail','desc')->get();
    return view('admin.new_est',compact('estimate','client','states','items','item_name','qtys','price','item_tax','description','adjustment'));
  }

  public function deleteEstimate(Request $request)
  {
    $delete = Estimates::where('id',$request->id)->delete();
    if($delete)
      return '0';
  }

  public function convertInvoice($id)
  {
    $estimate = Estimates::find($id);
    $client = Client::find($estimate->client_id);
    $tax = $client->tax;
    $no =(int)substr($estimate->estimate_no,-1,strlen($estimate->estimate_no));
    $invoice_no = "";
    if($client->tax == 'yes')
    {
      $invoice_tax=Invoice::orderBy('tax_invoice','desc')->first();
      if($invoice_tax == null)
      {
        $invoice_no="INVT-1";
      }
      else
      {
        $inv_no = (int)substr($invoice_tax->tax_invoice,-1,strlen($invoice_tax->tax_invoice));
        $invoice_no = ($inv_no!=$no)?"INVT-".($no):"INVT-".($inv_no+1);
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
        $inv_no = (int)substr($invoice_notax->notax_invoice,-1,strlen($invoice_notax->notax_invoice));
        $invoice_no = ($inv_no!=$no)?"INV-".($no):"INV-".($inv_no+1);
      }
    }
    $states = State::all();
    $item_name = explode(',', $estimate->items);
    $qtys = explode(',', $estimate->qtys);
    $price = explode(',', $estimate->price);
    $item_tax = explode(',', $estimate->tax);
    $description = explode(',', $estimate->description);
    $adjustment = explode(',', $estimate->adjustment);
    $items = Products::orderBy('qty_avail','desc')->get();
    return view('admin.newInvoice',compact('estimate','invoice_no','client','states','tax','items','item_name','qtys','price','item_tax','description','adjustment'));
  }

  public function sendMail(Request $request)
  {
    $client = Client::find($request->client_id);
    $estimate = Estimates::find($request->estimate_id);
    $company=CompanyDetail::first();
    $item_name=explode(",",$estimate->items);
    $qtys = explode(",",$estimate->qtys);
    $price = explode(",",$estimate->price);
    $item_tax = explode(",",$estimate->tax);
    $adjustment = explode(",",$estimate->adjustment);
    $description = explode(",",$estimate->description);
    $pdf_name = ('Estimate-'.mt_rand(0,99999).'.pdf');
    $pdf = PDF::loadView('pdf.estimatePdf', compact('estimate','company','client','item_name','qtys','price','item_tax','adjustment','description'))->save('storage/app/pdfs/'.$pdf_name);

    $mailcontent['title'] = 'Estimate';
    $mailcontent['content'] = "Dear, <br>".$client->fullname."<br>"."This is Estimate from ".config('app.name')."<br>";
    $mailcontent['to'] = $request->input('emailTo');
    $mailcontent['cc']=$request->cc?$request->cc:'fourbrothers053@gmail.com';
    $mailcontent['subject'] = 'New Estimate';
    $mailcontent['estimateFile']=url('/').'/storage/app/pdfs/'.$pdf_name;
    Session::flash('success','Estimate send successfully');
    Mail::to($mailcontent['to'])->send(new SendEstimate($mailcontent));
    Estimates::where('id',$request->estimate_id)->update(['status'=>'sent']);
    // return $pdf->stream();
    return redirect::to('/all_estimation');
  }

  public function estimatePdf($id,$est=null)
  {
    $estimate=Estimates::find($id);
    $client = Client::find($estimate->client_id);
    $company=CompanyDetail::first();
    $item_name=explode(",",$estimate->items);
    $qtys = explode(",",$estimate->qtys);
    $price = explode(",",$estimate->price);
    $item_tax = explode(",",$estimate->tax);
    $adjustment = explode(",",$estimate->adjustment);
    $description = explode(",",$estimate->description);
    $pdf_name = ('Estimate-'.mt_rand(0,99999).'.pdf');
    $pdf = PDF::loadView('pdf.estimatePdf', compact('estimate','company','client','item_name','qtys','price','item_tax','adjustment','description'));
    if($est==null)
    {
      return $pdf->stream();
    }
    return $pdf;
  }

  public function report_est()
  {
    $estimates = Estimates::all();
    return view('admin.report_est',compact('estimates'));
  }

  public function filterEstimate(Request $request)
  {
        if ($request->start_date!="" || $request->end_date!="")
        {
            $start = date('Y-m-d',strtotime($request->start_date));
            $end = date('Y-m-d',strtotime($request->end_date));
            $estimates=Estimates::whereBetween('estimate_date',[$start,$end])->get();
            return view('admin.report_est',compact('estimates'));
        }
        elseif($request->status_search!='')
        {
          $estimates=Estimates::where('status',$request->status_search)->get();
            return view('admin.report_est',compact('estimates'));
        }
        else
        {
            Session::flash('error','Select Date.');
            return redirect()->to('/report_est');
        }
  }

}
