<?php

namespace App\Http\Controllers;

use App\State;
use App\Godown;
use App\Products;
use App\Vendor;
use App\City;
use App\StockLog;
use App\CompanyDetail;
use App\Client;
use App\Invoice;
use Illuminate\Http\Request;

class PageController extends Controller
{

  public function __construct(){
      $this->middleware('auth');
  }

  public function getHome(){
    $detail=CompanyDetail::first();
    if(!$detail){
      $states=State::all();
      return view('admin.setting',compact('states','detail'));
    }
    $detail=[];
    //detail since started
    $detail['clientCount']=Client::count();
    $detail['totalTax']=Invoice::sum('gst');
    $detail['pendingDue']=Invoice::where('status','pending')->sum('total');
    $detail['dueCount']=Invoice::where('status','pending')->count();
    $detail['total']=Invoice::where('status','paid')->sum('total');
    //current month status
    $detail['m_clientCount']=Client::whereYear('created_at','=',date('Y'))->whereMonth('created_at','=',date('m'))->count();
    $detail['m_totalTax']=Invoice::whereYear('created_at','=',date('Y'))->whereMonth('created_at','=',date('m'))->sum('gst');
    $detail['m_pendingDue']=Invoice::whereYear('created_at','=',date('Y'))->whereMonth('created_at','=',date('m'))->where('status','pending')->sum('total');
    $detail['m_dueCount']=Invoice::whereYear('created_at','=',date('Y'))->whereMonth('created_at','=',date('m'))->where('status','pending')->count();
    $detail['m_total']=Invoice::whereYear('created_at','=',date('Y'))->whereMonth('created_at','=',date('m'))->where('status','paid')->sum('total');

    $detail['gstAvailable']=CompanyDetail::first();
    $detail['gstAvailable']=is_null($detail['gstAvailable'])?false:true;

    return view('admin.home',compact('detail'));

  }

  public function getNewClient(){
    $states = State::all();
    $client = "";
    $CompanyDetail = CompanyDetail::first();
    return view('admin.new_client',compact('states','client','CompanyDetail'));
  }

  public function getAllClient(){
      $clients = Client::all();
      return view('admin.all_clients',compact('clients'));
    }

  public function getNewVendor(){
    $vendors=Vendor::orderBy('created_at','desc')->paginate(10);
    $states=City::groupBy('city_state')->pluck('city_state');
    return view('admin.vendors',compact('vendors','states'));
  }

  public function getGodown(){
    $godowns=Godown::orderBy('created_at','desc')->get();
    return view('admin.godown',compact('godowns'));
  }

  public function getInventory(){
    $products=Products::orderBy('created_at','desc')->paginate(10);
    $godowns=Godown::orderBy('created_at','desc')->get();
    $vendors=Vendor::orderBy('created_at','desc')->get();
    return view('admin.inventory',compact('products','godowns','vendors'));
  }

  public function getInventoryLog(){
    $logs=StockLog::orderBy('created_at','desc')->paginate(10);
    return view('admin.InventoryLog',compact('logs'));
  }

  public function getSetting(){
    $states=State::all();
    $detail=CompanyDetail::first();
    return view('admin.companyProfile',compact('states','detail'));
  }

}
