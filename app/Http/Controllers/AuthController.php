<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
	public function login(Request $request) {
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);

		if($validator->fails()){
			$error = $validator->errors()->first();

			return response(['status' => false, 'message' => $error], '200');
		}

		if(!Auth::attempt($request->all())){
			return response(['status' => false, 'message' => 'Wrong email or password'], '200');
		}

		$user = Auth::user();

		$user->createToken('API Token');

		return response([
			'status' => true,
			'message' => '',
			'user' => $user->toArray()
		],
		'200');
	}

	public function register(Request $request) {
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:64|min:3',
			'email' => 'required|email|string|unique:users',
			'password' => 'required|confirmed|min:3'
		]);

		if($validator->fails()){
			$error = $validator->errors()->first();

			return response(['status' => false, 'message' => $error], '200');
		}

		$user = User::register([
			'name' => $request->name,
			'password' => bcrypt($request->password),
			'email' => $request->email
		]);

		Auth::login($user);

		$user->createToken('API Token');

		return response([
			'status' => true,
			'message' => '',
			'user' => $user->toArray()
		],
		'200');
	}

	public function logout(Request $request){
		Auth::user()->tokens()->delete();
		Auth::guard('web')->logout();

		return response(['stasus' => 'true'], '200');
	}
}
