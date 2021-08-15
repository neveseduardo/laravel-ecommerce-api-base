<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	protected $fillable = [
		'title',
		'description',
		'value',
		'quantity',
		'images',
		'discount',
		'cod_bars',
		'active',
		'user_id',
		'category_id'
	];

	public function user () {
		return $this->belongsTo(\App\Models\User::class, 'user_id')->select(['id', 'name', 'email']);
	}
	public function category () {
		return $this->belongsTo(\App\Models\Category::class, 'category_id');
	}
	public function likes () {
		return $this->hasMany(\App\Models\Like::class);
	}
}
