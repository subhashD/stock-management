<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
  protected $guarded=[];

  public function godown(){
    return  $this->belongsTo('App\Godown');
  }
  public function vendor(){
    return  $this->belongsTo('App\Vendor');
  }
  public function product(){
    return  $this->belongsTo('App\Products');
  }
  public function client(){
    return  $this->belongsTo('App\Client');
  }
}
