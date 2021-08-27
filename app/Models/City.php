<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'state_id'
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
    public function state()
    {
       return $this->belongsTo(\App\Models\State::class, 'state_id');
    }
}
