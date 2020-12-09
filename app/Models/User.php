<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'typeOfProfessional'=>'array'
    ];

    public function post()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function pending()
    {
        return $this->hasMany('App\Models\Pending');
    }

    public function pendingUser()
    {
        return $this->hasMany('App\Models\Pending');
    }

    public function histories()
    {
        return $this->hasMany('App\Models\History');
    }
}
