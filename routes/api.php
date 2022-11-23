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

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('throttle:3,1')->group(function () {
    Route::post('auth/login', \App\Http\Controllers\LoginController::class);
    Route::post('auth/register', \App\Http\Controllers\RegisterController::class);
});

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json();
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');
