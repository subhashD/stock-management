<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function invoice(){
  	return $this->hasMany('App\Invoice');
  }

  public function estimate(){
  	return $this->hasMany('App\Estimates');
  }
  public function logs(){
  	return $this->hasMany('App\StockLog');
  }
}
