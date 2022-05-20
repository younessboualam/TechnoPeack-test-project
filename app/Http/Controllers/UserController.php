<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
	function login(Request $request) {
		$credentials = [
			'email' => $request->email,
			'password' => $request->password,
		];

		if (!Auth::attempt($credentials)) {
			return response()->json([
				'message' => 'Invalid login details'
			], 401);
		}

		$user = User::where('email', $request['email'])->firstOrFail();
		$token = $user->createToken('authToken')->plainTextToken;

		return response()->json([
			'user' => $user,
			'access_token' => $token,
			'token_type' => 'Bearer',
		]);
	}

	function register(Request $request) {
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:8',
		]);
		
		if ($validator->fails()) {
			$errors = $validator->errors();
			
			return response()->json([
				'error' => $errors
			], 400);
		}

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
		]);

		$token = $user->createToken('authToken')->plainTextToken;

		return response()->json([
			'user' => $user,
			'access_token' => $token,
			'token_type' => 'Bearer',
		]);
	}

	public function logout(Request $request) {
		auth()->user()->tokens()->delete();
		return response()->json('Logged out');
	}


	public function details(Request $request) { 
		$user = Auth::user(); 

		//  'headers' => [
		//  'Accept' => 'application/json',
		//  'Authorization' => 'Bearer '.$accessToken,
		// ],
		$token = $request->post('/oauth/token', [
			'content-type' => 'application/json',
			'Accept' => 'application/json',
			'Authorization' => 'Bearer '.'mahgf1234567890',
		]);
		//$token=$request->header('Authorization');


		return response()->json(['success' => $user,'token' => $token], $this-> successStatus); 
	}
}
