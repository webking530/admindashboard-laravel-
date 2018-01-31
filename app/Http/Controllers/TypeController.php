<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use App\Models\Type;

class TypeController extends Controller
{
	public function index()	{}
	
	public function create() {}

	public function store(Request $request)
	{
		if(Type::where('name', $request->name)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		Type::create($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}
	
	public function show($id)	{}
	
	public function edit($id)	{}

	public function update(Request $request, $id)
	{
		if(Type::where('id', '!=', $id)->where('name', $request->name)->count() > 0) {
			return response()->json([
				'status' => 0
			], 200);
		}

		Type::find($id)->update($request->all());
		return response()->json([
			'status' => 1
		], 200);
	}

	public function destroy(Request $request)
	{
    try {
      Type::destroy($request->id);
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

	public function getTypes() {
		$types = array(); $cnt=0;
		foreach(Type::all() as $type) {
			$arr = array();
			$arr['no'] = ++$cnt;
			$arr['name'] = $type->name;
			$arr['icon'] = array(
        'name' => $type->icon,
        'color' => $type->color,
      );
			$arr['id'] = $type->id;

			$types[] = $arr;
		}
		return response()->json([
			'data' => $types
		], 200);
	}
}
