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
    
    public function translatorfiles(){
        return $this->hasMany('App\TranslatorFiles');
    }

    public function clientfiles() {
        return $this->hasMany('App\ClientFiles');
    }

    public function translators() {
        return $this->hasMany('App\Translator');
    }
}
