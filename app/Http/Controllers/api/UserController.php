<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function getUser(Request $request) {
		if ($request->link == null || $request->id == null) {
			return response(['status' => false, 'message' => 'Empty request'], '400');
		}

		$user = User::where('link', $request->link)->first();

		return response(['status' => true, 'user' => $user], '200');
	}

	public function athenticated(Request $request) {
		return response(['status' => true, 'user' => Auth::user()]);
	}
}
