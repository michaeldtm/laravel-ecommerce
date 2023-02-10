<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserAddressController;
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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('user')->group(function () {
        Route::apiResource('address', UserAddressController::class)->names('user_address');
    });

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::post('products', [ProductController::class, 'store'])->name('products.store');
});
