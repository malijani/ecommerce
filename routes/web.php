<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use \Unisharp\LaravelFilemanager\Lfm;

Auth::routes(['verify'=>true]);

// GUEST SECTION
Route::redirect('home', '/');
Route::group(['prefix'=>'/', 'middleware'=>['web']], function(){
    Route::get('', 'HomeController@home')->name('home');
    Route::resource('blog', 'Visitor\BlogController')->only(['index', 'show']);
    Route::resource('category', 'Visitor\CategoryController')->only(['index','show']);
    Route::resource('product', 'Visitor\ProductController')->only(['index', 'show']);
    Route::resource('brand', 'Visitor\BrandController')->only(['index', 'show']);
    Route::resource('cart', 'User\CartController')->only(['index', 'store', 'destroy', 'update']);

});

// USER SECTION
Route::group(['prefix'=>'user', 'middleware'=>['web', 'auth', 'auth.normal', 'verified']], function(){
    Route::resource('address', 'User\AddressController')->only(['index', 'destroy', 'store', 'update']);
    Route::post('province/cities', 'User\ProvinceController@cities')->name('province.cities');
});


// ADMIN SECTION
Route::group(['prefix'=>'admin', 'middleware'=>['web', 'auth', 'auth.admin']], function(){

    Route::get('', 'Admin\AdminController@index')->name('admin.home');
    Route::resource('users', 'Admin\UserController');
    Route::resource('categories', 'Admin\CategoryController');
    Route::resource('brands', 'Admin\BrandController');
    Route::resource('articles', 'Admin\ArticleController');
    Route::resource('products', 'Admin\ProductController');
    Route::resource('attributes', 'Admin\AttributeController')->only(['index','store', 'update']);
    Route::resource('banners', 'Admin\BannerController')->except(['show']);
    Route::resource('sliders', 'Admin\SliderController')->except('show');
    Route::resource('logos', 'Admin\LogoController')->except(['show']);
    // FILE MANAGER
    Route::view('files','admin.file-manager.index')->name('admin.fm-frame');
    Route::group(['prefix' => 'file-manager'], function () {
        Lfm::routes();
    });

});





