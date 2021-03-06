<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;

Route::controller(
	UserController::class
)->group(function(){
	Route::post('/register', 'register')->name('register');
	Route::post('/login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function() {
	Route::post('/logout', [UserController::class, 'logout']);

	Route::controller(
		ProductsController::class
	)
		->prefix('products')
		->group(
			function () {
				Route::get('/', 'index');
				Route::get('/{id}', 'show');
				Route::post('/store', 'store');
				Route::get('/edit/{id}', 'edit');
				Route::post('/update', 'update');
				Route::put('/update/{id}', 'inlineEdit');
				Route::delete('/delete/{id}', 'destroy');
			}
		);
});
