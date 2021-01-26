<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'read1',
        'read2',       
        'content',       
        'etc',       
    ];

    protected $casts = [
        'content'=>'object'
    ];

    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }
}
