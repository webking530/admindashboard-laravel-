<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
  protected $fillable = [
    'id',
    'name',
    'icon',
    'color',
  ];

  public $timestamps = false;
  
  public function stocks()
  {
    return $this->hasMany('App\Models\Stock');
  }

}
