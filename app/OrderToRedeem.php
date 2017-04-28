<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DealOrder;
use App\User;
use App\UserMoneyLog;

class OrderToRedeem extends Model
{
    protected $fillable = ['order_id','order_sn','order_money','order_return','user_id','who_confirm','memo'];
    protected $table = 'deal_order_to_redeem';

    const STATUS_PASSED = 1;
    const STATUS_PENDING = 0;
    const STATUS_UNPASSED = 2;

    const FEE_PERCENT = 0.03;

    // 审核状态    
    
    protected static function passStatus(){
        return [
            self::STATUS_UNPASSED => '未通过审核',
            self::STATUS_PENDING => '等待审核',
            self::STATUS_PASSED => '审核通过',
        ];
    }

    public static function getPassStatusTitle($status){
        $titles = self::passStatus();
        if( isset($titles[$status]) ){
            return $titles[$status];
        }else{
            return '未知状态!';
        }
    }

    public static function getPassStatusOption($format = false){
        $status = self::passStatus();
        if( $format ){
            foreach($status as $k=>$v){
                $tmp[] = [
                    'label' => $v,
                    'value' => $k
                ];
            }
            return $tmp;
        }else{
            return $status;
        }
    }

    public function dealOrder(){
        return $this->hasOne('App\DealOrder','id','order_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function whoConfirm(){
        return $this->belongsTo('App\User','who_confirm','id');
    }

    protected static function createdCallback($orderToRedeem){
        $dealOrder = $orderToRedeem->dealOrder;
        $member = $orderToRedeem->user;

        $dealOrder->order_status = DealOrder::ORDER_STATUS_REDEEM;
        $dealOrder->redeem_date = date('Y-m-d');
        $dealOrder->save();

        $fee = $orderToRedeem->order_money * self::FEE_PERCENT;
        // 赎回本金
        // $capital = $orderToRedeem->order_money - $fee;
        // 赎回订单总所得
        // $totalMoney = $capital + $orderToRedeem->order_return;


        // 赎回订单所得 --> 冻结
        $userMoneyLog = new UserMoneyLog();
        $userMoneyLog->user_id = $member->getKey();
        $userMoneyLog->money = $orderToRedeem->order_money + $orderToRedeem->order_return;
        $userMoneyLog->account_money = $member->money;
        $userMoneyLog->can_money = $member->can_money;
        $userMoneyLog->type = UserMoneyLog::TYPE_REDEEM;
        $userMoneyLog->created_at = date("Y-m-d H:i:s");
        $userMoneyLog->create_time_ymd = date('Y-m-d');
        $userMoneyLog->create_time_ym = date('Ym');
        $userMoneyLog->create_time_y = date('Y');
        $userMoneyLog->proof_id = 0;
        $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_LOCK;
        $userMoneyLog->deal_order_sn = $orderToRedeem->order_sn;
        $userMoneyLog->save();


        // 赎回订单手续费 --> 扣除冻结
        // $feeMoneyLog = new UserMoneyLog();
        // $feeMoneyLog->user_id = $member->getKey();
        // $feeMoneyLog->money = $fee;
        // $feeMoneyLog->account_money = $member->money;
        // $feeMoneyLog->can_money = $member->can_money;
        // $feeMoneyLog->type = UserMoneyLog::TYPE_REDEEM_FEE;
        // $feeMoneyLog->created_at = date("Y-m-d H:i:s");
        // $feeMoneyLog->create_time_ymd = date('Y-m-d');
        // $feeMoneyLog->create_time_ym = date('Ym');
        // $feeMoneyLog->create_time_y = date('Y');
        // $feeMoneyLog->proof_id = 0 ;
        // $feeMoneyLog->log_type = UserMoneyLog::LOG_TYPE_LOCK;
        // $feeMoneyLog->deal_order_sn = $orderToRedeem->order_sn;
        // $feeMoneyLog->save();

        // 用户资金变化
        $member->money = $member->money;
        $member->lock_money = $member->lock_money + $orderToRedeem->order_money + $orderToRedeem->order_return;
        $member->waiting_returns = $member->waiting_returns - $orderToRedeem->order_return;
        $member->save();
    }

    protected static function passedCallback($orderToRedeem){
        $member = $orderToRedeem->user;
        $dealOrder = $orderToRedeem->dealOrder;

        $dealOrder->order_status = DealOrder::ORDER_STATUS_REDEEM_FINISHED;
        $dealOrder->save();

        // 手续费
        $fee = $orderToRedeem->order_money * self::FEE_PERCENT;
        // 赎回本金
        // $capital = $orderToRedeem->order_money - $fee;
        // 赎回订单总所得
        // $totalMoney = $capital + $orderToRedeem->order_return;

        // 冻结转余额
        $userMoneyLog = new UserMoneyLog();
        $userMoneyLog->user_id = $member->getKey();
        $userMoneyLog->money = $orderToRedeem->order_money + $orderToRedeem->order_return;
        $userMoneyLog->account_money = $member->money + $orderToRedeem->order_return;
        $userMoneyLog->can_money = $member->can_money + $orderToRedeem->order_money + $orderToRedeem->order_return;
        $userMoneyLog->type = UserMoneyLog::TYPE_REDEEM;
        $userMoneyLog->created_at = date("Y-m-d H:i:s");
        $userMoneyLog->create_time_ymd = date('Y-m-d');
        $userMoneyLog->create_time_ym = date('Ym');
        $userMoneyLog->create_time_y = date('Y');
        $userMoneyLog->proof_id = 0;
        $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_UNLOCK;
        $userMoneyLog->deal_order_sn = $orderToRedeem->order_sn;
        $userMoneyLog->save();


        // 赎回订单手续费 --> 扣除冻结
        $feeMoneyLog = new UserMoneyLog();
        $feeMoneyLog->user_id = $member->getKey();
        $feeMoneyLog->money = $fee;
        $feeMoneyLog->account_money = $member->money - $fee;
        $feeMoneyLog->can_money = $member->can_money + $orderToRedeem->order_money + $orderToRedeem->order_return - $fee;
        $feeMoneyLog->type = UserMoneyLog::TYPE_REDEEM_FEE;
        $feeMoneyLog->created_at = date("Y-m-d H:i:s");
        $feeMoneyLog->create_time_ymd = date('Y-m-d');
        $feeMoneyLog->create_time_ym = date('Ym');
        $feeMoneyLog->create_time_y = date('Y');
        $feeMoneyLog->proof_id = 0 ;
        $feeMoneyLog->log_type = UserMoneyLog::LOG_TYPE_DEDUCTION;
        $feeMoneyLog->deal_order_sn = $orderToRedeem->order_sn;
        $feeMoneyLog->save();

        // 用户资金变化
        $member->money = $member->money + $orderToRedeem->order_return - $fee;
        $member->can_money = $member->can_money + $orderToRedeem->order_money + $orderToRedeem->order_return - $fee;
        $member->lock_money = $member->lock_money - $orderToRedeem->order_money - $orderToRedeem->order_return;
        $member->save();

    }

    protected static function unpassCallback($orderToRedeem){
        $member = $orderToRedeem->user;
        $dealOrder = $orderToRedeem->dealOrder;

        $now = date_create(date('Y-m-d'));
        $end = date_create($dealOrder->finish_date);
        $start = date_create($dealOrder->create_date);
        if( $now >= $start && $now < $end ){
            $dealOrder->order_status = DealOrder::ORDER_STATUS_VALID;
        }elseif($now < $start){
            $dealOrder->order_status = DealOrder::ORDER_STATUS_INVALID;
        }elseif($now > $end){
            $dealOrder->order_status = DealOrder::ORDER_STATUS_FINISHED;
        }
        $dealOrder->save();

        // 手续费
        $fee = $orderToRedeem->order_money * self::FEE_PERCENT;
        // 赎回本金
        // $capital = $orderToRedeem->order_money - $fee;
        // 赎回订单总所得
        // $totalMoney = $capital + $orderToRedeem->order_return;

        // 赎回订单所得 --> 解冻
        $userMoneyLog = new UserMoneyLog();
        $userMoneyLog->user_id = $member->getKey();
        $userMoneyLog->money = $orderToRedeem->order_money + $orderToRedeem->order_return;
        $userMoneyLog->account_money = $member->money;
        $userMoneyLog->can_money = $member->can_money;
        $userMoneyLog->type = UserMoneyLog::TYPE_REDEEM;
        $userMoneyLog->created_at = date("Y-m-d H:i:s");
        $userMoneyLog->create_time_ymd = date('Y-m-d');
        $userMoneyLog->create_time_ym = date('Ym');
        $userMoneyLog->create_time_y = date('Y');
        $userMoneyLog->proof_id = 0;
        $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_UNLOCK;
        $userMoneyLog->deal_order_sn = $orderToRedeem->order_sn;
        $userMoneyLog->save();

        // 用户资金变化
        $member->money = $member->money;
        $member->lock_money = $member->lock_money - $orderToRedeem->order_money - $orderToRedeem->order_return;
        $member->waiting_returns = $member->waiting_returns + $orderToRedeem->order_return;
        $member->save();
    }
}
