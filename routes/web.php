<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ZipcodeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/nueva-orden', function () {
    return view('form_order', ['products' => Product::all()]);
})->middleware('auth');
Route::get('/ordenes', function () {
    return view('orders');
})->middleware('auth');
Route::post('/get-city-state/{zipcode}','App\Http\Controllers\ZipcodeController@getCityState');
Route::post('/save-order','App\Http\Controllers\OrderController@store');
Route::get('/render-table','App\Http\Controllers\OrderController@index');
Route::post('/change-status','App\Http\Controllers\OrderController@changeStatus');
//Route::post('/get-city-state/{zipcode}',[ZipcodeController::class,'getCityState']);
Route::get('/logout','App\Http\Controllers\Auth\LoginController@logout');
Route::post('/import','App\Http\Controllers\ProductController@import')->name('import');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
