<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\StoreStatisticController;
use App\Http\Controllers\Api\RentalHistoryController;
use App\Http\Controllers\Api\StoreRevenueController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('/posts', App\Http\Controllers\Api\PostsController::class);
Route::apiResource('/store/store-statistic', App\Http\Controllers\Api\StoreStatisticController::class);
Route::apiResource('/customer/rental-history', App\Http\Controllers\Api\RentalHistoryController::class);
Route::apiResource('/store/store-revenue', App\Http\Controllers\Api\StoreRevenueController::class);
