<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoctaionController;
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
Route::middleware(['auth:sanctum','role:owner'])
->group(function($route){
$route->controller(LoctaionController::class)->prefix('location')->group(function($route){
$route->post('/','create');
$route->put('/{id}','update');
$route->delete('/{id}','delete');
$route->get('/{id}','index');});
$route->controller(PropertyTypeController::class)->prefix('property-type')->group(function($route){
$route->get('/','get');});
});

