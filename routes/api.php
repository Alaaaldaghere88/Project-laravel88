<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoctaionController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Middleware\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::controller(AuthController::class)->prefix('auth')->group(function($route){
$route->post('register','register');
$route->post('login','login');
$route->post('verify','verify')->middleware(['auth:sanctum']);
$route->middleware(['auth:sanctum','role:customer',VerifyEmail::class])->get('me','me');
$route->middleware(['auth:sanctum','role:customer',VerifyEmail::class])->post('logout','logout');
});
//public
Route::middleware('auth:sanctum')->group(function() {
    // Property Types
    Route::controller(PropertyTypeController::class)->prefix('property-type')->group(function() {
        Route::get('/', 'get');
        Route::get('/{id}', 'getById');
    });
    // Locations
    Route::controller(LoctaionController::class)->prefix('location')->group(function() {
        Route::get('/{id}', 'index');
    });
    // Properties
    Route::controller(PropertyController::class)->prefix('property')->group(function() {
        Route::get('/', 'get');
        Route::get('/{id}', 'getById');
    });
    // Categories
    Route::controller(CategoryController::class)->prefix('category')->group(function() {
        Route::get('/', 'get');
        Route::get('/{id}', 'getById');
    });
});
//owner
Route::middleware(['auth:sanctum','role:owner'])
->group(function($route){
$route->controller(LoctaionController::class)->prefix('location')->group(function($route){
$route->post('/','create');
$route->put('/{id}','update');
$route->delete('/{id}','delete');
});
$route->controller(PropertyController::class)->prefix('property')->group(function($route){
$route->post('/','create');
$route->put('/{id}','update');
$route->delete('/{id}','delete');
});
});

