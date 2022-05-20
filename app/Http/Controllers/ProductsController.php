<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
	function index() {
		// $products = auth()->user()->products()->get();
		$products = Products::orderBy('created_at', 'desc')->get();

		return response()->json($products);
	}

	function store(Request $request) {
		$product = new Products;

		$product->title = $request->product_name;
		$product->image = $request->product_image;
		$product->price = $request->product_price;
		$product->description = $request->product_description;
		$product->featured = $request->has('product_featured');
		$product->quantity = $request->product_quantity;
		// $product->user_id = auth()->user()->id;
		$product->user_id = 1;

		$product->save();

		return response()->json('Successfully added');
	}

	public function edit($id) {
		$product = Products::findOrFail($id);

		return response()->json($product);
	}

	public function update(Request $request, $id) {
		$product = Products::findOrFail($id);

		$product->title = $request->title;
		$product->image = $request->image;
		$product->price = $request->price;
		$product->description = $request->description;
		$product->featured = $request->has('featured');
		$product->quantity = $request->quantity;
		// $product->user_id = auth()->user()->id;
		$product->user_id = 1;

		$product->save();

		return response()->json('Successfully updated');
	}

	public function destroy($id) {
		$product = Products::find($id);
		$product->delete();

		return response()->json('Successfully deleted');
	}
}
