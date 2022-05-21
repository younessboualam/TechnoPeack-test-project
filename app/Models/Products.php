<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Products extends Model
{
	use HasFactory;

	protected $fillable = ['user_id', 'title', 'price', 'quantity'];

	function user() {
		return $this->belongsTo(User::class);
	}
}
