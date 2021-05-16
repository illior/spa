<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notice;
use App\Models\Relationship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Events\SendNotice;

class UserController extends Controller
{
	protected $actions = [
		'getById' => 'getUserById',
		'getByLink' => 'getUserByLink',
		'update' => 'updateName',
		'follow' => 'followUser',
		'unfollow' => 'unfollowUser',
		'getNotices' => 'notices',
		'readAllNotices' => 'readNotices',
		'getFollowers' => 'getFollowers',
		'getFollowings' => 'getFollowings'
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
		$validator = Validator::make($request->all(), [
			'id' => 'required|integer',
		]);

		if($validator->fails()){
			$error = $validator->errors()->first();

			return response(['status' => false, 'message' => $error], '400');
		}

		$user = Auth::user();

		if($user->id == $request->id) {
			return response(['status' => false, 'message' => 'Wrong id'], '400');
		}

		if (!$user->follow($request->id)) {
			return response(['status' => false]);
		}

		$notice = Notice::create([
			'from_user_id' => $user->id,
			'to_user_id' => $request->id,
			'message' => 'follow you'
		]);

		broadcast(new SendNotice($notice, $user))->toOthers();

		return response(['status' => true]);
	}

	public function unfollowUser(Request $request) {
		$user = Auth::user();
		$followingUser = User::find($request->id);

		$user->decrement('followings');

		Relationship::where([
			'follower_id' => $user->id,
			'following_id' => $followingUser->id
		])->delete();

		$followingUser->decrement('followers');

		return response(['status' => true]);
	}

	public function notices(Request $request) {
		$notices = Auth::user()->toNotices()->limit(20)->get()->toArray();// dd($notices);

		foreach ($notices as $key => $notice) {
			$user = User::find($notice['from_user_id']);
			$notices[$key]['name'] = $user->name;
			$notices[$key]['photo'] = $user->photo;
		}

		return response(['status' => true, 'notices' => $notices], 200);
	}

	public function readNotices(Request $request) {
		Notice::where('to_user_id', Auth::user()->id)->update(['visited' => true]);

		return response(['status' => true], 200);
	}

	public function athenticated(Request $request) {
		$user = Auth::user()->toArray();

		$followers = Relationship::where('following_id', $user['id'])->pluck('follower_id');

		$followings = Relationship::where('follower_id', $user['id'])->pluck('following_id');

		return response(['status' => true, 'user' => $user, 'relationship' => [
			'followers' => $followers,
			'followings' => $followings
		]]);
	}

	public function getFollowers(Request $request) {
		$validator = Validator::make($request->all(), [
			'id' => 'required|integer',
		]);

		if($validator->fails()){
			$error = $validator->errors()->first();

			return response(['status' => false, 'message' => $error], '400');
		}

		$followers = User::find($request->id)->getFollowers()->get();

		return response(['status' => true, 'followers' => $followers]);
	}

	public function getFollowings(Request $request) {
		$validator = Validator::make($request->all(), [
			'id' => 'required|integer',
		]);

		if($validator->fails()){
			$error = $validator->errors()->first();

			return response(['status' => false, 'message' => $error], '400');
		}

		$followings = User::find($request->id)->getFollowings()->get();

		return response(['status' => true, 'followings' => $followings]);
	}
}
