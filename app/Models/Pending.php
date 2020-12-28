<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'connect_id',
        'state'                 
    ];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function userPending()
    {
        return $this->belongsTo('App\Models\User', 'connect_id');
    }

    public function chatroom()
    {
        return $this->hasOne('App\Models\ChatRoom');
    }
}
