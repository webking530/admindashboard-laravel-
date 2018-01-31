<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use App\Models\Size;

class SizeController extends Controller
{
	public function index()	{}
	
	public function create() {}

	public function store(Request $request)
	{
		if(Size::where('name', $request->name)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		Size::create($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}
	
	public function show($id)	{}
	
	public function edit($id)	{}

	public function update(Request $request, $id)
	{
		if(Size::where('id', '!=', $id)->where('name', $request->name)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		Size::find($id)->update($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}

	public function destroy(Request $request)
	{
    try {
      Size::destroy($request->id);
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

	public function getSizes() {
		$sizes = array(); $cnt=0;
		foreach(Size::orderBy('id', 'asc')->get() as $size) {
			$arr = array();
			$arr['no'] = ++$cnt;
			$arr['name'] = $size->name;
			$arr['stock_cnt'] = $size->stocks->sum('quantity');
			$arr['id'] = $size->id;

			$sizes[] = $arr;
		}
		return response()->json([
			'data' => $sizes
		], 200);
	}

	public function changeSizeVisibility(Request $request) {
		$sizes = json_decode($request->sizes, true);

		foreach ($sizes as $size) {
			Size::find($size['id'])->update(['visibility' => $size['visibility']]);
		}

		return response()->json([
			'status' => 1
		], 200);
	}
}
