<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'initials',
        'user_id'
    ];
    
    /**  
     * 
     * Get the association with User
     * 
     * @return array
    */
    public function user()
    {
       return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**  
     * 
     * Get the association with State
     * 
     * @return array
    */
    public function cities()
    {
       return $this->hasMany(\App\Models\City::class);
    }
}
