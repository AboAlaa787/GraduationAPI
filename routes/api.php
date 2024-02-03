<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\CompletedDeviceController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UsersServicesController;
use App\Models\Center;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/users', UsersServicesController::class);
/*Route::post('/users/create', [UsersServicesController::class, 'store']);
Route::post('/users/login', [UsersServicesController::class, 'login'])
    ->middleware('guest')
    ->name('login');
Route::get('/center/{id}',function ($id){
    $center=\App\Models\Center::find($id);
    return response()->json(['users'=>$center->services]);
});*/
Route::controller(CenterController::class)->group(function () {
    Route::get('/center', 'index');
    Route::post('/center/store', 'store');
    Route::post('/center/update/{id}', 'update');
    Route::post('/center/distroy/{id}', 'distroy');
});
Route::controller(ClientController::class)->group(function () {
    Route::get('/client', 'index');
    Route::post('/client/store', 'store');
    Route::post('/client/update/{id}', 'update');
    Route::post('/client/distroy/{id}', 'distroy');
});
Route::controller(ServiceController::class)->group(function () {
    Route::get('/service', 'index');
    Route::post('/service/store', 'store');
    Route::post('/service/update/{id}', 'update');
    Route::post('/service/distroy/{id}', 'distroy');
});
Route::controller(RuleController::class)->group(function () {
    Route::get('/rule', 'index');
    Route::post('/rule/store', 'store');
    Route::post('/rule/update/{id}', 'update');
    Route::post('/rule/distroy/{id}', 'distroy');
});
Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index');
    Route::post('/product/store', 'store');
    Route::post('/product/update/{id}', 'update');
    Route::post('/product/distroy/{id}', 'distroy');
});
Route::controller(PermissionController::class)->group(function () {
    Route::get('/permission', 'index');
    Route::post('/permission/store', 'store');
    Route::post('/permission/update/{id}', 'update');
    Route::post('/permission/distroy/{id}', 'distroy');
});
Route::controller(OrderController::class)->group(function () {
    Route::get('/order', 'index');
    Route::post('/order/store', 'store');
    Route::post('/order/update/{id}', 'update');
    Route::post('/order/distroy/{id}', 'distroy');
});
Route::controller(DeviceController::class)->group(function () {
    Route::get('/device', 'index');
    Route::post('/device/store', 'store');
    Route::post('/device/update/{id}', 'update');
    Route::post('/device/distroy/{id}', 'distroy');
});
Route::controller(CompletedDeviceController::class)->group(function () {
    Route::get('/completed_device', 'index');
    Route::post('/completed_device/store', 'store');
    Route::post('/completed_device/update/{id}', 'update');
    Route::post('/completed_device/distroy/{id}', 'distroy');
});
