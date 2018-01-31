<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Color;

class ColorController extends Controller
{
	public function index()	{
		$colors = array();
		foreach(Color::all() as $color) {
			$colors[] = array(
        'no' => $color->id,
        'name' => $color->name,
        'color' => $color->color
      );
		}
		return response()->json([
			'data' => $colors
		], 200);
  }
	
	public function store(Request $request)
	{
    Color::truncate();
    Color::insert(json_decode($request->colors, true));
    
		return response()->json([
			'status' => 1
		], 200);
	}
	
}
