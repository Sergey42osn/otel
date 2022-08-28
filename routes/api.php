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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('filter-cities', [App\Http\Controllers\Api\CountryFilterCountroller::class, 'searchByName']);
Route::post('filter-locations', [App\Http\Controllers\Api\CountryFilterCountroller::class, 'locationByName']);
Route::apiResource('hotels', \Api\HotelController::class)->names('api.hotels');
Route::get('/countries',  \Api\CountryController::class);
Route::apiResource('appartments', \Api\AppartmentController::class)->names('api.appartments');
Route::post('filter-hotels', [App\Http\Controllers\Api\AccommodationController::class, 'search']);
Route::post('accomodation', [App\Http\Controllers\Api\HotelController::class, 'show']);

Route::get('best-offers', [App\Http\Controllers\Api\HomeDestinationController::class, 'index']);
Route::get('policy', [App\Http\Controllers\Api\PolicyController::class, 'index']);
Route::get('legal', [App\Http\Controllers\Api\LegalController::class, 'index']);

Route::get('init-data', [App\Http\Controllers\Api\ApiController::class, 'index']);

Route::post('get-bonus', [App\Http\Controllers\Api\BonusController::class, 'getBonus']);

Route::get('import/countries', [App\Http\Controllers\SiteController::class, 'importCountries']);
