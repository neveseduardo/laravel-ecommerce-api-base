<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'address_number',
        'complement',
        'district',
        'zip_code',
        'city_id',
        'user_id'
    ];

    public function user()
    {
       return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }
}
