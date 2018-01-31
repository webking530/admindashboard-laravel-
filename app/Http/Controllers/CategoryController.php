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

class CategoryController extends Controller
{
	public function index()
	{
    return view('pages.stock.categories');
	}
	
	public function create()	{}

	public function store(Request $request)
	{
		if(Category::where('name', $request->name)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		Category::create($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}
	
	public function show($id)	{}
	
	public function edit($id)	{}

	public function update(Request $request, $id)
	{
		if(Category::where('id', '!=', $id)->where('name', $request->name)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		Category::find($id)->update($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}

	public function destroy(Request $request)
	{
    try {
      Category::destroy($request->id);
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

	public function getCategories() {
		$categories = array(); $cnt=0;
		foreach(Category::all() as $category) {
			$arr = array();
			$arr['no'] = ++$cnt;
			$arr['name'] = $category->name;
			$arr['color'] = $category->color;
			$arr['product_cnt'] = $category->products->count();
			$arr['stock_all'] = $category->stocks->count();
			$arr['stock_cur'] = $category->stocks->count();
			$arr['updated'] = date_format( $category->updated_at, 'Y-m-d H:i:s');
			$arr['id'] = $category->id;

			$categories[] = $arr;
		}
		return response()->json([
			'data' => $categories
		], 200);
	}

	public function import(Request $request) {		
		$reader = ReaderEntityFactory::createXLSXReader();
		// $reader = ReaderEntityFactory::createCSVReader();

		$filePath = $_FILES['file']['tmp_name'];
		$reader->open($filePath);
		
		$header = ['ID', 'Name', 'Color'];
		
		$i=0; $categories = array();
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
						if(isset($category)) {
							return response()->json([
								'status' => 0,
								'error' => 1,
								'row' => $i
							], 200);
						}

						$arr = array(
							'name' => $cells[1],
							'color' => $cells[2]
						);
						array_push($categories, $arr);
					}
			}
		}
		
		$reader->close();

		foreach($categories as $category) {
			Category::create($category);
		}


		return response()->json([
			'status' => 1
		], 200);
	}

	public function export() {
		$fileName = 'categories.xlsx';
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName);

		$style = (new StyleBuilder())
						->setCellAlignment(CellAlignment::CENTER)
						->build();

		$header = ['ID', 'Name', 'Color'];				 
		$rowFromValues = WriterEntityFactory::createRowFromArray($header, $style);
		$writer->addRow($rowFromValues);

		foreach(Category::all() as $category) {
			$arr = array(
				$category->id,
				$category->name,
				$category->color,
			);

			$rowFromValues = WriterEntityFactory::createRowFromArray($arr, $style);
			$writer->addRow($rowFromValues);
		}

		$writer->close();
	}
}
