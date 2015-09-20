<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMoneyLog extends Model
{
    protected $table = "user_money_logs";

    //0结存，1充值，2投标成功，3招标成功，4偿还本息，5回收本息，6提前还款，7提前回收，8申请提现，9提现手续费，10借款管理费，11逾期罚息，12逾期管理费，13人工充值，14借款服务费，15出售债权，16购买债权，17债权转让管理费，18开户奖励，19流标还返，20投标管理费，21投标逾期收入，22兑换，23邀请返利，24投标返利，25签到成功，26逾期罚金（垫付后），27其他费用
    

    const TYPE_BALANCE = 0;  // 结存 
    const TYPE_RECHARGE = 1; // 充值
    const TYPE_CARRY = 2; // 提现
    const TYPE_CARRY_FEE = 3; // 提现手续费
    const TYPE_HAND_RECHARGE = 4; // 人工充值
    const TYPE_REWARD = 5; // 奖励
    const TYPE_OTHER = 6; // 其他费用 
}
