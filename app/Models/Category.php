<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

	protected $fillable = [
		'name',
		'description',
		'active',
		'user_id'
	];

	public function products () {
		$instance = $this->hasMany(\App\Models\Product::class);
		$instance->getQuery()->where('active', 1)->get();
		return $instance;
	}

	public function user () {
		return $this->belongsTo(\App\Models\User::class, 'user_id');
	}
}
