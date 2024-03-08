<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductOrderController;
use App\Http\Controllers\DevicesOrdersController;
use App\Http\Controllers\PermissionRuleController;
use App\Http\Controllers\PermissionUserController;
use App\Http\Controllers\CompletedDeviceController;
use App\Http\Controllers\PermissionClientController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::resource('/login', AuthenticatedSessionController::class)->middleware('guest');


Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/user', static function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::resource('/users', UserController::class);

    Route::post('refresh_token', [AuthenticatedSessionController::class, 'refresh_token']);

    Route::resource('/clients', ClientController::class);

    Route::resource('/centers', CenterController::class);

    Route::resource('/services', ServiceController::class);

    Route::resource('/rules', RuleController::class);

    Route::resource('/products', ProductController::class);

    Route::resource('/permissions', PermissionController::class);

    Route::resource('/orders', OrderController::class);

    Route::resource('/devices', DeviceController::class);

    Route::resource('/customers', CustomerController::class);

    Route::resource('/completed_devices', CompletedDeviceController::class);

    Route::resource('/permission_users', PermissionUserController::class);

    Route::resource('/permission_clients', PermissionClientController::class);

    Route::resource('/permission_rules', PermissionRuleController::class);

    Route::resource('/devices_orders', DevicesOrdersController::class);

    Route::resource('/product_orders', ProductOrderController::class);
});
