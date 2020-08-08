<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFiles extends Model
{
    //

    public $timestamps = false;

    protected $fillable = [
    	'filename','translator_id','user_id','target_language','words','total_price','source_language'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function translator() {
        return $this->belongsTo('App\Translator');
    }

    public function languagetarget() {
        return $this->belongsTo('App\Language','target_language');
    }

    public function languagesource() {
        return $this->belongsTo('App\Language','source_language');
    }
}
