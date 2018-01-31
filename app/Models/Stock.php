<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
  protected $fillable = [
    'id',
    'quantity',
    'comment',
    'type_id',
    'category_id',
    'product_id',
    'size_id',
    'addable',
  ];

  protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
  ];
  public function category()
  {
    return $this->belongsTo('App\Models\Category');
  }
  
  public function product()
  {
    return $this->belongsTo('App\Models\Product');
  }
  
  public function type()
  {
    return $this->belongsTo('App\Models\Type');
  }
  
  public function size()
  {
    return $this->belongsTo('App\Models\Size');
  }
}
