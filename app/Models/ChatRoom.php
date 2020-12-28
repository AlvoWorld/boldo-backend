<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;
    protected $fillable = [
        'pending_id',      
        'room',
        'state1',
        'state2'       
    ];
    public function pending()
    {
        return $this->belongsTo('App\Models\Pending');
    }

}
