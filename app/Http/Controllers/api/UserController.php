<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	protected $actions = [
		'getById' => 'getUserById',
		'getByLink' => 'getUserByLink',
		'update' => 'updateName',
		'follow' => 'followUser'
	];

	public function getAction (Request $request) {
		$validator = Validator::make($request->all(), [
			'action' => 'required',
		]);

		if($validator->fails()){
			return response(['message' => 'Empty request'], '400');
		}

		$action = $this->actions[$request->action];

		$response = call_user_func_array([$this, $action], [$request]);

		return $response;
	}
	public function getUserById(Request $request) {
		$validator = Validator::make($request->all(), [
			'id' => 'required|integer',
		]);

		if($validator->fails()){
			return response([], '400');
		}

		$user = User::find($id);

		return response(['status' => true, 'user' => $user], '200');
	}

	public function getUserByLink(Request $request) {
		$validator = Validator::make($request->all(), [
			'link' => 'required|string',
		]);

		if($validator->fails()){
			return response([], '400');
		}

		$user = User::where('link', $request->link)->first();

		return response(['status' => true, 'user' => $user], '200');
	}

	public function updateName(Request $request) {
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|min:3',
		]);

		if($validator->fails()){
			$error = $validator->errors()->first();

			return response(['status' => false, 'message' => $error], '200');
		}

		$user = Auth::user();

		$user->name = $request->name;
		$user->save();

		return response(['status' => true, 'user' => $user], '200');
	}

	public function followUser(Request $request) {
		
	}

	public function athenticated(Request $request) {
		return response(['status' => true, 'user' => Auth::user()]);
	}
}
