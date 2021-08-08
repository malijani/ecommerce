<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Middlewares\CreateDefaultFolder;
use UniSharp\LaravelFilemanager\Middlewares\MultiUser;

/*TODO : REMOVE THIS TEST LOGIN*/
Route::get('custom-login/{mobile}', function (int $mobile) {
    $user = User::withoutTrashed()
        ->where('mobile', $mobile)
        ->firstOrCreate(
            ['mobile' => $mobile],
            ['uuid' => generateUniqueString(app('App\\User'), 'uuid', 10)]
        );
    Auth::login($user, true);
    return redirect(route('home'))->with('success', 'موفق');
})->name('custom-login');

/*CUSTOM VERIFY*/
Route::group(['middleware' => ['guest']], function () {
    Route::get('login', 'Auth\AuthController@showLogin')->name('login');
    Route::post('login', 'Auth\AuthController@doLogin')->name('login');
    /*TODO : VERIFY ROUTE PROTECTING*/
    Route::get('verify', 'Auth\AuthController@showVerify')->name('verify.show');
    Route::post('verify', 'Auth\AuthController@doVerify')->name('verify');
    Route::get('verify/resend', 'Auth\AuthController@resendCode')->name('verify.resend');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::post('logout', 'Auth\AuthController@doLogout')->name('logout');
});


// GUEST SECTION
Route::redirect('home', '/');
Route::group(['prefix' => '/', 'middleware' => ['web', 'xss.sanitizer']], function () {
    Route::get('', 'HomeController@home')->name('home');
    Route::resource('product', 'Visitor\ProductController')->only(['index', 'show']);
    Route::resource('blog', 'Visitor\BlogController')->only(['index', 'show']);
    Route::resource('category', 'Visitor\CategoryController')->only(['index', 'show']);
    Route::resource('brand', 'Visitor\BrandController')->only(['index', 'show']);
    Route::resource('faq', 'Visitor\FaqController')->only(['index']);
    Route::resource('page', 'Visitor\PageController')->only(['index', 'show']);

    Route::post('comment/{model}/{id}', 'Visitor\CommentController@store')->name('comment.store');

    Route::resource('cart', 'User\CartController')->only(['index', 'store', 'destroy', 'update']);

    Route::post('apply-discount', 'User\CartController@applyDiscount')->name('cart.discount');
});

// USER SECTION
Route::group(['prefix' => 'user', 'middleware' => ['web', 'auth', 'auth.normal', 'xss.sanitizer']], function () {
    /*ADDRESSES*/
    Route::resource('address', 'User\AddressController')->only(['index', 'destroy', 'store', 'update']);
    Route::post('province/cities', 'User\ProvinceController@cities')->name('province.cities');

    /*Factor*/
    Route::post('factor/create', 'User\Factor\FactorController@store')->name('factor.store');
    Route::get('factor/pay/{factor_uui}', 'User\Factor\FactorController@pay')->name('factor.pay');
    Route::get('factor/verify/{factor_uui}', 'User\Factor\FactorController@verify')->name('factor.verify');
    /*RATE*/
    Route::resource('rating', 'User\RatingController')->only(['store']);

    /*DASHBOARD*/
    Route::resource('dashboard', 'User\Dashboard\DashboardController')->only(['index']);
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::resource('orders', 'User\Dashboard\OrderController')->only(['index', 'show', 'update', 'destroy']);
        Route::resource('addresses', 'User\Dashboard\AddressController')->only(['index']);
        Route::resource('profile', 'User\Dashboard\UserController')->only(['index', 'update']);
        Route::resource('tickets', 'User\Dashboard\TicketController');
        Route::resource('ticket-comments', 'User\Dashboard\CommentController');
    });

});


// ADMIN SECTION
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth', 'auth.admin']], function () {

    Route::get('', 'Admin\AdminController@index')->name('admin.home');
    /*FACTORS*/
    Route::resource('factors', 'Admin\FactorController')->only(['index', 'show', 'edit']);
    Route::post('factors/comment/{id}', 'Admin\FactorController@comment')->name('factors.comment');
    Route::post('factors/shipping/{id}', 'Admin\FactorController@shipping')->name('factors.shipping');
    Route::post('factors/restore/{id}', 'Admin\FactorController@restore')->name('factors.restore');
    Route::post('factors/unarchive/{id}', 'Admin\FactorController@unArchive')->name('factors.unarchive');


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
    Route::resource('pages', 'Admin\PageController')->except(['show']);
    Route::resource('header-pages', 'Admin\HeaderPageController');

    /*DISCOUNT*/
    Route::resource('discount-codes', 'Admin\DiscountCodeController')->except(['show']);

    /*WEBSITE CONTROL*/
    Route::resource('top-navs', 'Admin\TopNavController')->except(['show']);
    Route::resource('logos', 'Admin\LogoController')->except(['show']);
    Route::resource('favicons', 'Admin\FaviconController')->except(['show']);
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
        $middleware = [ CreateDefaultFolder::class, MultiUser::class ];
        $as = 'unisharp.lfm.';
        $namespace = '\\UniSharp\\LaravelFilemanager\\Controllers\\';

        Route::group(compact('middleware', 'as', 'namespace'), function () {

            // display main layout
            Route::get('/', [
                'uses' => 'LfmController@show',
                'as' => 'show',
            ]);

            // display integration error messages
            Route::get('/errors', [
                'uses' => 'LfmController@getErrors',
                'as' => 'getErrors',
            ]);

            // upload
            Route::any('/upload', [
                'uses' => 'UploadController@upload',
                'as' => 'upload',
            ]);

            // list images & files
            Route::get('/jsonitems', [
                'uses' => 'ItemsController@getItems',
                'as' => 'getItems',
            ]);

            Route::get('/move', [
                'uses' => 'ItemsController@move',
                'as' => 'move',
            ]);

            Route::get('/domove', [
                'uses' => 'ItemsController@domove',
                'as' => 'domove'
            ]);

            // folders
            Route::get('/newfolder', [
                'uses' => 'FolderController@getAddfolder',
                'as' => 'getAddfolder',
            ]);

            // list folders
            Route::get('/folders', [
                'uses' => 'FolderController@getFolders',
                'as' => 'getFolders',
            ]);

            // crop
            Route::get('/crop', [
                'uses' => 'CropController@getCrop',
                'as' => 'getCrop',
            ]);
            Route::get('/cropimage', [
                'uses' => 'CropController@getCropimage',
                'as' => 'getCropimage',
            ]);
            Route::get('/cropnewimage', [
                'uses' => 'CropController@getNewCropimage',
                'as' => 'getCropnewimage',
            ]);

            // rename
            Route::get('/rename', [
                'uses' => 'RenameController@getRename',
                'as' => 'getRename',
            ]);

            // scale/resize
            Route::get('/resize', [
                'uses' => 'ResizeController@getResize',
                'as' => 'getResize',
            ]);
            Route::get('/doresize', [
                'uses' => 'ResizeController@performResize',
                'as' => 'performResize',
            ]);

            // download
            Route::get('/download', [
                'uses' => 'DownloadController@getDownload',
                'as' => 'getDownload',
            ]);

            // delete
            Route::get('/delete', [
                'uses' => 'DeleteController@getDelete',
                'as' => 'getDelete',
            ]);

        });
    });
});


Route::group(['prefix' => 'files', 'as' => 'files.', 'middleware' => ['web', 'auth']], function () {
    Route::get('ticket/{id}/{type}', 'File\TicketFileController@show')->name('ticket-files');
});





