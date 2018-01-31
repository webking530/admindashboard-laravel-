<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = [
    'id',
    'category_id',
    'name',
    'buy_price',
    'sell_price',
  ];

  public function category()
  {
    return $this->belongsTo('App\Models\Category');
  }

  public function stocks()
  {
      return $this->hasMany('App\Models\Stock');
  }

}
