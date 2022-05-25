<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
// use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Products;

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

		$product = Products::create([
			'title' => $request->title,
			'image' => $request->image,
			'price' => $request->price,
			'category' => $request->category,
			'colour' => $request->colour,
			'description' => $request->description,
			'featured' => $request->has('featured'),
			'quantity' => $request->quantity,
			'user_id' => \Auth::user()->id
		]);

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
		foreach ($request->all() as $key => $data) {
			$validator = Validator::make($data, [
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

			$product = Products::findOrFail($data['id']);
			$product->title = $data['title'];
			$product->image = $data['image'];
			$product->price = $data['price'];
			$product->colour = $data['colour'];
			$product->category = $data['category'];
			$product->description = $data['description'];
			$product->featured = $data['featured'];
			$product->quantity = $data['quantity'];
			$product->user_id = \Auth::user()->id;

			$product->save();
		}
		

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
