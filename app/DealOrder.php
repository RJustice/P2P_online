<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DealOrder extends Model
{
    // protected $table = "deal_orders";
    // 
    protected $guarded = ['id'];

    const STATUS_FINISHED = 2;
    const STATUS_INVALID = 0;
    const STATUS_VALID = 1;

    const TYPE_LOAN = 1;
    const TYPE_ONLINE_RECHARGE = 2;
    const TYPE_OUTLINE_RECHARGE = 3;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function item(){
        return $this->belongsTo('App\Deal');
    }
}
