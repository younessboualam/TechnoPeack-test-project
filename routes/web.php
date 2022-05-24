<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('{any}', function () {
	return view('index');
})->where('any', '.*');