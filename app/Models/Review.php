<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'recipe_id',        
        'content',             
        'etc'                 
    ];

    public function receipe()
    {
        return $this->belongsTo('App\Models\User');
    }
}
