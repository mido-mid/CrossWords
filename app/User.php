<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'first_name','last_name', 'email', 'password','role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public function photo() {
        return $this->morphOne('App\Photo', 'photoable');
    }

    public function clientfiles(){

        return $this->hasMany('App\ClientFiles');
    }

    public function translatorfiles(){

        return $this->hasMany('App\TranslatorFiles');
    }
}
