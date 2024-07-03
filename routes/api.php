<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BrandCarController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ModelCarController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('brand', BrandCarController::class);
Route::apiResource('car', CarController::class);
Route::apiResource('costumer', CostumerController::class);
Route::apiResource('location', LocationController::class);
Route::apiResource('modelCar', ModelCarController::class);