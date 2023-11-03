<?php

use App\Http\Controllers\BagController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FetchController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/fetch-items', [FetchController::class, 'fetchItems']);
Route::get('/fetch-prices', [FetchController::class, 'fetchPrices']);
Route::get('/fetch-ss', [FetchController::class, 'fetchSS']);
Route::get('/fetch-bags', [FetchController::class, 'fetchBags']);

// *
// * CURRENCIES
// *
// VOLATILE MAGIC
Route::get('/currencies/volatile-magic/{returnPriceSetting}/{tax}', [CurrencyController::class, 'volatileMagic']);
// UNBOUND MAGIC
Route::get('/currencies/unbound-magic/{returnPriceSetting}/{tax}', [CurrencyController::class, 'unboundMagic']);


// BAG DETAILS
Route::get('/bags/{table}/{returnPriceSetting}/{tax}', [BagController::class, 'getTable']);