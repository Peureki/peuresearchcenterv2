<?php
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PasswordResetController;
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
// * EMAIL VERIFICATION
// *
Route::get('/email/verify', [EmailVerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.route');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'resendEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// *
// * PASSWORD RESETS
// *
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password/{token}', [PasswordResetController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.reset');



// *
// * CONFIRMATIONS
// *
Route::post('/item/confirm', [ConfirmationController::class, 'confirmItem']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');




