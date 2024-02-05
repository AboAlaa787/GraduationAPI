<?php

use App\Http\Controllers\CenterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompletedDeviceController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UsersServicesController;
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

Route::post('users/login', [UsersServicesController::class, 'login'])->name('login');

Route::get('/not_authenticated', function () {
    return response()->json(['message' => 'Unauthenticated']);
})->name('not_authenticated');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('/users', UsersServicesController::class);

    Route::resource('/centers', CenterController::class);

    Route::resource('/services', ServiceController::class);

    Route::resource('/rules', RuleController::class);

    Route::resource('/clients', ClientController::class);

    Route::resource('/products', ProductController::class);

    Route::resource('/permissions', PermissionController::class);

    Route::resource('/orders', OrderController::class);

    Route::resource('/devices', DeviceController::class);

    Route::resource('/completed_devices', CompletedDeviceController::class);
});
