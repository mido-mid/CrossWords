<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\TranslatorResetPasswordNotification;



class Translator extends Authenticatable 
{
    //

    use Notifiable;

    protected $guard = 'translator';


    public $timestamps = false;
    
    protected $fillable = [
        'first_name','last_name','email','password','approved','language_id'
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new TranslatorResetPasswordNotification($token));
    }


    protected $hidden = [
        'password', 'remember_token',
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

    public function language(){
        return $this->belongsTo('App\Language');
    }
}
