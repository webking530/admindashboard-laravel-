<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $fillable = [
    'id',
    'name',
    'color',
  ];
  
  public function products()
  {
      return $this->hasMany('App\Models\Product');
  }

  public function stocks()
  {
      return $this->hasMany('App\Models\Stock');
  }

}
