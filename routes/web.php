<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', 'Auth\LoginController@index')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
// Route::middleware(['auth', 'HtmlMinifier'])->group(function(){

	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/getChartData', 'HomeController@getChartData');

	Route::get('/getCategories', 'CategoryController@getCategories');
	Route::post('/categories/import', 'CategoryController@import');
	Route::get('/categories/export', 'CategoryController@export');
	Route::resource('categories', 'CategoryController');

	Route::get('/getProducts', 'ProductController@getProducts');
	Route::get('/getCategoryProducts/{id}', 'ProductController@getCategoryProducts');
	Route::post('/products/import', 'ProductController@import');
	Route::get('/products/export', 'ProductController@export');
	Route::resource('products', 'ProductController');

	Route::post('/getStocks', 'StockController@getStocks');
	Route::get('/stocks/export/{start}/{end}', 'StockController@export');
	Route::post('/stocks/import', 'StockController@import');
	Route::resource('stocks', 'StockController');
	
	Route::post('/getReports', 'StockReportController@getReports');
	Route::get('/reports/export/{type}/{end}', 'StockReportController@export');
	Route::get('/reports', 'StockReportController@index');

	Route::get('/getTypes', 'TypeController@getTypes');
	Route::resource('types', 'TypeController');

	Route::resource('colors', 'ColorController')->except('create', 'edit', 'show', 'update', 'destroy');
	
	Route::get('/getSizes', 'SizeController@getSizes');
	Route::post('/changeSizeVisibility', 'SizeController@changeSizeVisibility');
	Route::resource('sizes', 'SizeController');

	Route::get('/settings', 'SettingController@index');
// });

//For testing
// Route::get('/reports', 'HomeController@index')->name('home');