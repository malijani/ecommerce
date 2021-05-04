<?php

use \Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;
use \Unisharp\LaravelFilemanager\Lfm;

Auth::routes(['verify' => true]);

// GUEST SECTION
Route::redirect('home', '/');
Route::group(['prefix' => '/', 'middleware' => ['web', 'XssSanitizer']], function () {
    Route::get('', 'HomeController@home')->name('home');
    Route::resource('blog', 'Visitor\BlogController')->only(['index', 'show', 'update']);
    Route::resource('category', 'Visitor\CategoryController')->only(['index', 'show']);
    Route::resource('product', 'Visitor\ProductController')->only(['index', 'show']);
    Route::resource('brand', 'Visitor\BrandController')->only(['index', 'show']);
    Route::resource('faq', 'Visitor\FaqController')->only(['index']);
    Route::resource('page', 'Visitor\PageController')->only(['index', 'show']);
    Route::post('comment/{model}/{id}', 'Visitor\CommentController@store')->name('comment.store');
    Route::resource('cart', 'User\CartController')->only(['index', 'store', 'destroy', 'update']);
    Route::post('apply-discount', 'User\CartController@applyDiscount')->name('cart.discount');
});

// USER SECTION
Route::group(['prefix' => 'user', 'middleware' => ['web', 'auth', 'auth.normal', 'verified', 'XssSanitizer']], function () {
    /*ADDRESSES*/
    Route::resource('address', 'User\AddressController')->only(['index', 'destroy', 'store', 'update']);
    Route::post('province/cities', 'User\ProvinceController@cities')->name('province.cities');
    /*RATE*/
    Route::resource('rating', 'User\RatingController')->only(['store']);
    /*DASHBOARD*/
    Route::resource('dashboard', 'User\Dashboard\DashboardController')->only(['index']);
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::resource('orders', 'User\Dashboard\OrderController')->only(['index']);
        Route::resource('addresses', 'User\Dashboard\AddressController')->only(['index']);
        Route::resource('profile', 'User\Dashboard\UserController')->only(['index', 'update']);
        Route::resource('tickets', 'User\Dashboard\TicketController');
        Route::resource('ticket-comments', 'User\Dashboard\CommentController');
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
    Route::resource('comments', 'Admin\CommentController');
    /*TICKETS*/
    Route::resource('ticket-categories', 'Admin\Ticket\CategoryController')->except(['show', 'create', 'edit']);
    Route::resource('tickets', 'Admin\Ticket\TicketController');
    Route::resource('ticket-comments', 'Admin\Ticket\CommentController');

    /*SOCIAL MEDIA*/
    Route::resource('social-medias', 'Admin\SocialMediaController');
    Route::resource('social-media-buttons', 'Admin\SocialMediaButtonController')->except(['show']);

    /*PAGES*/
    Route::resource('faqs', 'Admin\FaqController')->except(['show']);
    Route::resource('faq-page', 'Admin\FaqPageController')->only(['store', 'update']);
    Route::resource('pages', 'Admin\PageController')->except(['show']);

    /*DISCOUNT*/
    Route::resource('discount-codes', 'Admin\DiscountCodeController')->except(['show']);

    /*WEBSITE CONTROL*/
    Route::resource('top-navs', 'Admin\TopNavController')->except(['show']);
    Route::resource('logos', 'Admin\LogoController')->except(['show']);
    Route::resource('banners', 'Admin\BannerController')->except(['show']);
    Route::resource('sliders', 'Admin\SliderController')->except(['show']);
    Route::resource('image-menus', 'Admin\ImageMenuController')->except(['show']);

    /*FOOTER CONTROL*/
    Route::resource('footer-images', 'Admin\FooterImageController')->except(['show']);
    Route::resource('footer-items', 'Admin\FooterItemController')->except(['create', 'show', 'edit']);
    Route::resource('footer-links', 'Admin\FooterLinkController');
    Route::resource('footer-texts', 'Admin\FooterTextController');
    Route::resource('footer-licenses', 'Admin\FooterLicenseController');

    /*FILE MANAGER*/
    Route::view('files', 'admin.file-manager.index')->name('admin.fm-frame');
    Route::group(['prefix' => 'file-manager'], function () {
        Lfm::routes();
    });


});

Route::group(['prefix' => 'files', 'as' => 'files.', 'middleware' => ['web', 'auth']], function () {
    Route::get('ticket/{id}/{type}', 'File\TicketFileController@show')->name('ticket-files');
});





