<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{

	// function details(Request $request) { 
	// 	$user = auth()->user();

	// 	$token = $user->createToken('authToken')->plainTextToken;

	// 	return $client->request('POST', '/api/user', [
	// 		'headers' => [
	// 			'Authorization' => 'Bearer '.$token,
	// 			'Accept' => 'application/json',
	// 		],
	// 	]);
	// }

	function index() {
		dd(auth()->user());
		$products = auth()->user()->products()->get();

		return response()->json($products);
	}

	function store(Request $request) {
		$product = new Product;

		$product->title = $request->product_name;
		$product->image = $request->product_image;
		$product->price = $request->product_price;
		$product->description = $request->product_description;
		$product->featured = $request->has('product_featured');
		$product->old_price = $request->product_old_price;
		$product->quantity = $request->product_quantity;
		$product->user_id = auth()->user()->id;

		$product->save();

		return response()->json('Successfully added');
	}

	public function edit($id) {
		$product = Product::findOrFail($id);

		return response()->json($product);
	}

	public function update(Request $request, $id) {
		$product = Product::findOrFail($id);

		$product->title = $request->product_name;
		$product->image = $request->product_image;
		$product->price = $request->product_price;
		$product->description = $request->product_description;
		$product->featured = $request->has('product_featured');
		$product->old_price = $request->product_old_price;
		$product->quantity = $request->product_quantity;
		$product->user_id = auth()->user()->id;

		$product->save();

		return response()->json('Successfully updated');
	}

	public function destroy($id) {
		$product = Product::find($id);
		$product->delete();

		return response()->json('Successfully deleted');
	}
}
