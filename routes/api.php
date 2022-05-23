<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;

Route::controller(UserController::class)->group(function(){
	Route::post('/register', 'register')->name('register');
	Route::post('/login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function() {
	Route::post('/logout', [UserController::class, 'logout']);

	Route::group([
		'prefix' => 'products',
	], function () {
		Route::get('/', [ProductsController::class, 'index']);
		Route::post('/store', [ProductsController::class, 'store']);
		Route::get('/edit/{id}', [ProductsController::class, 'edit']);
		Route::put('/update', [ProductsController::class, 'update']);
		Route::delete('/delete/{id}', [ProductsController::class, 'destroy']);
	});
});
