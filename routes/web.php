<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use \Unisharp\LaravelFilemanager\Lfm;

Auth::routes(['verify' => true]);

// GUEST SECTION
Route::redirect('home', '/');
Route::group(['prefix' => '/', 'middleware' => ['web']], function () {
    Route::get('', 'HomeController@home')->name('home');
    Route::resource('blog', 'Visitor\BlogController')->only(['index', 'show']);
    Route::resource('category', 'Visitor\CategoryController')->only(['index', 'show']);
    Route::resource('product', 'Visitor\ProductController')->only(['index', 'show']);
    Route::resource('brand', 'Visitor\BrandController')->only(['index', 'show']);
    Route::resource('faq', 'Visitor\FaqController')->only(['index']);
    Route::resource('cart', 'User\CartController')->only(['index', 'store', 'destroy', 'update']);


});

// USER SECTION
Route::group(['prefix' => 'user', 'middleware' => ['web', 'auth', 'auth.normal', 'verified']], function () {
    /*ADDRESSES*/
    Route::resource('address', 'User\AddressController')->only(['index', 'destroy', 'store', 'update']);
    Route::post('province/cities', 'User\ProvinceController@cities')->name('province.cities');
    /*DASHBOARD*/
    Route::resource('dashboard', 'User\Dashboard\DashboardController')->only(['index']);
    Route::group( ['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::resource('orders', 'User\Dashboard\OrderController')->only(['index']);
        Route::resource('addresses', 'User\Dashboard\AddressController')->only(['index']);
        Route::resource('profile', 'User\Dashboard\UserController')->only(['index', 'update']);
    });
});


// ADMIN SECTION
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth', 'auth.admin']], function () {

    Route::get('', 'Admin\AdminController@index')->name('admin.home');

    Route::resource('users', 'Admin\UserController');
    Route::resource('categories', 'Admin\CategoryController');
    Route::resource('brands', 'Admin\BrandController');
    Route::resource('articles', 'Admin\ArticleController');
    Route::resource('products', 'Admin\ProductController');
    Route::resource('attributes', 'Admin\AttributeController')->only(['index', 'store', 'update']);

    /*PAGES*/
    Route::resource('faqs', 'Admin\FaqController')->except(['show']);
    Route::resource('faq-page', 'Admin\FaqPageController')->only(['store', 'update']);

    /*WEBSITE CONTROL*/
    Route::resource('top-navs', 'Admin\TopNavController')->except(['show']);
    Route::resource('logos', 'Admin\LogoController')->except(['show']);
    Route::resource('banners', 'Admin\BannerController')->except(['show']);
    Route::resource('sliders', 'Admin\SliderController')->except('show');
    Route::resource('footer-images', 'Admin\FooterImageController')->except(['show']);

    // FILE MANAGER
    Route::view('files', 'admin.file-manager.index')->name('admin.fm-frame');
    Route::group(['prefix' => 'file-manager'], function () {
        Lfm::routes();
    });

});





