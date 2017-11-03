<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Godown extends Model
{
  protected $guarded=[];

  public function logs(){
    return $this->hasMany('App\StockLog');
  }

  public function products(){
    return $this->hasMany('App\Products');
  }
  
}
