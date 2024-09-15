<?php

use App\Http\Controllers\BagController;
use App\Http\Controllers\BenchmarkController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\FetchController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RefineController;
use App\Http\Controllers\SalvageableController;
use App\Http\Controllers\UserController;
use App\Jobs\Fetches\FetchItems;
use App\Models\Currencies;
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
Route::post('/user/saveChecklist', [UserController::class, 'saveChecklist']);
Route::get('/user/getChecklist', [UserController::class, 'getChecklist']);

Route::post('/user/saveIncludes', [UserController::class, 'saveIncludes']);
Route::get('/user/getIncludes', [UserController::class, 'getIncludes']);

Route::post('/user/saveSettings', [UserController::class, 'saveSettings']);
Route::get('/user/getUserData', [UserController::class, 'getUserData']);

Route::post('/user/saveFilterResearchNotes', [UserController::class, 'saveFilterResearchNotes']);

// *
// * FETCH GENERAL STUFF
// * Any small fetches, dump it in this function
Route::get('/fetch-general', [FetchController::class, 'fetchGeneral']);

// *
// * BENCHMARKS
// *
Route::get('/fetch-benchmarks', [FetchController::class, 'fetchBenchmarks']);

Route::get('/fetch-items', [FetchController::class, 'fetchItems']);
Route::get('/fetch-currencies', [FetchController::class, 'fetchCurrencies']);
Route::get('/fetch-prices', [FetchController::class, 'fetchGeneral']);
Route::get('/fetch-research-notes', [FetchController::class, 'fetchResearchNotes']);
Route::get('/fetch-recipes', [FetchController::class, 'fetchRecipes']);
Route::get('/fetch-recipe-trees', [FetchController::class, 'fetchRecipeTrees']);
Route::get('/fetch-recipe-values', [FetchController::class, 'fetchRecipeValues']);

Route::get('/fetch-bags', [FetchController::class, 'fetchBags']);
Route::get('/fetch-choice-chests', [FetchController::class, 'fetchChoiceChests']);
// *
// * SALVAGEABLES
// *
Route::get('/fetch-salvageables', [FetchController::class, 'fetchSalvageables']);
Route::get('/fetch-mixed-salvageables', [FetchController::class, 'fetchMixedSalvageables']);

Route::get('/fetch-fishes', [FetchController::class, 'fetchFishes']);
Route::get('/fetch-fishing-holes', [FetchController::class, 'fetchFishingHoles']);

Route::get('/fetch-consumables', [FetchController::class, 'fetchConsumables']);
Route::get('/fetch-exotics', [FetchController::class, 'fetchExotics']);

Route::get('/fetch-map-benchmarks', [FetchController::class, 'fetchMapBenchmarks']);

// *
// * BENCHMARKS
// *
Route::get('/benchmarks/fishing/{includes}/{buyOrderSetting}/{sellOrderSetting}/{tax}', [BenchmarkController::class, 'fishing']);
Route::get('/benchmarks/maps/{includes}/{sellOrderSetting}/{tax}', [BenchmarkController::class, 'maps']);

// *
// * TOOLS
// *
Route::get('/refine/{request}/{requestID}/{buyOrderSetting}/{tax}', [RefineController::class, 'refine']);

Route::get('/recipes/{request}/{id}/{quantity}', [RecipeController::class, 'getRecipeValues']);
Route::get('/recipes/{id}/{quantity}', [RecipeController::class, 'getRecipeTree']);

Route::get('/tools/search-items/{quantity}', [FetchController::class, 'searchItems']);
Route::get('/recipes/search-recipes', [RecipeController::class, 'searchRecipes']);





// * SPIRIT SHARDS
Route::get('/currencies/spirit-shards/{buyOrderSetting}/{sellOrderSetting}/{tax}', [CurrencyController::class, 'getSpiritShards']);
// *
// * GENERAL CURRENCIES
// *
Route::get('/currencies/{filter}/{includes}/{sellOrderSetting}/{tax}', [CurrencyController::class, 'currencies']);

// *
// * EXCHANGEABLES
// *
Route::get('/exchangeables/{request}/{includes}/{sellOrderSetting}/{tax}', [BagController::class, 'exchangeables']);




// * RESEARCH NOTES
Route::get('/currencies/salvage-research-notes/{buyOrderSetting}/{sellOrderSetting}/{tax}', [CurrencyController::class, 'salvageResearchNotes']);


Route::get('/currencies/research-note/{buyOrderSetting}/{filter}', [CurrencyController::class, 'researchNote']);


// BAG DETAILS
Route::get('/bags/{table}/{sellOrderSetting}/{tax}', [BagController::class, 'getTable']);




// MERP TESTING
Route::get('/merp/fetch-merp', [FetchController::class, 'fetchMerp']);