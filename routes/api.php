<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoctaionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewReplayController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->middleware('lang')->prefix('auth')->group(function($route){
$route->post('register','register');
$route->post('login','login');
$route->post('verify','verify')->middleware(['auth:sanctum']);
$route->middleware(['auth:sanctum','active',VerifyEmail::class])->get('me','me');
$route->middleware(['auth:sanctum','active',VerifyEmail::class])->post('logout','logout');
$route->middleware(['auth:sanctum','active',VerifyEmail::class])->post('update-info','updateInfo');
});
//public
Route::middleware(['auth:sanctum','active','lang'])->group(function() {
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
        Route::get('/filter', 'filter');
        Route::get('/suggestion/{categoryId}', 'suggestion');
        Route::get('/{id}', 'getById');

    });
    // Categories
    Route::controller(CategoryController::class)->prefix('category')->group(function() {
        Route::get('/', 'get');
        Route::get('/{id}', 'getById');
    });
    Route::controller(AppointmentController::class)->prefix('appointment')->group(function() {
        Route::get('/', 'get');
        Route::get('/filter', 'filter');
        Route::get('/{id}', 'getById');

    });
    Route::controller(ReviewController::class)->prefix('review')->group(function($route){
        $route->get('/property/{id}','index');
        $route->get('/{id}','show');
    });
    Route::controller(ReviewReplayController::class)->prefix('review-replay')->group(function($route){
       $route->post('/','create');
       $route->put('/{id}','update');
       $route->delete('/{id}','delete');
    });
});
//owner
Route::middleware(['auth:sanctum','active','role:owner','lang'])
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
$route->put('/change-status/{id}','changeStatus');
});
$route->controller(AppointmentController::class)->prefix('appointment')->group(function($route){
$route->put('/cancel/{id}','cancel');
});
});
//customer
Route::middleware(['auth:sanctum','active','role:customer','lang'])->group(function($route){
    $route->controller(AppointmentController::class)->prefix('appointment')->group(function($route){
        $route->post('/','create');
        $route->put('/{id}','update');
        $route->delete('/{id}','delete');
    });
    $route->controller(ReportController::class)->prefix('report')->group(function($route){
        $route->post('/','create');
        $route->put('/{id}','update');
        $route->delete('/{id}','destroy');
    });
    $route->controller(ReviewController::class)->prefix('review')->group(function($route){
       $route->post('/','create');
       $route->put('/{id}','update');
       $route->delete('/{id}','destroy');
    });
});
//admin || customer
Route::middleware(['auth:sanctum','active','role:admin|customer','lang'])->group(function($route){
    $route->controller(ReportController::class)->prefix('report')->group(function($route){
        $route->get('/','index');
        $route->get('/{id}','show');
    });
});
//admin
Route::middleware(['auth:sanctum','role:admin','lang'])->group(function($route){
    $route->controller(PropertyController::class)->prefix('property')->group(function($route){
        $route->put('/active/{id}','active');
    });
    $route->controller(UserController::class)->prefix('user')->group(function($route){
        $route->post('/','create');
        $route->post('/{id}','update');
        $route->delete('/{id}','delete');
        $route->get('/{id}','getById');
        $route->get('/','getAll');
        $route->put('/change-active/{id}','changeActiveStatus');
    });
    $route->controller(PaymentController::class)->prefix('payment')->group(function($route){
        $route->get('/filter','filterPayments');
        $route->get('/{id}','getPaymentById');
        $route->get('/','getAllPayments');

    });
});


