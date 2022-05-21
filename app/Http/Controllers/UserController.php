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
			return response()->json(['errors' => 'Invalid login credentials']);
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
			'name' => 'required|string|min:8',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:8',
		]);
		
		if ($validator->fails()) {
			$errors = $validator->errors();
			
			return response()->json([
				'errors' => $errors
			]);
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
		$request->session()->flush();
		Auth::user()->tokens()->delete();
		return response()->json('Logged out');
	}
}
