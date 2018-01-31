<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use Carbon\Carbon;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;

use App\Models\Stock;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Type;

class StockController extends Controller
{
	public function index()
	{
		return view('pages.stock.manage')->with([
			'categories' => Category::all(),
			'sizes' => Size::orderBy('id', 'asc')->get(),
			'types' => Type::all(),
		]);
	}
	
	public function create()	{}

	public function store(Request $request)
	{
		$product_id = $request->product_id;
		$size_id = $request->size_id;

		$total = $this->calcStock($product_id, $size_id);
		if($request->addable == 0 && $total - $request->quantity < 0) {
			return response()->json([
				'status' => 0,
				'stock' => $total
			], 200);
		}

		$request->quantity *= $request->addable == '0'? -1: 1;

		Stock::create($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}
	
	public function show($id)	{}
	
	public function edit($id)	{}

	public function update(Request $request, $id)
	{
	}

	public function destroy(Request $request)
	{
		$stock = Stock::find($request->id);
		$total = $this->calcStock($stock->product_id, $stock->size_id);

		if($stock->addable == '1' && $stock->quantity > $total) {
			return response()->json([
				'status' => -1,
				'stock' => $total,
				'product' => $stock->product->name,
				'size' => $stock->size->name,
			], 200);
		}
		
    try {
      Stock::destroy($request->id);
    } catch (Exception $e) {
      report($e);
			return response()->json([
				'status' => 0
			], 200);
		}
		
		return response()->json([
			'status' => 1
		], 200);
	}

	public function getStocks(Request $request)
	{
		$start = Carbon::create($request->start)->hour(0)->minute(0)->second(0)->toDateTimeString();
		$end = Carbon::create($request->end)->hour(23)->minute(59)->second(59)->toDateTimeString();

		$stocks = Stock::whereBetween('updated_at', [$start, $end])->orderBy('updated_at', 'desc')->get();
		$res = array(); $cnt=0;
		foreach($stocks as $stock) {
			$arr = array();
			$arr['id'] = $stock->id;
			$arr['no'] = ++$cnt;
			$arr['comment'] = array(
				'type_id' => $stock->type_id,
				'type' => $stock->type->icon,
				'color' => $stock->type->color,
				'comment' => $stock->comment,
			);
			$arr['category'] = array(
				'id' => $stock->category_id,
				'name' => $stock->category->name,
				'color' => $stock->category->color
			);
			$arr['product'] = array(
				'id' => $stock->product->id,
				'name' => $stock->product->name,
				'addable' => $stock->addable,
				'quantity' => $stock->quantity,
				'size_id' => $stock->size_id,
				'size' => $stock->size->name,
			);
			$arr['updated'] = date_format( $stock->updated_at, 'Y-m-d H:i:s');

			$res[] = $arr;
		}
		return response()->json([
			'data' => $res
		], 200);
	}

	public function export($start, $end) {
		$fileName = 'stocks_'.str_replace('-', '', $start).'_'.str_replace('-', '', $end).'.xlsx';
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName);

		$style = (new StyleBuilder())
						->setCellAlignment(CellAlignment::CENTER)
						->build();

		$header = ['ID', 'Category', 'Product', 'Size', 'Type', 'Quantity', 'Updated date', 'Comment'];					 
		$rowFromValues = WriterEntityFactory::createRowFromArray($header, $style);
		$writer->addRow($rowFromValues);

		$start = Carbon::create($start)->hour(0)->minute(0)->second(0)->toDateTimeString();
		$end = Carbon::create($end)->hour(23)->minute(59)->second(59)->toDateTimeString();
		$stocks = Stock::whereBetween('updated_at', [$start, $end])->orderBy('updated_at', 'desc')->get();

		foreach($stocks as $stock) {
			$row = [
				$stock->id,
				$stock->category->name,
				$stock->product->name,
				$stock->size->name,
				$stock->type->name,
				$stock->quantity,
				date('Y-m-d H:i:s', strtotime($stock->updated_at)),
				$stock->comment
			];
			$rowFromValues = WriterEntityFactory::createRowFromArray($row, $style);
			$writer->addRow($rowFromValues);
		}

		$writer->close();
	}

	public function import(Request $request) {		
		$reader = ReaderEntityFactory::createXLSXReader();
		// $reader = ReaderEntityFactory::createCSVReader();

		$filePath = $_FILES['file']['tmp_name'];
		$reader->open($filePath);
		
		$header = ['ID', 'Category', 'Product', 'Size', 'Type', 'Quantity', 'Updated date', 'Comment'];
		
		$i=0; $stocks = array();
		foreach ($reader->getSheetIterator() as $sheet) {
			foreach ($sheet->getRowIterator() as $row) {
					// do stuff with the row
					$cells = $row->toArray();
					if($i++ == 0) {
						if($cells != $header) {
							return response()->json([
								'status' => 0,
								'error' => 0
							], 200);
						}
					} else {
						$category = Category::where('name', $cells[1])->first();
						if(!isset($category)) {
							return response()->json([
								'status' => 0,
								'error' => 1,
								'row' => $i
							], 200);
						}
						$product = Product::where('name', $cells[2])->first();
						if(!isset($product)) {
							return response()->json([
								'status' => 0,
								'error' => 2,
								'row' => $i
							], 200);
						}
						$size = Size::where('name', $cells[3])->first();
						if(!isset($size)) {
							return response()->json([
								'status' => 0,
								'error' => 3,
								'row' => $i
							], 200);
						}
						$type = Type::where('name', $cells[4])->first();
						if(!isset($type)) {
							return response()->json([
								'status' => 0,
								'error' => 4,
								'row' => $i
							], 200);
						}
						$total = $this->calcStock($product->id, $size->id) + $cells[5];
						if(is_int($cells[5]) != 1 || $total < 0) {
							return response()->json([
								'status' => 0,
								'error' => 5,
								'row' => $i
							], 200);
						}

						$arr = array(
							'category_id' => $category->id,
							'product_id' => $product->id,
							'size_id' => $size->id,
							'type_id' => $type->id,
							'quantity' => $cells[5],
							'addable' => $cells[5] > 0? '1': '0',
							'comment' => $cells[7]
						);
						array_push($stocks, $arr);
					}
			}
		}
		
		$reader->close();

		foreach($stocks as $stock) {
			Stock::create($stock);
		}


		return response()->json([
			'status' => 1
		], 200);
	}

	function calcStock($product_id, $size_id) {
		return Stock::where('product_id', $product_id)
										->where('size_id', $size_id)
										->sum('quantity');
	}
}
