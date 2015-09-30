<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    // protected $table = "user_banks";
    public $timestamps = false;
    
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public static function formatBankCard($bankcard){
        return preg_replace('/([0-9]{6})[0-9]{4,}([0-9]{4})/i','$1****$2',$bankcard);
    }
}
