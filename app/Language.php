<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
    	'name','price'
    ];


    public function photo() {
        return $this->morphOne('App\Photo', 'photoable');
    }

    public function translatorfilestarget(){
        return $this->hasMany('App\TranslatorFiles','target_language');
    }

    public function translatorfilessource(){
        return $this->hasMany('App\TranslatorFiles','source_language');
    }

    public function clientfilessource(){
        return $this->hasMany('App\TranslatorFiles','source_language');
    }

    public function clientfilestarget() {
        return $this->hasMany('App\ClientFiles','target_language');
    }

    public function translators() {
        return $this->hasMany('App\Translator');
    }
}
