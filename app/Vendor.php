<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

  protected $guarded=[];

  public function logs(){
    return $this->hasMany('App\StockLog');
  }
}
