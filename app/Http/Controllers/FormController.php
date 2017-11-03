<?php

namespace App\Http\Controllers;

use App\Godown;
use App\Products;
use App\CompanyDetail;
use App\StockLog;
use App\Vendor;
use App\Client;
use Redirect;
use Session;
use Illuminate\Http\Request;

class FormController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(){
      $this->middleware('auth');
  }

  public function postVendor(Request $request){
    $this->validate($request,array(
      'name'=>'required|regex:/^[\pL\s]+$/u',
      'company_name'=>'required|regex:/^[\pL\s]+$/u',
      'phone'=>'required|min:10',
      'company_phone'=>'required|min:1',
      'company_mail'=>'required|email',
      'state'=>'required',
      'city'=>'required',
      'address'=>'required'
    ));

    if($request->id!=''){
      Vendor::where('id',$request->id)->update([
        'name'=>$request->name,
        'phone'=>$request->phone,
        'company_name'=>$request->company_name,
        'company_phone'=>$request->company_phone,
        'company_email'=>$request->company_mail,
        'address'=>$request->address,
        'city'=>$request->city,
        'state'=>$request->state,
      ]);
    }else{
      Vendor::create([
        'name'=>$request->name,
        'phone'=>$request->phone,
        'company_name'=>$request->company_name,
        'company_phone'=>$request->company_phone,
        'company_email'=>$request->company_mail,
        'address'=>$request->address,
        'city'=>$request->city,
        'state'=>$request->state,
      ]);
    }

    return redirect::to('/vendors');
  }

  public function postProduct(Request $request){
    $this->validate($request,array(
        'price'=>'required|numeric',
        'selling_price'=>'required|numeric',
        'qty_avail'=>'numeric',
        'godown'=>'required|numeric'
    ));
    if($request->id!=''){
      Products::where('id',$request->id)
      ->increment('qty_avail',$request->qty_avail,
      [
        'name'=>$request->name,
        'price'=>$request->price,
        'selling_price'=>$request->selling_price,
        'godown_id'=>$request->godown,
        'desc'=>$request->description
      ]);
      
      return redirect::to('/inventory');
    }else{
      $count=products::where('name',$request->name)->count();
      if($count>=1){
        Session::flash('error','Product with '.$request->name.'name already exits');
        return redirect()->back();
      }

      Products::create([
        'name'=>$request->name,
        'price'=>$request->price,
        'selling_price'=>$request->selling_price,
        'godown_id'=>$request->godown,
        'desc'=>$request->description
      ]);
      return redirect::to('/inventory');
    }

  }

  public function postGodown(Request $request){
    $this->validate($request,array(
        'name'=>'required|regex:/^[\pL\s]+$/u',
        'person'=>'required|regex:/^[\pL\s]+$/u',
        'address'=>'min:5',
        'person_phone'=>'required|numeric',
    ));


    if($request->id){
      Godown::where('id',$request->id)->update([
        'name'=>$request->name,
        'person'=>$request->person,
        'contact'=>$request->person_phone,
        'address'=>$request->address
      ]);
    }else{
      Godown::create([
        'name'=>$request->name,
        'person'=>$request->person,
        'contact'=>$request->person_phone,
        'address'=>$request->address
      ]);

    }
    return redirect::to('/godown');
  }

  public function postSettings(Request $request){
    $this->validate($request,array(
        'company_name'=>'required|regex:/^[\pL\s]+$/u',
        'company_mail'=>'required|email',
        'gst_no'=>'nullable',
        'address'=>'min:5',
        'company_logo'=>'nullable|image|mimes:jpeg,bmp,png|max:2048',
        'company_phone'=>'required|numeric',
    ));

    $logo = $request->file('company_logo');
    $logo_name="";
    if($logo != null){
      $logo_name=  $logo->store('logos');
    }
    $detail=CompanyDetail::first();
    if($detail){
      CompanyDetail::where('id',$detail->id)->update(['name'=>$request->company_name,'email'=>$request->company_mail,'gst'=>$request->gst_no,'address'=>$request->company_address,'state'=>$request->states,'logo'=>$logo_name,'phone'=>$request->company_phone]);
    }else{
      $term=new CompanyDetail;
      $term->name = $request->company_name;
      $term->email = $request->company_mail;
      $term->gst = $request->gst_no;
      $term->address = $request->company_address;
      $term->state = $request->states;
      $term->phone = $request->company_phone;
      $term->logo=$logo_name;
      $term->save();
    }
    return redirect::to('/');

  }

  public function postStock(Request $request){
    $this->validate($request,array(
      'quantity'=>'required|numeric'
    ));
    StockLog::create([
      'product_id'=>$request->product,
      'vendor_id'=>$request->vendor,
      'godown_id'=>$request->godown,
      'qty'=>$request->quantity,
      'type'=>'added',
      'comment'=>$request->comment
    ]);
    Products::where('id',$request->product)->increment('qty_avail',$request->quantity);
    return redirect::to('/inventory');
  }

  public function saveCustomer(Request $request)
   {
     $this->validate($request,array(
       'fullname'=>'required|min:2|regex:/[A-Za-z. -]/|max:255',
       'contact_no'=>'required|numeric|min:10',
       'alt_contact'=>'nullable|numeric|min:10',
       'email'=>'required|email',
       'street'=>'required',
       'city'=>'required|alpha_dash',
       'state'=>'required',
       'pincode'=>'required|numeric',
     ));
     $client = new Client;
     $client->fullname = $request->fullname;
     $client->contact_no = $request->contact_no;
     $client->alt_contact = $request->alt_contact;
     $client->email = $request->email;
     $client->gst_no = $request->gst_no;
     $client->tax = $request->cust_tax;
     $client->street = $request->street;
     $client->city = $request->city;
     $client->state = $request->state;
     $client->pincode = $request->pincode;
     $client->save();
     Session::flash('success','Client created succssfully');
     return redirect::to('/all_client');
   }

   public function updateClient(Request $request)
   {
     $this->validate($request,array(
       'fullname'=>'required|min:2|regex:/[A-Za-z. -]/|max:255',
       'contact_no'=>'required|numeric|min:10',
       'alt_contact'=>'nullable|numeric|min:10',
       'email'=>'required|email',
       'street'=>'required',
       'city'=>'required|alpha_dash',
       'state'=>'required',
       'pincode'=>'required|numeric',
     ));

     Client::where('id',$request->client_id)->update([
     'fullname' => $request->fullname,
     'contact_no' => $request->contact_no,
     'alt_contact' => $request->alt_contact,
     'email' => $request->email,
     'gst_no' => $request->gst_no,
     'tax' => $request->cust_tax,
     'street'=> $request->street,
     'city' => $request->city,
     'state' => $request->state,
     'pincode' => $request->pincode,
     ]);
     Session::flash('success','Client Updated succssfully');
     return redirect::to('/all_client');
   }

   public function migrateStock(Request $request){
    Products::where('godown_id',$request->delete_godown)->update(['godown_id'=>$request->godown_id]);
    // Godown::where('id',$request->delete_godown)->delete();
    return redirect::to('/godown');
   }
}
