<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'connect_id',
        'block1',       
        'block2',       
        'active',       
        'etc'       
    ];

    public function chats()
    {
        return $this->hasMany('App\Models\Chat');
    }
}
