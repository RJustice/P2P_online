<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMoneyLog extends Model
{
    protected $table = "user_money_logs";    
    public $timestamps = false;

    
    //0结存，1充值，2投标成功，3招标成功，4偿还本息，5回收本息，6提前还款，7提前回收，8申请提现，9提现手续费，10借款管理费，11逾期罚息，12逾期管理费，13人工充值，14借款服务费，15出售债权，16购买债权，17债权转让管理费，18开户奖励，19流标还返，20投标管理费，21投标逾期收入，22兑换，23邀请返利，24投标返利，25签到成功，26逾期罚金（垫付后），27其他费用
    

    const TYPE_BALANCE = 0;  // 结存 
    const TYPE_RECHARGE = 1; // 充值
    const TYPE_CARRY = 2; // 提现申请
    const TYPE_CARRY_FEE = 3; // 提现手续费
    const TYPE_CARRY_FAIL = 10; // 提现未通过
    const TYPE_CARRY_CANCEL = 11; // 提现取消
    const TYPE_CARRY_PASSED = 12; // 提现通过
    const TYPE_HAND_RECHARGE = 4; // 人工充值
    const TYPE_REWARD = 5; // 奖励
    const TYPE_OTHER = 6; // 其他费用 
    const TYPE_OFFLINE_ORDER = 7; // 线下订单登记
    const TYPE_HAND_FREEZE = 8; // 人工冻结
    const TYPE_HAND_DEBIT = 9; // 快速扣款
    const TYPE_BALANCE_INVEST = 13; // 余额投资
    const TYPE_POS_INVEST = 14 ; // POS投资
    const TYPE_POS_BALANCE = 15; // POS余额转入

    const LOG_TYPE_ADDITION = 1; // 增加资金
    const LOG_TYPE_LOCK = 2; // 冻结资金
    const LOG_TYPE_DEDUCTION = 3; // 扣除
    const LOG_TYPE_UNLOCK = 4; // 解冻
    const LOG_TYPE_INVEST = 5; // 投资

    
    // Log Type  日志操作类型
    protected static function logCtlType(){
        return [
            self::LOG_TYPE_ADDITION => '增加资金',
            self::LOG_TYPE_LOCK => '冻结资金',
            self::LOG_TYPE_DEDUCTION => '扣除金额',
            self::LOG_TYPE_UNLOCK => '解冻',
            self::LOG_TYPE_INVEST => '投资理财'
        ];
    }

    public static function getLogCtlTypeTitle($type){
        $titles = self::logCtlType();
        if( isset($titles[$type]) ){
            return $titles[$type];
        }else{
            return '未知类型!';
        }
    }

    public static function getLogCtlTypeOption($format = false){
        $types = self::logCtlType();
        if( $format ){
            foreach($types as $k=>$v){
                $tmp[] = [
                    'label' => $v,
                    'value' => $k
                ];
            }
            return $tmp;
        }else{
            return $types;
        }
    }


    // Type  日志项目
    protected static function logType(){
        return [
            self::TYPE_BALANCE => '结存',
            self::TYPE_RECHARGE => '充值',
            self::TYPE_CARRY => '提现申请',
            self::TYPE_CARRY_FEE => '提现手续费',
            self::TYPE_CARRY_FAIL => '提现未通过',
            self::TYPE_CARRY_CANCEL => '提现取消',
            self::TYPE_CARRY_PASSED => '提现通过',
            self::TYPE_HAND_RECHARGE => '人工充值',
            self::TYPE_REWARD => '奖励',
            self::TYPE_OTHER => '其他费用',
            self::TYPE_OFFLINE_ORDER => '线下订单登记',
            self::TYPE_HAND_FREEZE => '人工冻结',
            self::TYPE_HAND_DEBIT => '快速扣款',
            self::TYPE_BALANCE_INVEST => '余额投资',
            self::TYPE_POS_INVEST => 'POS单投资',
            self::TYPE_POS_BALANCE => 'POS余额转入'
        ];
    }

    public static function getLogTypeTitle($type){
        $titles = self::logType();
        if( isset($titles[$type]) ){
            return $titles[$type];
        }else{
            return '未知状态!';
        }
    }

    public static function getLogTypeOption($format = false){
        $types = self::logType();
        if( $format ){
            foreach($types as $k=>$v){
                $tmp[] = [
                    'label' => $v,
                    'value' => $k
                ];
            }
            return $tmp;
        }else{
            return $types;
        }
    }
}
