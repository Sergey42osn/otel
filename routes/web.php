<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AccommodationController;
use App\Http\Controllers\BlogController;

include 'web_builder.php';
include 'demo.php';
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


/* AJAX routes */

Auth::routes(['verify' => true]);


Route::post('/registration-vendor', 'Auth\RegisterController@registrationVendor')->name('vendor.registration');
Route::post('/registration', 'Auth\RegisterController@registration')->name('customer.registration');
Route::post('/userlogin', 'Auth\LoginController@userlogin');
Route::post('/vendorlogin', 'Auth\LoginController@vendorLogin');

Route::post('change-name', 'AccountController@changeName')->name('change.name');
Route::post('change-gender', 'AccountController@changeGender')->name('change.gender');
Route::post('change-email', 'AccountController@changeEmail')->name('change.email');
Route::post('change-phone', 'AccountController@changePhone')->name('change.phone');
Route::post('change-address', 'AccountController@changeAddress')->name('change.address');
Route::post('upload-avatar', 'AccountController@uploadAvatar')->name('upload.avatar');
Route::post('update-wish', 'AccountController@updateWish')->name('update.wish');


Route::post('change-phone-verify', [\App\Http\Controllers\UserController::class, 'changePhone_verify'])->name('change-phone-verify');


Route::post('filter-countries', FilterCountryCountroller::class)->name('filter-country');
Route::post('filter-room-type',[\App\Http\Controllers\RoomController::class,'filter'])->name('filter-room-type');
Route::post('filter-country',[\App\Http\Controllers\OrderController::class,'filterCountry'])->name('filter-countries');

Route::post('/customer/activate/phone_account',  [\App\Http\Controllers\Auth\VerificationController::class, 'phone_verify_account'])->name('customer.activate_phone_account');

Route::post('penalty/check', 'AccountController@checkPenalty')->name('check-penalty');

Route::get('/customer/auth/google', 'Auth\SocialLoginController@redirectToGoogle')->name('auth.google');
Route::get('/customer/auth/vk', 'Auth\SocialLoginController@redirectToVK')->name('auth.vk');
Route::get('/customer/auth/ok', 'Auth\SocialLoginController@redirectToOk')->name('auth.ok');
Route::get('/customer/auth/google/callback', 'Auth\SocialLoginController@handleGoogleCallback');
Route::get('/customer/auth/vk/callback', 'Auth\SocialLoginController@handleVkCallback');
Route::get('/customer/auth/ok/callback', 'Auth\SocialLoginController@handleOkCallback');

Route::post('/customer/activate/phone2',  [\App\Http\Controllers\Auth\VerificationController::class, 'check_register'])->name('customer.activate_phone_check');


Route::post('/customer/activate/phone',  [\App\Http\Controllers\Auth\VerificationController::class, 'phone_verify'])->name('customer.activate_phone');
Route::post('/vendor/activate/phone',  [\App\Http\Controllers\Auth\VerificationController::class, 'vendorPhoneVerify'])->name('vendor_activate_phone');

Route::post('reviews-reply', [\App\Http\Controllers\RatingController::class, 'reply'])->name('reviews-reply');
Route::post('send-mail', 'SiteController@sendMail')->name('send_mail');

Route::group(['middleware' => 'locale', 'prefix' => '{locale?}'], function () {
    Route::post('make-order', 'OrderController@makeOrder')->name('make-order');
    Route::get('/agency-contract-offer','SiteController@agencyContractOffer')->name('agency-contract-offer');
    Route::get('/aviasales','SiteController@aviasales')->name('aviasales');
    Route::view('/create', 'register')->name('register_object');
    /*Site controller*/
    Route::get('/', 'SiteController@homePage')->name('home_page');
    Route::get('/privacy-page', 'SiteController@privicyPage')->name('privacy_page');
    Route::get('/legal-page', 'SiteController@legalPage')->name('legal-page');
    Route::get('/faq-page', 'SiteController@faqPage')->name('faq_page');

    // login2, register2 pages
    Route::view('login2', 'auth.login2');
    Route::view('login3', 'auth.login3');
    Route::view('register2', 'auth.register2');
    Route::view('register3', 'auth.register3');

    // Route::get('/', function () {
    //     return redirect()->route('search', ['locale' => 'en']);
    // });




    Route::get('/login-vendor','Auth\RegisterController@vendorLogin');
    Route::get('/customer','Auth\RegisterController@customerLogin');

    Route::get('/forgot-password','Auth\ForgotPasswordController@index')->name('forgot-password-page');
    Route::post('/forgot-password','Auth\ForgotPasswordController@submitForgotLink')->name('forgot-password');
    Route::get('/reset-password','Auth\ResetPasswordController@index')->name('reset-password-page');
    Route::post('/reset-password','Auth\ResetPasswordController@resetPassword')->name('reset-password');

    Route::get('user/activate/{auth_token}', 'Auth\VerificationController@verify')->name('customer.activate');
    Route::get('user-vendor/activate/{auth_token}', 'Auth\VerificationController@vendorVerify')->name('vendor.activate');

    Route::get('/account', 'AccountController@index')->name('account');
    Route::get('/security', 'AccountController@security')->name('security');
    Route::get('/favourites', 'AccountController@favourites')->name('favourites');
    Route::get('/booking-history', 'AccountController@bookingHistory')->name('booking-history');
    Route::post('/delete-account', 'AccountController@deleteAccount')->name('delete-account');
    Route::post('change-password', 'AccountController@changePassword')->name('change.password');
    Route::post('/customer-logout', 'AccountController@logout')->name('customer-logout');



    Route::get('/list', [AccommodationController::class, 'search'])->name('search');


    // GUI crud builder routes
    Route::group(['middleware' => ['auth']], function () {

        Route::resource('rooms', RoomController::class);

        Route::resource('youth-hotels', YouthHotelController::class);
        Route::resource('appartments', AppartmentController::class);
        Route::resource('villas', VillaController::class);
        Route::resource('hotels', HotelController::class);
        Route::resource('users', UserController::class);
        Route::post('cancel-booking', [\App\Http\Controllers\BookingAndReportsController::class, 'cancel'])->name('cancel-booking');

        Route::group(['prefix' => 'account', 'as' => 'user.'], function () {
            Route::get('security', [\App\Http\Controllers\UserController::class, 'security'])->name('security');
            Route::post('change-password', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('change-password');
            Route::post('change-phone', [\App\Http\Controllers\UserController::class, 'changePhone'])->name('change-phone');
            Route::post('exist-password', [\App\Http\Controllers\UserController::class, 'existPassword'])->name('exist-password');
            Route::get('objects', ObjectController::class)->name('objects');
            Route::get('personal-info', [\App\Http\Controllers\UserController::class, 'info'])->name('vendor.info');
            Route::post('company/create', [\App\Http\Controllers\CompanyController::class, 'save'])->name('company');
            Route::post('director', [\App\Http\Controllers\CompanyController::class, 'updateDirector'])->name('update-director');
            Route::post('update-tin', [\App\Http\Controllers\CompanyController::class, 'updateTin'])->name('update-tin');
            Route::post('update-phone', [\App\Http\Controllers\UserController::class, 'changePhone'])->name('update-phone');
            Route::post('update-address', [\App\Http\Controllers\CompanyController::class, 'updateAddress'])->name('update-address');
            Route::post('update-email', [\App\Http\Controllers\UserController::class, 'updateEmail'])->name('update-email');
            Route::post('update-user', [\App\Http\Controllers\UserController::class, 'changeName'])->name('update-user');
            Route::post('change-profile', [\App\Http\Controllers\UserController::class, 'changeAvatar'])->name('change-profiles');
            Route::get('booking-and-reports', BookingAndReportsController::class)->name('booking-and-reports');
            Route::get('reviews', [\App\Http\Controllers\UserController::class, 'reviews'])->name('reviews');
            Route::post('reviews', [\App\Http\Controllers\RatingController::class, 'store'])->name('reviews-store');

            Route::get('finance', [\App\Http\Controllers\FinanceAndDocumentsController::class, 'finance'])->name('finance');
            Route::get('documents', [\App\Http\Controllers\FinanceAndDocumentsController::class, 'document'])->name('documents');
            Route::get('employees', [\App\Http\Controllers\EmployeesController::class, 'employees'])->name('employees');
            Route::post('employees', [\App\Http\Controllers\EmployeesController::class, 'store'])->name('employees-store');
            Route::post('employees-delete', [\App\Http\Controllers\EmployeesController::class, 'delete'])->name('employees-delete');
        });

        Route::any('objects-filter', ObjectFilterController::class)->name('object-filter');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

        Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

        Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

        Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

        Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

        Route::post(
            'generator_builder/generate-from-file',
            '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
        )->name('io_generator_builder_generate_from_file');

        // Model checking
        Route::post('tableCheck', 'AppBaseController@tableCheck');

        Route::get('order', 'OrderController@index')->name('order');
        Route::get('order-success', 'OrderController@viewOrderSuccess')->name('order.success');
        Route::get('view-order/{id}', 'OrderController@viewOrder');
    });

    Route::prefix("blog")->group(function(){
        Route::get('/', [BlogController::class, "index"])->name('blog');
        Route::get('/{category}', [BlogController::class, "category"])->name('blog.showCategory');
        Route::get('/{category}/{slug}', [BlogController::class, "show"])->name('blog.show');
    });

    Route::group(['prefix' => 'accommodation'], function(){

        Route::get('single/{id?}', 'Accommodations\SingleCardController@show')->name('accommodation.single');
        Route::post('wishlist/create', 'WishListController@store');
        Route::post('wishlist/delete', 'WishListController@delete');
        Route::post('check/availability', 'RoomController@checkAvailability');

        Route::resource('rating', 'RatingController');

    });

    Route::group(['prefix' => 'single'], function(){

       
        Route::post('wishlist/create', 'WishListController@store');
        Route::post('wishlist/delete', 'WishListController@delete');
        Route::post('check/availability', 'ApiSingle\SingleCardController@checkAvailability');

    });

    Route::get('single/{slug?}', 'ApiSingle\SingleCardController@show')->name('single');

});

// Nav Routes
Route::view('/hotels', 'navs.hotels')->name('hotels');
Route::view('/youth-hotels', 'navs.youth-hotels')->name('youth-hotels');
Route::view('/villas', 'navs.villas')->name('villas');
Route::view('/appartments', 'navs.appartments')->name('appartments');

Route::get('{name?}', 'JoshController@showView');
