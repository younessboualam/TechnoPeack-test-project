<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
	function index() {
		$products = \Auth::user()->products()->orderBy('id', 'DESC')->paginate(9);

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

		$product = new Products;
		$product->title = $request->title;
		$product->price = $request->price;
		$product->colour = $request->colour;
		$product->category = $request->category;
		$product->description = $request->description;
		$product->featured = $request->featured;
		$product->quantity = $request->quantity;
		$product->user_id = \Auth::user()->id;

		if($request->file('image')){

			$file = $request->file('image');
			$filename = date('YmdHi') . $file->getClientOriginalName();
			$file->move(public_path('images/products'), $filename);

			$product->image = $filename;
		}

		$product->save();

		return response()->json([
			'message' => 'Successfully added'
		]);
	}

	public function edit($id) {
		$ids = explode(',', $id);

		$products = Products::whereIn('id', $ids)->get();

		return response()->json($products);
	}

	public function show($id) {
		$product = Products::findOrFail($id);

		return response()->json($product);
	}

	public function inlineEdit(Request $request, $id) {
		Products::where('id', $id)->update($request->all());

		return response()->json([
			'message' => 'Successfully updated'
		]);
	}

	public function update(Request $request) {
		$inputs = $request->all();

		foreach ($inputs['id'] as $key => $value) {
			// $validator = Validator::make($inputs, [
			// 	'title' => 'required',
			// 	'price' => 'required|numeric',
			// 	'quantity' => 'required|numeric'
			// ]);

			// if ($validator->fails()) {
			// 	$errors = $validator->errors();
				
			// 	return response()->json([
			// 		'errors' => $errors
			// 	]);
			// }


			$product = Products::findOrFail($inputs['id'][$key]);
			$product->title = $inputs['title'][$key];
			$product->price = $inputs['price'][$key];
			$product->colour = $inputs['colour'][$key];
			$product->category = $inputs['category'][$key];
			$product->description = $inputs['description'][$key];
			$product->featured = $inputs['featured'][$key];
			$product->quantity = $inputs['quantity'][$key];
			$product->user_id = \Auth::user()->id;

			// if($request->file('image')){

			// 	$file = $request->file('image');
			// 	$filename = date('YmdHi') . $file->getClientOriginalName();
			// 	$file->move(public_path('images/products'), $filename);

			// 	$product->image = $filename;
			// }

			$product->save();
		}

		return response()->json($inputs);

		return response()->json([
			'message' => 'Successfully updated'
		]);
	}

	public function destroy($id) {
		$ids = explode(',', $id);

		foreach ($ids as $productId) {
			Products::find($productId)->delete();
		}

		return response()->json([
			'message' => 'Successfully deleted'
		]);
	}
}
