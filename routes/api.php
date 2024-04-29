<?php

use App\Http\Controllers\BagController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FetchController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Events\CurrentDeviceLogout;
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
Route::post('/user/enterAPIKey', [UserController::class, 'enterAPIKey']);

Route::get('/fetch-items', [FetchController::class, 'fetchItems']);
Route::get('/fetch-currencies', [FetchController::class, 'fetchCurrencies']);
Route::get('/fetch-prices', [FetchController::class, 'fetchPrices']);
Route::get('/fetch-research-notes', [FetchController::class, 'fetchResearchNotes']);
Route::get('/fetch-recipes', [FetchController::class, 'fetchRecipes']);
Route::get('/fetch-recipe-trees', [FetchController::class, 'fetchRecipeTrees']);
Route::get('/fetch-recipe-values', [FetchController::class, 'fetchRecipeValues']);
Route::get('/fetch-bags', [FetchController::class, 'fetchBags']);

// *
// * TOOLS
// *
Route::get('/recipes/{request}/{id}/{quantity}', [RecipeController::class, 'getRecipeValues']);
Route::get('/recipes/search-recipes', [RecipeController::class, 'searchRecipes']);

// *
// * CURRENCIES
// *
// * LAURELS
Route::get('/currencies/laurel/{sellOrderSetting}/{tax}', [CurrencyController::class, 'laurel']);
// * RESEARCH NOTES
Route::get('/currencies/salvage-research-notes/{buyOrderSetting}/{sellOrderSetting}/{tax}', [CurrencyController::class, 'salvageResearchNotes']);
// * SPIRIT SHARDS
Route::get('/currencies/spirit-shards/{buyOrderSetting}/{sellOrderSetting}/{tax}', [CurrencyController::class, 'getSpiritShards']);
// * TRADE CONTRACTS
Route::get('/currencies/trade-contract/{sellOrderSetting}/{tax}', [CurrencyController::class, 'tradeContract']);
// * VOLATILE MAGIC
Route::get('/currencies/volatile-magic/{sellOrderSetting}/{tax}', [CurrencyController::class, 'volatileMagic']);
// * UNBOUND MAGIC
Route::get('/currencies/unbound-magic/{sellOrderSetting}/{tax}', [CurrencyController::class, 'unboundMagic']);

Route::get('/currencies/research-note/{buyOrderSetting}/{filter}', [CurrencyController::class, 'researchNote']);


// BAG DETAILS
Route::get('/bags/{table}/{sellOrderSetting}/{tax}', [BagController::class, 'getTable']);