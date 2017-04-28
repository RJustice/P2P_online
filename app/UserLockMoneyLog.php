<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLockMoneyLog extends Model
{
    // protected $table = "user_lock_money_logs";
    public $timestamps = false;
    
    // 0结存，1充值，2投标成功，8申请提现，9提现手续费，10借款管理费，18开户奖励，19流标还返
    const TYPE_BALANCE = 0; // 结存
    const TYPE_RECHARGE = 1; // 充值
    const TYPE_BUY_DEAL = 2; // 投资理财
    const TYPE_CARRY = 3; // 提现
    const TYPE_CARRY_FEE = 4; // 提现手续费
    const TYPE_REWARD = 5; // 奖励
    const TYPE_OFFLINE_ORDER = 6; // 线下订单登记

    public static function addLog($data){

    }
}
