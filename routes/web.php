<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;


// TODO : REMOVE WELCOME AND SHOW SITE INDEX
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// ADMIN SECTION
Route::group(['prefix'=>'admin', 'middleware'=>['auth', 'auth.admin']], function(){
    Route::get('', 'Admin\AdminController@index')->name('admin.home');
    Route::resource('categories', 'Admin\CategoryController');
    Route::resource('brands', 'Admin\BrandController');
});

// USER SECTION
Route::group(['prefix'=>'home', 'middleware'=>['auth', 'auth.normal']], function(){
    Route::get('', 'HomeController@index')->name('home');
});





