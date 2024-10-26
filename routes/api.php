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
use Illuminate\Support\Facades\Log;
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

// *
// * USER DATA
// *
Route::post('/user/enterAPIKey', [UserController::class, 'enterAPIKey']);
Route::post('/user/saveChecklist', [UserController::class, 'saveChecklist']);
Route::get('/user/getChecklist', [UserController::class, 'getChecklist']);

Route::post('/user/saveIncludes', [UserController::class, 'saveIncludes']);
Route::get('/user/getIncludes', [UserController::class, 'getIncludes']);

Route::post('/user/saveSettings', [UserController::class, 'saveSettings']);
Route::get('/user/getUserData', [UserController::class, 'getUserData']);

Route::post('/user/saveFilterResearchNotes', [UserController::class, 'saveFilterResearchNotes']);

Route::post('/user/saveFavorites', [UserController::class, 'saveFavorites']);

Route::get('/user/getFilters', [UserController::class, 'getFilters']);
Route::post('/user/saveFilters', [UserController::class, 'saveFilters']);

Route::post('/user/saveTheme', [UserController::class, 'saveTheme']);




// *
// * FETCH GENERAL STUFF
// * Any small fetches, dump it in this function
Route::get('/fetch-general', [FetchController::class, 'fetchGeneral']);
// FETCH SPECIFIC ITEM ID
Route::get('/item/{id}', [FetchController::class, 'fetchItem']);

// *
// * FETCHING BENCHMARKS
// *
Route::get('/fetch-benchmarks', [FetchController::class, 'fetchBenchmarks']);

Route::get('/fetch-items', [FetchController::class, 'fetchItems']);
Route::get('/fetch-currencies', [FetchController::class, 'fetchCurrencies']);
Route::get('/fetch-prices', [FetchController::class, 'fetchPrices']);
Route::get('/fetch-research-notes', [FetchController::class, 'fetchResearchNotes']);
Route::get('/fetch-recipes', [FetchController::class, 'fetchRecipes']);
Route::get('/fetch-recipe-values', [FetchController::class, 'fetchRecipeValues']);
// *
// * FETCHING DAILY CATCH
// *
Route::get('/fetch-daily-catch', [FetchController::class, 'fetchDailyCatch']);


// *
// * FETCHING BAGS, CHOICE CHESTS
// *
Route::get('/fetch-bags', [FetchController::class, 'fetchBags']);
// *
// * FETCH SALVAGEABLES
// *
Route::get('/fetch-salvageables', [FetchController::class, 'fetchSalvageables']);
Route::get('/fetch-mixed-salvageables', [FetchController::class, 'fetchMixedSalvageables']);

Route::get('/fetch-fishes', [FetchController::class, 'fetchFishes']);
Route::get('/fetch-fishing-holes', [FetchController::class, 'fetchFishingHoles']);

Route::get('/fetch-consumables', [FetchController::class, 'fetchConsumables']);
Route::get('/fetch-exotics', [FetchController::class, 'fetchExotics']);
// *
// * FETCH NODES
// *
Route::get('/fetch-nodes', [FetchController::class, 'fetchNodes']);
Route::get('/fetch-node-combinations', [FetchController::class, 'fetchNodeCombinations']);

// *
// * TOOLS
// *
// GET REFINED MATERIALS
Route::get('/refine/{request}/{requestID}/{buyOrderSetting}/{tax}', [RefineController::class, 'refine']);
// GET RECIPE VALUES
Route::get('/recipes/{request}/{id}/{quantity}', [RecipeController::class, 'getRecipeValues']);
// GET RECIPE TREE
Route::get('/recipes/{id}/{quantity}', [RecipeController::class, 'getRecipeTree']);
// SEARCH ITEMS
Route::get('/tools/search-items/{quantity}', [FetchController::class, 'searchItems']);
// SEARCH RECIPES
Route::get('/recipes/search-recipes', [RecipeController::class, 'searchRecipes']);
// SALVAGEABLES
Route::get('/tools/salvageables/{sellOrderSetting}/{tax}', [SalvageableController::class, 'salvageables']);
// MIXED SALVAGEABLES
Route::get('/tools/mixed-salvageables/{includes}/{sellOrderSetting}/{tax}', [SalvageableController::class, 'mixedSalvageables']);




// * SPIRIT SHARDS
Route::get('/currencies/spirit-shards/{buyOrderSetting}/{sellOrderSetting}/{tax}', [CurrencyController::class, 'getSpiritShards']);
// *
// * GENERAL CURRENCIES
// *
// Route::get('/currencies/{filter}/{includes}/{sellOrderSetting}/{tax}', [CurrencyController::class, 'currencies']);

// *
// * EXCHANGEABLES
// *
Route::get('/exchangeables/{request}/{includes}/{sellOrderSetting}/{tax}', [BagController::class, 'exchangeables']);




// * RESEARCH NOTES
Route::get('/currencies/salvage-research-notes/{buyOrderSetting}/{sellOrderSetting}/{tax}', [CurrencyController::class, 'salvageResearchNotes']);


Route::get('/currencies/research-note/{buyOrderSetting}/{filter}/{material}', [CurrencyController::class, 'researchNote']);
Route::get('/currencies/favorite-research-note/{buyOrderSetting}/{favorites}', [CurrencyController::class, 'favoriteResearchNote']);


// BAG DETAILS
Route::get('/bags/{table}/{sellOrderSetting}/{tax}', [BagController::class, 'getTable']);


// MERP TESTING
Route::get('/merp/fetch-merp', [FetchController::class, 'fetchMerp']);
Route::get('/merp', [FetchController::class, 'merp']);
Route::get('/fetch-derp', [FetchController::class, 'fetchDerp']);

// *
// * GET BENCHMARKS
// *
Route::get('/benchmarks/maps/{includes}/{filter}/{sellOrderSetting}/{tax}', [BenchmarkController::class, 'maps']);

Route::get('/benchmarks/fishing/{includes}/{buyOrderSetting}/{sellOrderSetting}/{tax}', [BenchmarkController::class, 'fishing']);


Route::get('/benchmarks/glyphs/{includes}/{sellOrderSetting}/{tax}', [BenchmarkController::class, 'glyphs']);

Route::get('/benchmarks/nodes/{includes}/{sellOrderSetting}/{tax}', [BenchmarkController::class, 'nodes']);

// ESTIMATED NODE BENCHMARKS
Route::get('/benchmarks/node-farms/{filters}/{includes}/{sellOrderSetting}/{tax}', [BenchmarkController::class, 'nodeFarms']);

// OTHER RECIPES
Route::get('/fetch-other-recipes', [FetchController::class, 'fetchOtherRecipes']);