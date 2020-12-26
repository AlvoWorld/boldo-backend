<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookingStyle extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sort',
        'etc',
    ];
    use HasFactory;
}
