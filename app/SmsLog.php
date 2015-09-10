<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $table = 'sms_logs';
    protected $fillable = ['uid','phone','message','type','smsid','sms_state','code'];

    const TYPE_VERCODE = 'vercode';
    const TYPE_MESSAGE = 'message';

    public static function updateLog($data){

    }

    public function scopeToday($query){
        $today = date('Y-m-d 00:00:00');
        $tomorrow = date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')+1,date('Y')));
        return $query->whereBetween('created_at',[$today,$tomorrow]);
    }
}
