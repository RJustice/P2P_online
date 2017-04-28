<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'user_metas';
    
    public function user(){
        return $this->belongsTo('App\User','id','uid');
    }
}
