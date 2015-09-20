<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLockMoneyLog extends Model
{
    // protected $table = "user_lock_money_logs";
    
    // 0结存，1充值，2投标成功，8申请提现，9提现手续费，10借款管理费，18开户奖励，19流标还返
    const type_balance = 0; // 结存
    const type_recharge = 1; // 充值
    const type_buy_deal = 2; // 投资理财
    const type_carry = 3; // 提现
    const type_carry_fee = 4; // 提现手续费
    const type_reward = 5; // 奖励
}
