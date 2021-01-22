<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',        
        'content',             
        'done',             
        'etc'                 
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
