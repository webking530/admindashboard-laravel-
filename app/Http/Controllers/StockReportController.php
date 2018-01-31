<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;

use App\Models\Size;
use App\Models\Stock;
use App\Models\Category;
use App\Models\Product;
use App\Models\Color;

class StockReportController extends Controller
{
	public function index()
	{
    return view('pages.stock.report')->with([
			'sizes' => Size::orderBy('id', 'asc')->get()
		]);
	}

	public function getReports(Request $request) {
		$start = Carbon::create($request->date)->hour(0)->minute(0)->second(0)->toDateTimeString();
		$end = Carbon::create($request->date)->hour(23)->minute(59)->second(59)->toDateTimeString();

		if(isset($request->product)) {
			$products = Product::where('name', 'like', '%'.$request->product.'%');
			// \Log::info('part');
		} else {
			$products = Product::select('*');
			// \Log::info('all');
		}

		if(isset($request->category)) {
			$categories = Category::select('id')->where('name', 'like', '%'.$request->category.'%')->pluck('id');
			$products->whereIn('category_id', $categories);
			// \Log::info('Matched::'.$categories);
			// \Log::info('Products::'.$products->count());
		}

		$sizes = Size::orderBy('id', 'asc')->get();
		$sizeArr = array();
		foreach($sizes as $size) {
			array_push($sizeArr, ['id' => $size->id,'name' => $size->name, 'visibility' => $size->visibility]);
		}

		$inStocks = array();
		$outStocks = array();
		$i=0; $j=0;
		foreach($products->get() as $product) {
			// \Log::info($product->id.'>>>'.$product->name);
			$arr = array();
			array_push($arr, 0);
			array_push($arr, $this->getTextContent($product->category->name));
			array_push($arr, $this->getTextContent($product->name));
			$cnt = 0;
			foreach($sizes as $size) {
				$count = $this->calcStock($product->id, $size->id, $end);
				array_push($arr, $this->getNumberContent($count));
				// \Log::info($size->name.'>>>'.$count);
				$cnt += $count;
			}
			array_push($arr, $this->getNumberContent($cnt));
			if($cnt == 0) {
				$arr[0] = $this->getTextContent(++$i);
				array_push($outStocks, $arr);
			} else {
				$arr[0] = $this->getTextContent(++$j);
				array_push($inStocks, $arr);
			}
		}
		return response()->json([
			'sizes' => $sizeArr,
			'inStocks' => $inStocks,
			'outStocks' => $outStocks
		], 200);
	}

	public function export($type, $end) {
		$fileName = 'reports_'.$type.'_stocks_'.str_replace('-', '', $end).'.xlsx';
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName);

		$style = (new StyleBuilder())
						->setCellAlignment(CellAlignment::CENTER)
						->build();

		$header = ['ID', 'Category', 'Product'];
		$sizes = Size::orderBy('id', 'asc')->get();
		foreach($sizes as $size) {
			if ($size->visibility == '1') {
				array_push($header, $size->name);
			}
		}
		array_push($header, 'Total Stock');
			 
		$rowFromValues = WriterEntityFactory::createRowFromArray($header, $style);
		$writer->addRow($rowFromValues);

		$end = Carbon::create($end)->hour(23)->minute(59)->second(59)->toDateTimeString();
		foreach(Product::all() as $product) {
			$arr = array();
			array_push($arr, $product->id);
			array_push($arr, $product->category->name);
			array_push($arr, $product->name);
			$cnt = 0;
			foreach($sizes as $size) {
				$count = $this->calcStock($product->id, $size->id, $end);
				if ($size->visibility == '1') {
					array_push($arr, $count);
				}
				$cnt += $count;
			}
			array_push($arr, $cnt);
			if($type == 'in' && $cnt > 0) {
				$rowFromValues = WriterEntityFactory::createRowFromArray($arr, $style);
				$writer->addRow($rowFromValues);
			} else if($type == 'out' && $cnt == 0) {
				$rowFromValues = WriterEntityFactory::createRowFromArray($arr, $style);
				$writer->addRow($rowFromValues);
			}
		}

		$writer->close();
	}

	function getNumberContent($count) {
		$colors = Color::select('color')->pluck('color');
		$color = $colors[0];
		if($count == 1) $color = $colors[1];
		if($count > 1) $color = $colors[2];

		return '<div class="d-flex justify-content-center align-items-center p-3" style="background-color:'.$color.';">'.$count.'</div>';
	}
	function getTextContent($text) {
		return '<div class="d-flex justify-content-center align-items-center p-3">'.$text.'</div>';
	}

	function calcStock($product_id, $size_id, $end) {
		return Stock::where('product_id', $product_id)
										->where('size_id', $size_id)
										->where('updated_at', '<=', $end)
										->sum('quantity');
	}
}
