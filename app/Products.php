<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
  protected $guarded=[];

  public function logs(){
    return $this->hasMany('App\StockLog');
  }

  public function godown(){
  	return $this->belongsTo('App\Godown');
  }
}
