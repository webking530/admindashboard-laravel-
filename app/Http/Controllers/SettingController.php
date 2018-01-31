<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
	public function index()
	{
    return view('pages.settings.index');
	}
	
	public function create()
	{
	}

	public function store(Request $request)
	{
	}
	
	public function show($id)
	{
	}
	
	public function edit($id)
	{
	}

	public function update(Request $request, $id)
	{
	}

	public function destroy($id)
	{
	}

}
