<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
// use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
	function index() {
		$products = \Auth::user()->products()->paginate(1);

		return response()->json($products);
	}

	function store(Request $request) {
		$validator = Validator::make($request->all(), [
	      'title' => 'required',
   	   'price' => 'required|numeric',
      	'quantity' => 'required|numeric'
		]);

		if ($validator->fails()) {
			$errors = $validator->errors();
			
			return response()->json([
				'errors' => $errors
			]);
		}

		$product = Products::create([
			'title' => $request->title,
			'image' => $request->image,
			'price' => $request->price,
			'description' => $request->description,
			'featured' => $request->has('featured'),
			'quantity' => $request->quantity,
			'user_id' => \Auth::user()->id
		]);

		return response()->json('Successfully added');
	}

	public function edit($id) {
		$product = Products::findOrFail($id);

		return response()->json($product);
	}

	public function update(Request $request, $id) {
		$validator = Validator::make($request->all(), [
	      'title' => 'required',
   	   'price' => 'required|numeric',
      	'quantity' => 'required|numeric'
		]);

		if ($validator->fails()) {
			$errors = $validator->errors();
			
			return response()->json([
				'errors' => $errors
			]);
		}

		$product = Products::findOrFail($id);
		$product->title = $request->title;
		$product->image = $request->image;
		$product->price = $request->price;
		$product->description = $request->description;
		$product->featured = $request->has('featured');
		$product->quantity = $request->quantity;
		$product->user_id = \Auth::user()->id;

		$product->save();

		return response()->json('Successfully updated');
	}

	public function destroy($id) {
		$product = Products::find($id);
		$product->delete();

		return response()->json('Successfully deleted');
	}
}
