<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TranslatorFiles extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
    	'filename','translator_id','user_id','language_id','words'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function translator() {
        return $this->belongsTo('App\Translator');
    }

    public function language() {
        return $this->belongsTo('App\Language');
    }
}
