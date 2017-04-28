<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proof extends Model
{
    protected $table = 'proofs';
    public $timestamps = false;

    const TYPE_OFFLINE_ORDER = 'deal_orders';
    const TYPE_ONLINE_ORDER = 'deal_orders';
    const TYPE_OFFLINE_RECHARGE = 'deal_orders';
    const TYPE_ONLINE_RECHARGE = 'deal_orders';
    const TYPE_HAND_FREEZE = 'deal_orders';
    const TYPE_HAND_DEBIT = 'deal_orders';


}
