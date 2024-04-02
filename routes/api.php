<?php

use App\Http\Controllers\Erp\SalesOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoryController;
use App\Http\Controllers\ManageUserController;
use App\Http\Controllers\MobileHandlerController;
use App\Http\Controllers\PriceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('mobile')->group(function () {
    Route::post('/receive-ktp-image', [MobileHandlerController::class, 'uploadKtpImage']);
    Route::post('/receive-product-image', [MobileHandlerController::class, 'uploadProductImage']);
    Route::post('/receive-pembukuan-image', [MobileHandlerController::class, 'uploadAccountancyImage']);
    Route::post('/receive-payment-method-image', [MobileHandlerController::class, 'uploadPaymentMethodImage']);
});

Route::prefix('ajax')->group(function () {
    Route::put('/prices/{id}', [PriceController::class, 'ajaxEdit']);
});

Route::prefix('rpk')->group(function () {
    Route::post('/so/create/order-line', [SalesOrderController::class, 'createOrderLine']);
});
