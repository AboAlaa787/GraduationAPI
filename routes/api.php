<?php

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/users',UsersServicesController::class);
/*Route::post('/users/create', [UsersServicesController::class, 'store']);
Route::post('/users/login', [UsersServicesController::class, 'login'])
    ->middleware('guest')
    ->name('login');
Route::get('/center/{id}',function ($id){
    $center=\App\Models\Center::find($id);
    return response()->json(['users'=>$center->services]);
});*/
