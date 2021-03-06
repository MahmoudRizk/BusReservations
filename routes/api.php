<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OperationsController;

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


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/reservations', [OperationsController::class, 'create_reservation']);
    
    // Requires Admin role.
    Route::post('/cities', [OperationsController::class, 'create_city']);
    Route::put('/cities/{id}', [OperationsController::class, 'update_city']);
    Route::post('cities/swap-orders/{id1}/{id2}', [OperationsController::class, 'swap_cities_orders']);
    Route::post('/trips', [OperationsController::class, 'create_trip']);
});

// Public API, doesn't require authentication.
Route::get('/cities', [OperationsController::class, 'get_city']);
Route::get('/cities/{id}', [OperationsController::class, 'get_city']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/trips', [OperationsController::class, 'get_trips']);

Route::post('/reservations/check', [OperationsController::class, 'check_reservation_availability']);
