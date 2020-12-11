<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'photo',        
        'title',             
        'content',             
        'active',             
        'review_id',      
        'share',          
        'etc'                 
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Report');
    }
}
