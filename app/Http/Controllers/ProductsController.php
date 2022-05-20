<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
	function index() {
		$products = \Auth::user()->products()->paginate(6);

		return response()->json($products);
	}

	function store(ProductRequest $request) {
		$product = new Products;

		// Todo: validation
		$validated = $request->validated();

		$product->title = $request->title;
		$product->image = $request->image;
		$product->price = $request->price;
		$product->description = $request->description;
		$product->featured = $request->has('featured');
		$product->quantity = $request->quantity;
		$product->user_id = auth()->user()->id;
		// $product->user_id = 1;

		$product->save();

		return response()->json('Successfully added');
	}

	public function edit($id) {
		$product = Products::findOrFail($id);

		return response()->json($product);
	}

	public function update(ProductRequest $request, $id) {
		$product = Products::findOrFail($id);

		// Todo: validation

		$product->title = $request->title;
		$product->image = $request->image;
		$product->price = $request->price;
		$product->description = $request->description;
		$product->featured = $request->has('featured');
		$product->quantity = $request->quantity;
		$product->user_id = auth()->user()->id;
		// $product->user_id = 1;

		$product->save();

		return response()->json('Successfully updated');
	}

	public function destroy($id) {
		$product = Products::find($id);
		$product->delete();

		return response()->json('Successfully deleted');
	}
}
