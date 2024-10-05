<?php

use App\Http\Controllers\BagController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware' => ['web']], function () {
//     // your routes here
// });

Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/register', [LoginController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout']);

// *
// * CONFIRMATIONS
// *
Route::post('/item/confirm', [ConfirmationController::class, 'confirmItem']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');




