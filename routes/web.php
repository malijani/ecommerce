<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use \Unisharp\LaravelFilemanager\Lfm;

Auth::routes();

// GUEST SECTION
Route::redirect('home', '/');
Route::group(['prefix'=>'/'], function(){
    Route::get('', 'HomeController@home')->name('home');
    Route::resource('blog', 'Visitor\BlogController')->only(['index', 'show']);
    Route::resource('category', 'Visitor\CategoryController')->only(['index','show']);
});


// ADMIN SECTION
Route::group(['prefix'=>'admin', 'middleware'=>['web', 'auth', 'auth.admin']], function(){

    Route::get('', 'Admin\AdminController@index')->name('admin.home');

    Route::resource('categories', 'Admin\CategoryController');
    Route::resource('brands', 'Admin\BrandController');
    Route::resource('articles', 'Admin\ArticleController');
    Route::resource('products', 'Admin\ProductController');

    // FILE MANAGER
    Route::view('files','admin.file-manager.index')->name('admin.fm-frame');
    Route::group(['prefix' => 'file-manager'], function () {
        Lfm::routes();
    });

});







