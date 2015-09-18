<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealOrder extends Model
{
    // protected $table = "deal_orders";
    // 
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
