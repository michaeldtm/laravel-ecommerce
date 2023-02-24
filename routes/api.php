<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\MarketplaceController;
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

Route::get('marketplace', MarketplaceController::class)->name('marketplace');
Route::get('marketplace/products/{product}', [ProductController::class, 'show']);

Route::get('marketplace/cart', [CartController::class, 'index']);
Route::get('marketplace/cart/{cart}', [CartController::class, 'show']);
Route::post('marketplace/cart', [CartController::class, 'store']);
Route::delete('marketplace/cart/{cart}', [CartController::class, 'destroy']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('user')->group(function () {
        Route::apiResource('address', UserAddressController::class)->names('user_address');
    });

    Route::apiResource('products', ProductController::class)->names('products');
});
