<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
  protected $fillable = [
    'id',
    'name',
    'visibility'
  ];

  public $timestamps = false;
  
  public function stocks()
  {
    return $this->hasMany('App\Models\Stock');
  }

}
