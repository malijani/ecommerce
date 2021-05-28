<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('products', 'Api\Product\ProductController')->only(['index', 'show']);
Route::resource('categories', 'Api\Category\CategoryController')->only(['index', 'show']);
Route::resource('brands', 'Api\Brand\BrandController')->only(['index', 'show']);

Route::post('login', 'Api\Auth\LoginController@login');

Route::get('/users',function(){
    return \App\User::all();
})->middleware('auth:api');*/
