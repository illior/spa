<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'link',
		'photo'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password'
	];

	public static function register($arr) {
		$arr['link'] = Str::random(10);
		$arr['photo'] = 'no.png';
		$user = self::create($arr);

		$user->link = 'id'.$user->id;
		$user->save();

		return $user;
	}

	public function toNotices() {
		return $this->hasMany('App\Models\Notice', 'to_user_id');
	}

	public function fromNotices() {
		return $this->hasMany('App\Models\Notice', 'from_user_id');
	}

	public function getFollowers() {
		return $this->belongsToMany(self::class, 'relationships', 'following_id', 'follower_id');
	}

	public function getFollowings() {
		return $this->belongsToMany(self::class, 'relationships', 'follower_id', 'following_id');
	}

	public function follow($id) {
		$relationship = Relationship::where(['follower_id' => $this->id, 'following_id' => $id])->first();

		if ($relationship != null) {
			return false;
		}

		Relationship::create([
			'follower_id' => $this->id,
			'following_id' => $id
		]);

		$this->followings++;
		$this->save();

		$user = self::find($id);
		$user->followers++;
		$user->save();


		return true;
	}
}
