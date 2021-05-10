<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
	use HasFactory;

	protected $fillable = [
		'from_user_id',
		'to_user_id',
		'message'
	];

	public function from()
	{
		return $this->belongsTo('App\Models\User', 'from_user_id');
	}

	public function to()
	{
		return $this->belongsTo('App\Models\User', 'to_user_id');
	}
}
