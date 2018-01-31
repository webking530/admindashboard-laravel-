<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;

class HomeController extends BaseController
{
  public function index()
  {
    $products = array(); $i=0;
    foreach(Product::all() as $product) {
      $stock = 0;
      $stock += Stock::where('product_id', $product->id)->sum('quantity');
      $sales = Stock::where('product_id', $product->id)->where('addable', '0')->sum('quantity')*(-1);

      if ($stock != 0) {
        $products[] = array(
          'no' => ++$i,
          'product' => $product->name,
          'category' => $product->category->name,
          'stock' => $stock,
          'sales' => $sales
        );
      }
    }

    return view('pages.home.dashboard')->with([
      'products' => $products
    ]);
  }

  public function getChartData() {
    $current=date_create(date("Y-m-d"));
    $last=date_create(date_format($current,"Y-m-d"));
    date_sub($last, date_interval_create_from_date_string("7 days"));

    $res = array();
    array_push($res, array(
      'date' => date_format($current,"Y-m-d"),
      'c_week' => $this->getSales($current),
      'p_week' => $this->getSales($last),
    ));
    for($i=0; $i<6; $i++) {
      date_sub($current, date_interval_create_from_date_string("1 days"));
      date_sub($last, date_interval_create_from_date_string("1 days"));

      array_unshift($res, array(
        'date' => date_format($current,"Y-m-d"),
        'c_week' => $this->getSales($current),
        'p_week' => $this->getSales($last),
      ));
    }

    return response()->json([
      'data' => $res
    ]);
  }

  function getSales($date) {
    $start = date_format($date,"Y-m-d 00:00:00");
    $end = date_format($date,"Y-m-d 23:59:59");

    return Stock::whereBetween('updated_at', [$start, $end])->sum('quantity');
  }
}
