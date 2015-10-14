<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserMoneyLog;
use App\User;


class UserCarry extends Model
{
    protected $table = "user_carry";

    const STATUS_NOT_PASSED = 0;
    const STATUS_PASSED = 1;
    const STATUS_PENDING = 2;
    const STATUS_CANCEL = 3;


    protected static function createdCallback($carry){
        $member = $carry->user;
        
        $userLockMoneyLog = new UserMoneyLog();
        $userLockMoneyLog->user_id = $member->getKey();
        $userLockMoneyLog->money = $carry->money;
        // 当前账户余额
        $userLockMoneyLog->account_money = $member->money;
        $userLockMoneyLog->can_money = $member->can_money - $carry->money;
        $userLockMoneyLog->type = UserMoneyLog::TYPE_CARRY;
        $userDebitMoneyLog->created_at = strtotime($carry->created_at);
        $userDebitMoneyLog->create_time_ymd = $carry->created_at->format('Y-m-d');
        $userDebitMoneyLog->create_time_ym = $carry->created_at->format('Ym');
        $userDebitMoneyLog->create_time_y = $carry->created_at->format('Y');
        // $userLockMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        $userLockMoneyLog->log_type = UserMoneyLog::LOG_TYPE_LOCK;
        // $userLockMoneyLog->deal_order_sn = $carry->order_sn;
        $userLockMoneyLog->save();

        // 用户冻结资金变化
        $member->lock_money = $member->lock_money + $userLockMoneyLog->money;
        // 用户可用资金变化
        $member->can_money = $member->can_money - $userLockMoneyLog->money;
        // 保存信息
        $member->save();
    }

    protected static function updatedCallback($carry){
        switch($carry->status){
            case self::STATUS_PASSED:
                self::_carryPassed($carry);
                break;
            case self::STATUS_NOT_PASSED:
            case self::STATUS_CANCEL:
                self::_carryNotPassed($carry);
                break;
        }
    }


    protected static function _carryPassed($carry){
        $member = $carry->user;

        $userDebitMoneyLog = new UserMoneyLog();
        $userDebitMoneyLog->user_id = $member->getKey();
        $userDebitMoneyLog->money = $carry->money;
        $userDebitMoneyLog->account_money = $member->money - $carry->money;
        $userDebitMoneyLog->can_money = $member->can_money;
        $userDebitMoneyLog->type = UserMoneyLog::TYPE_CARRY;
        $userDebitMoneyLog->created_at = strtotime($carry->created_at);
        $userDebitMoneyLog->create_time_ymd = $carry->created_at->format('Y-m-d');
        $userDebitMoneyLog->create_time_ym = $carry->created_at->format('Ym');
        $userDebitMoneyLog->create_time_y = $carry->created_at->format('Y');
        // $userDebitMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        $userDebitMoneyLog->log_type = UserMoneyLog::LOG_TYPE_DEDUCTION;
        // $userDebitMoneyLog->deal_order_sn = $carry->order_sn;
        $userDebitMoneyLog->save();

        // 用户资金变化
        $member->money = $member->money - $userDebitMoneyLog->money;
        $member->lock_money = $member->lock_money - $userDebitMoneyLog->money;
        $member->save();
    }

    protected static function _carryNotPassed($carry){
        $member = $carry->user;

        switch($carry->status){
            case self::STATUS_NOT_PASSED:
                $type = UserMoneyLog::TYPE_CARRY_FAIL;
            break;
            case self::STATUS_CANCEL:
                $type = UserMoneyLog::TYPE_CARRY_CANCEL;
            break;
        }

        $userRefundMoneyLog = new UserMoneyLog();
        $userRefundMoneyLog->user_id = $member->getKey();
        $userRefundMoneyLog->money = $carry->money;
        $userRefundMoneyLog->account_money = $member->money;
        $userRefundMoneyLog->can_money = $member->can_money + $carry->money;
        $userRefundMoneyLog->type = $type;
        $userDebitMoneyLog->created_at = strtotime($carry->created_at);
        $userDebitMoneyLog->create_time_ymd = $carry->created_at->format('Y-m-d');
        $userDebitMoneyLog->create_time_ym = $carry->created_at->format('Ym');
        $userDebitMoneyLog->create_time_y = $carry->created_at->format('Y');
        // $userRefundMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        $userRefundMoneyLog->log_type = UserMoneyLog::LOG_TYPE_DEDUCTION;
        // $userRefundMoneyLog->deal_order_sn = $carry->order_sn;
        $userRefundMoneyLog->save();

        // 用户资金变化
        $member->lock_money = $member->lock_money - $userRefundMoneyLog->money;
        $member->can_money = $member->can_money + $userRefundMoneyLog->money;
        $member->save();
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function bank(){
        return $this->belongsTo('App\Bank','bank_id','id');
    }

    public function passed(){
        return $this->belongsTo('App\User','passed_uid','id');
    }


    protected static function statusTitles(){
        return [
            self::STATUS_NOT_PASSED => '未通过',
            self::STATUS_PASSED => '已处理',
            self::STATUS_PENDING => '待处理',
            self::STATUS_CANCEL => '已取消',
        ];
    }

    public static function getStatusTitle($status){
        $titles = self::statusTitles();
        if( isset($titles[$status]) ){
            return $titles[$status];
        }else{
            return "未知状态";
        }
    }
}
