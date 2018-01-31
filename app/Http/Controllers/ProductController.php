<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
	public function index()
	{
    return view('pages.stock.products')->with([
			'categories' => Category::all()
		]);
	}
	
	public function create()	{}

	public function store(Request $request)
	{
		if(Product::where('category_id', $request->category_id)->where('name', $request->name)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		Product::create($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}
	
	public function show($id)	{}
	
	public function edit($id)	{}

	public function update(Request $request, $id)
	{
		if(Product::where('id', '!=', $id)->where('name', $request->name)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		Product::find($id)->update($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}

	public function destroy(Request $request)
	{
    try {
      Product::destroy($request->id);
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

	public function getProducts() {
		$products = array(); $cnt=0;
		foreach(Product::all() as $product) {
			$arr = array();
			$arr['no'] = ++$cnt;
			$arr['name'] = $product->name;
			$arr['category'] = array(
				'id' => $product->category->id,
				'name' => $product->category->name,
				'color' => $product->category->color
			);
			$arr['buy_price'] = $product->buy_price;
			$arr['sell_price'] = $product->sell_price;
			$arr['stock_cur'] = $product->stocks->sum('quantity');
			$arr['updated'] = date_format( $product->updated_at, 'Y-m-d H:i:s');
			$arr['id'] = $product->id;

			$products[] = $arr;
		}
		return response()->json([
			'data' => $products
		], 200);
	}

	public function getCategoryProducts($catetory_id) {
		$products = array();
		foreach(Category::find($catetory_id)->products as $product) {
			$products[] = array(
				'id' => $product->id,
				'name' => $product->name,
			);
		}
		return response()->json([
			'data' => $products
		], 200);
	}
	
	public function import(Request $request) {		
		$reader = ReaderEntityFactory::createXLSXReader();
		// $reader = ReaderEntityFactory::createCSVReader();

		$filePath = $_FILES['file']['tmp_name'];
		$reader->open($filePath);
		
		$header = ['ID', 'Name', 'Category', 'Buy Price', 'Sell Price'];
		
		$i=0; $products = array();
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
						$category = Category::where('name', $cells[2])->first();
						if(!isset($category)) {
							return response()->json([
								'status' => 0,
								'error' => 1,
								'row' => $i
							], 200);
						}
						$product = Product::where('name', $cells[1])->where('category_id', $category->id)->first();
						if(isset($product)) {
							return response()->json([
								'status' => 0,
								'error' => 2,
								'row' => $i
							], 200);
						}

						$arr = array(
							'name' => $cells[1],
							'category_id' => $category->id,
							'buy_price' => $cells[3],
							'sell_price' => $cells[4],
						);
						array_push($products, $arr);
					}
			}
		}
		
		$reader->close();

		foreach($products as $product) {
			Product::create($product);
		}


		return response()->json([
			'status' => 1
		], 200);
	}

	public function export() {
		$fileName = 'products.xlsx';
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName);

		$style = (new StyleBuilder())
						->setCellAlignment(CellAlignment::CENTER)
						->build();

		$header = ['ID', 'Name', 'Category', 'Buy Price', 'Sell Price'];			 
		$rowFromValues = WriterEntityFactory::createRowFromArray($header, $style);
		$writer->addRow($rowFromValues);

		foreach(Product::all() as $product) {
			$arr = array(
				$product->id,
				$product->name,
				$product->category->name,
				$product->buy_price,
				$product->sell_price,
			);

			$rowFromValues = WriterEntityFactory::createRowFromArray($arr, $style);
			$writer->addRow($rowFromValues);
		}

		$writer->close();
	}
}
