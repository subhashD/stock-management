<?php

namespace App\Http\Controllers;

use App\Godown;
use App\Products;
use App\City;
use App\Vendor;
use App\Client;
use App\State;
use App\Invoice;
use App\CompanyDetail;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(){
      $this->middleware('auth');
  }

  public function deleteGodown($id){
    $product_count=Products::where('godown_id',$id)->where('qty_avail','>',0)->count();

    if($product_count>0){

      return json_encode(array('data'=>Godown::where('id','!=',$id)->get(),'count'=>Godown::where('id','!=',$id)->count()));

    }else{
      $godown=Godown::where('id',$id)->delete();
      if($godown){
        return json_encode('success');
      }    
    }
    
  }

  public function deleteProduct($id){
    $product=Products::where('id',$id)->delete();
    if($product){
      return json_encode('success');
    }
    return json_encode('error');
  }

  public function getProductDesc($id){
    return json_encode(Products::find($id));
  }

  public function getVendor($id){
    return json_encode(Vendor::find($id));
  }

  public function getCity($state){
    $cities=City::where('city_state',$state)->pluck('city_name');
    $str='';
    foreach ($cities as $city) {
      $str .= "<option value='".$city."'>".$city."</option>";
    }
    return $str;
  }

  public function deleteVendor($id){
    $status=Vendor::where('id',$id)->delete();
    if($status){
      return json_encode('success');
    }
    return json_encode('error');
  }

  public function editClient($id){
    	$client = Client::find($id);
    	$states = State::all();
      $CompanyDetail = CompanyDetail::first();
    	return view('admin.new_client',compact('client','states','CompanyDetail'));
    }

    public function deleteClient($id){
    	$client = Invoice::where('client_id',$id)->where('status','pending')->count();
    	if ($client > 0)
    		return json_encode('pending');
    	else{
        Invoice::where('client_id',$id)->delete();
        Client::where('id',$id)->delete();
        return json_encode('success');
      }

    }
}
