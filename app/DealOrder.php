<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Company;
use App\UserMoneyLog;
use App\Deal;
use DB;

class DealOrder extends Model
{
    // protected $table = "deal_orders";
    // 
    protected $guarded = ['id'];

    // 字段: order_status
    const ORDER_STATUS_FINISHED = 2;// 订单完成
    const ORDER_STATUS_INVALID = 0; // 订单失效
    const ORDER_STATUS_VALID = 1;   // 订单生效中

    // 字段: type
    const TYPE_OFFLINE_ORDER = 1;   // 线下订单
    const TYPE_ONLINE_ORDER = 2;    // 线上订单
    const TYPE_ONLINE_RECHARGE = 3; // 线上充值
    const TYPE_OFFLINE_RECHARGE = 4;// 线下充值
    const TYPE_HAND_FREEZE = 5;     // 冻结资金
    const TYPE_HAND_DEBIT = 6;      // 快速扣款

    // 字段: status
    const STATUS_NOT_PASSED = 0;    // 未通过审核
    const STATUS_PENDING = 2;       // 等待审核
    const STATUS_PASSED = 1;        // 通过审核

    // 字段: pay_status
    const PAY_STATUS_FINISH = 1;    // 全额支付完成
    const PAY_STATUS_UNFINISH = 0;  // 未支付完成
    const PAY_STATUS_SOME = 2;      // 部分支付

    // const REFERER_OFFLINE = '线下订单';

    // public function user(){
    //     return $this->belongsTo('App\User');
    // }

    // public function item(){
    //     return $this->belongsTo('App\Deal');
    // }

    public static function buildSN($type){
        $pre = '';
        switch($type){
            case self::TYPE_OFFLINE_RECHARGE :
                $pre = 'FR_';
                break;
            case self::TYPE_OFFLINE_ORDER :
                $pre = 'FO_';
                break;
            case self::TYPE_ONLINE_ORDER :
                $pre = 'NO_';
                break;
            case self::TYPE_ONLINE_RECHARGE :
                $pre = 'NR_';
                break;
            case self::TYPE_HAND_FREEZE :
                $pre = 'HF_';
                break;
            case self::TYPE_HAND_DEBIT :
                $pre = 'HD_';
                break;
            default:
                $pre = 'DD_';
                break;
        }
        $orderno = date('Ymd') . substr(time(),-4) . mt_rand(10,99);
        return $pre . $orderno;
    }


    // 订单状态  
    
    protected static function orderStatus(){
        return [
            self::ORDER_STATUS_VALID => '生效中',
            self::ORDER_STATUS_INVALID => '失效',
            self::ORDER_STATUS_FINISHED => '已完成'
        ];
    }

    public static function getOrderStatusTitle($status){
        $titles = self::orderStatus();
        if( isset($titles[$status]) ){
            return $titles[$status];
        }else{
            return '未知状态!';
        }
    }

    public static function getOrderStatusOption($format = false){
        $status = self::orderStatus();
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


    // 订单类型

    protected static function orderTypes(){
        return [
            self::TYPE_OFFLINE_ORDER => '线下订单',
            self::TYPE_ONLINE_ORDER => '线上订单',
            self::TYPE_ONLINE_RECHARGE => '线上充值',
            self::TYPE_OFFLINE_RECHARGE => '线下充值',
            self::TYPE_HAND_FREEZE => '手动冻结',
            self::TYPE_HAND_DEBIT => '手动扣款',
        ];
    }

    public static function getOrderTypeTitle($type){
        $titles = self::orderTypes();
        if( isset($titles[$type]) ){
            return $titles[$type];
        }else{
            return '未知类型!';
        }
    }

    public static function getOrderTypeOption($format = false){
        $types = self::orderTypes();
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



    // 审核状态    
    
    protected static function passStatus(){
        return [
            self::STATUS_NOT_PASSED => '未通过审核',
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


    // 付款状态

    protected static function payStatus(){
        return [
            self::PAY_STATUS_FINISH => '付款完成',
            self::PAY_STATUS_UNFINISH => '付款未完成',
            self::PAY_STATUS_SOME => '部分付款',
        ];
    }

    public static function getPayStatusTitle($status){
        $titles = self::payStatus();
        if( isset($titles[$status]) ){
            return $titles[$status];
        }else{
            return '未知状态!';
        }
    }

    public static function getPayStatusOption($format = false){
        $status = self::payStatus();
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
    
    public function member(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function whoSales(){
        return $this->belongsTo('App\User','who_sale','id');
    }

    public function whoConfirm(){
        return $this->belongsTo('App\User','who_confirm','id');
    }

    public function company(){
        return $this->belongsTo('App\Company','company_id','id');
    }

    public function proofs(){
        return $this->hasOne('App\Proof','type_id',$this->getKeyName());
    }

    public function deal(){
        return $this->belongsTo('App\Deal','deal_id','id');
    }

    protected static function savedCallback($dealOrder){
        if( $dealOrder->status == self::STATUS_PASSED ){
            switch($dealOrder->type){
                case self::TYPE_OFFLINE_ORDER :
                    self::_offlineOrderMoneyLog($dealOrder);
                    self::_signleBuildReturns(self::find($dealOrder->getKey()));
                    break;
                case self::TYPE_OFFLINE_RECHARGE :
                    self::_offlineRechargeMoneyLog($dealOrder);
                    break;
                case self::TYPE_HAND_DEBIT :
                    self::_handDebitMoneyLog($dealOrder);
                    break;
                case self::TYPE_HAND_FREEZE :
                    self::_handFreezeMoneyLog($dealOrder);
                    break;
            }
        }
    }

    protected static function _offlineOrderMoneyLog($dealOrder){
        $member = $dealOrder->member;
        $proofs = $dealOrder->proofs;

        $userMoneyLog = new UserMoneyLog();
        $userMoneyLog->user_id = $member->getKey();
        $userMoneyLog->money = $dealOrder->total_price;
        $userMoneyLog->account_money = $member->money + $dealOrder->total_price;
        $userMoneyLog->can_money = $member->can_money + $dealOrder->total_price;
        $userMoneyLog->type = UserMoneyLog::TYPE_OFFLINE_ORDER;
        $userMoneyLog->created_at = strtotime($dealOrder->create_date);
        $userMoneyLog->create_time_ymd = $dealOrder->create_date;
        $userMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
        $userMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
        $userMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
        $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userMoneyLog->save();


        // 用户资金变化
        $member->money = $member->money + $userMoneyLog->money;
        $member->can_money = $member->can_money + $dealOrder->total_price;
        $member->save();


        $userLockMoneyLog = new UserMoneyLog();
        $userLockMoneyLog->user_id = $member->getKey();
        $userLockMoneyLog->money = $dealOrder->total_price;
        // 当前账户余额
        $userLockMoneyLog->account_money = $member->money;
        $userLockMoneyLog->can_money = $member->can_money - $dealOrder->total_price;
        $userLockMoneyLog->type = UserMoneyLog::TYPE_OFFLINE_ORDER;
        $userLockMoneyLog->created_at = strtotime($dealOrder->create_date);
        $userLockMoneyLog->create_time_ymd = date('Ymd',strtotime($dealOrder->create_date));
        $userLockMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
        $userLockMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
        $userLockMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        $userLockMoneyLog->log_type = UserMoneyLog::LOG_TYPE_LOCK;
        $userLockMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userLockMoneyLog->save();

        // 用户冻结资金变化
        $member->lock_money = $member->lock_money + $userLockMoneyLog->money;
        // 用户可用资金变化
        $member->can_money = $member->can_money - $userLockMoneyLog->money;
        // 保存信息
        $member->save();
    }


    protected static function _offlineRechargeMoneyLog($dealOrder){
        $member = $dealOrder->member;
        $proofs = $dealOrder->proofs;

        $userMoneyLog = new UserMoneyLog();
        $userMoneyLog->user_id = $member->getKey();
        $userMoneyLog->money = $dealOrder->total_price;
        $userMoneyLog->account_money = $member->money + $dealOrder->total_price;
        $userMoneyLog->can_money = $member->can_money + $dealOrder->total_price;
        $userMoneyLog->type = UserMoneyLog::TYPE_HAND_RECHARGE;
        $userMoneyLog->created_at = strtotime($dealOrder->create_date);
        $userMoneyLog->create_time_ymd = $dealOrder->create_date;
        $userMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
        $userMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
        $userMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
        $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userMoneyLog->save();


        // 用户资金变化
        $member->money = $member->money + $userMoneyLog->money;
        $member->can_money = $member->can_money + $dealOrder->total_price;
        $member->save();
    }


    protected static function _handDebitMoneyLog($dealOrder){
        $member = $dealOrder->member;
        $proofs = $dealOrder->proofs;

        $userDebitMoneyLog = new UserMoneyLog();
        $userDebitMoneyLog->user_id = $member->getKey();
        $userDebitMoneyLog->money = $dealOrder->total_price;
        $userDebitMoneyLog->account_money = $member->money - $dealOrder->total_price;
        $userDebitMoneyLog->can_money = $member->can_money - $dealOrder->total_price;
        $userDebitMoneyLog->type = UserMoneyLog::TYPE_HAND_DEBIT;
        $userDebitMoneyLog->created_at = strtotime($dealOrder->create_date);
        $userDebitMoneyLog->create_time_ymd = $dealOrder->create_date;
        $userDebitMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
        $userDebitMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
        $userDebitMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        $userDebitMoneyLog->log_type = UserMoneyLog::LOG_TYPE_DEDUCTION;
        $userDebitMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userDebitMoneyLog->save();

        // 用户资金变化
        $member->money = $member->money - $userDebitMoneyLog->money;
        $member->can_money = $member->can_money - $userDebitMoneyLog->money;
        $member->save();
    }

    protected static function _handFreezeMoneyLog($dealOrder){
        $member = $dealOrder->member;
        $proofs = $dealOrder->proofs;
        
        $userLockMoneyLog = new UserMoneyLog();
        $userLockMoneyLog->user_id = $member->getKey();
        $userLockMoneyLog->money = $dealOrder->total_price;
        // 当前账户余额
        $userLockMoneyLog->account_money = $member->money;
        $userLockMoneyLog->can_money = $member->can_money - $dealOrder->total_price;
        $userLockMoneyLog->type = UserMoneyLog::TYPE_HAND_FREEZE;
        $userLockMoneyLog->created_at = strtotime($dealOrder->create_date);
        $userLockMoneyLog->create_time_ymd = date('Ymd',strtotime($dealOrder->create_date));
        $userLockMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
        $userLockMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
        $userLockMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        $userLockMoneyLog->log_type = UserMoneyLog::LOG_TYPE_LOCK;
        $userLockMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userLockMoneyLog->save();

        // 用户冻结资金变化
        $member->lock_money = $member->lock_money + $userLockMoneyLog->money;
        // 用户可用资金变化
        $member->can_money = $member->can_money - $userLockMoneyLog->money;
        // 保存信息
        $member->save();
    }


    //  日常计算收益 ,用于每日计算
    //  LOANTYPE_DENGEBENXI => '等额本息',
    //  LOANTYPE_FUXIFANBEN => '月付息到期返本',
    //  LOANTYPE_DAOQI => '到期付息返本',
    //  
    protected static function buildReturns(){
        $dealOrders = self::where('status',self::STATUS_PASSED)->where('is_deleted',0)->whereIn('type',[self::TYPE_OFFLINE_ORDER,self::TYPE_ONLINE_ORDER])->where('order_status',self::ORDER_STATUS_VALID);
        // dd($dealOrders->count());
        $userWaiting = 0;
        DB::update('update users set waiting_returns = 0');
        $dealOrders->chunk(200,function($dealOrders){
            foreach($dealOrders as $dealOrder){
                switch($dealOrder->deal_type){
                    case Deal::LOANTYPE_DAOQI :
                        $userWaiting = self::_calculateDQ($dealOrder);
                        break;
                    case Deal::LOANTYPE_FUXIFANBEN :
                        $userWaiting = self::_calculateFX($dealOrder);
                        break;
                    // case Deal::LOANTYPE_DENGEBENXI :
                    //     $userWaiting[$dealOrder->user_id] = self::_calculateDE($dealOrder);
                    //     break;
                }
                $dealOrder->member->waiting_returns = $dealOrder->member->waiting_returns + $userWaiting;
                $dealOrder->member->save();
            }
        });
    }
    
    protected static function _calculateDQ($dealOrder){
        $start = date_create($dealOrder->create_date);
        $end = date_create($dealOrder->finish_date);
        $daliy = $dealOrder->deal_daliy_returns;
        $today = date_create(date('Y-m-d'));

        if( $today > $end ){
            $diff = date_diff($end,$start,true);
            $shouyi = ( $diff->days - 1 ) * $daliy * ( $dealOrder->total_price / 10000 );            
            // 写资金日志
            // Start
            $userMoneyLog = new UserMoneyLog;
            $userMoneyLog->user_id = $dealOrder->member->getKey();
            $userMoneyLog->money = $shouyi; // 收益
            $userMoneyLog->account_money = $dealOrder->member->money + $shouyi;
            $userMoneyLog->can_money = $dealOrder->member->can_money + $shouyi;
            $userMoneyLog->type = UserMoneyLog::TYPE_BALANCE;
            $userMoneyLog->created_at = time();
            $userMoneyLog->create_time_ymd = date('Y-m-d');
            $userMoneyLog->create_time_ym = date('Ym');
            $userMoneyLog->create_time_y = date('Y');
            // $userMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
            $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
            // $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
            $userMoneyLog->save();
            // End

            $dealOrder->member->money = $dealOrder->member->money + $shouyi;
            $dealOrder->member->can_money = $dealOrder->member->can_money + $shouyi;
            $dealOrder->member->save();

            $dealOrder->order_status = self::ORDER_STATUS_FINISHED;
            $days = 0;
        }else{
            $diff = date_diff($today,$start,true);
            $days = $diff->days - 1;
        }
        $waitingReturns = $days * $daliy * ( $dealOrder->total_price / 10000 );
        $dealOrder->deal_waiting_returns = $waitingReturns;
        $dealOrder->save();
        return $waitingReturns;
    }

    protected static function _calculateFX($dealOrder){
        $start = date_create($dealOrder->create_date);
        $end = date_create($dealOrder->finish_date);
        $daliy = $dealOrder->deal_daliy_returns;
        $today = date_create(date('Y-m-d'));

        if( $today > $end ){
            $diff = date_diff($end,$start);
            $days = $diff->days - 1;
            if( $days % 30 == 0 ){
                $shouyi = 30 * $daliy * ( $dealOrder->total_price / 10000 );

                // 写资金日志
                // Start
                $userMoneyLog = new UserMoneyLog;
                $userMoneyLog->user_id = $dealOrder->member->getKey();
                $userMoneyLog->money = $shouyi; // 收益
                $userMoneyLog->account_money = $dealOrder->member->money + $shouyi;
                $userMoneyLog->can_money = $dealOrder->member->can_money + $shouyi;
                $userMoneyLog->type = UserMoneyLog::TYPE_BALANCE;
                $userMoneyLog->created_at = time();
                $userMoneyLog->create_time_ymd = date('Y-m-d');
                $userMoneyLog->create_time_ym = date('Ym');
                $userMoneyLog->create_time_y = date('Y');
                // $userMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
                $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
                // $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
                $userMoneyLog->save();
                // End

                $dealOrder->member->money = $dealOrder->member->money + $shouyi;
                $dealOrder->member->can_money = $dealOrder->member->can_money + $shouyi;
                $dealOrder->member->save();
            }else{
                $shouyi = ( $days % 30 ) * $daliy * ( $dealOrder->total_price / 10000 );

                // 写资金日志
                // Start
                $userMoneyLog = new UserMoneyLog;
                $userMoneyLog->user_id = $dealOrder->member->getKey();
                $userMoneyLog->money = $shouyi; // 收益
                $userMoneyLog->account_money = $dealOrder->member->money + $shouyi;
                $userMoneyLog->can_money = $dealOrder->member->can_money + $shouyi;
                $userMoneyLog->type = UserMoneyLog::TYPE_BALANCE;
                $userMoneyLog->created_at = time();
                $userMoneyLog->create_time_ymd = date('Y-m-d');
                $userMoneyLog->create_time_ym = date('Ym');
                $userMoneyLog->create_time_y = date('Y');
                // $userMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
                $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
                // $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
                $userMoneyLog->save();
                // End

                $dealOrder->member->money = $dealOrder->member->money + $shouyi;
                $dealOrder->member->can_money = $dealOrder->member->can_money + $shouyi;
                $dealOrder->member->save();
            }
            $days = 0;            
            $dealOrder->order_status = self::ORDER_STATUS_FINISHED;
        }else{
            $diff = date_diff($today,$start,true);
            // if 48 天
            $days = $diff->days - 1;
            if( $days > 0 && $days % 30 == 0 ){
                // 把前三十天的收益划进账户
                $shouyi = 30 * $daliy * ( $dealOrder->total_price / 10000 );

                // 写资金日志
                // Start
                $userMoneyLog = new UserMoneyLog;
                $userMoneyLog->user_id = $dealOrder->member->getKey();
                $userMoneyLog->money = $shouyi; // 收益
                $userMoneyLog->account_money = $dealOrder->member->money + $shouyi;
                $userMoneyLog->can_money = $dealOrder->member->can_money + $shouyi;
                $userMoneyLog->type = UserMoneyLog::TYPE_BALANCE;
                $userMoneyLog->created_at = time();
                $userMoneyLog->create_time_ymd = date('Y-m-d');
                $userMoneyLog->create_time_ym = date('Ym');
                $userMoneyLog->create_time_y = date('Y');
                // $userMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
                $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
                // $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
                $userMoneyLog->save();
                // End

                $dealOrder->member->money = $dealOrder->member->money + $shouyi;
                $dealOrder->member->can_money = $dealOrder->member->can_money + $shouyi;
                $dealOrder->member->save();
            }
            $days = $days % 30;
        }

        // $days = $diff->days - 1;  
        $waitingReturns = $days * $daliy * ( $dealOrder->total_price / 10000 );
        $dealOrder->deal_waiting_returns = $waitingReturns;
        $dealOrder->save();
        return $waitingReturns;
    }

    protected static function _calculateDE(){

    }


    protected static function _signleBuildReturns($dealOrder){
        if( $dealOrder->type == self::TYPE_OFFLINE_ORDER ){
            // session(['count'=>session('count')+1]);
            switch($dealOrder->deal_type){
                case Deal::LOANTYPE_DAOQI :
                    self::_singleCalculateDQ($dealOrder);
                    break;
                case Deal::LOANTYPE_FUXIFANBEN :
                    self::_singleCalculateFX($dealOrder);
                    break;
                case Deal::LOANTYPE_DENGEBENXI :
                    self::_singleCalculateDE($dealOrder);
                    break;
            }
        }
    }

    protected static function _singleCalculateDQ($dealOrder){
        self::_calculateDQ($dealOrder);
    }
    protected static function _singleCalculateFX($dealOrder){

        $start = date_create($dealOrder->create_date);
        $end = date_create($dealOrder->finish_date);
        $daliy = $dealOrder->deal_daliy_returns;
        $today = date_create(date('Y-m-d'));
        if( $today > $end ){
            $diff = date_diff($end,$start);
            $dealOrder->order_status = self::ORDER_STATUS_FINISHED;
            // 收益天数
            $days = 0;
        }else{
            $diff = date_diff($today,$start);
            $days = $diff->days - 1;
        }

        // 月数
        $months = floor($days / 30 );
        $jiecunShouyi = $months * 30 * $daliy * ( $dealOrder->total_price / 10000 );
        if( $jiecunShouyi > 0 ){
            // 写资金日志
            // Start
            $userMoneyLog = new UserMoneyLog;
            $userMoneyLog->user_id = $dealOrder->member->getKey();
            $userMoneyLog->money = $jiecunShouyi; // 收益
            $userMoneyLog->account_money = $dealOrder->member->money + $jiecunShouyi;
            $userMoneyLog->can_money = $dealOrder->member->can_money + $jiecunShouyi;
            $userMoneyLog->type = UserMoneyLog::TYPE_BALANCE;
            $userMoneyLog->created_at = time();
            $userMoneyLog->create_time_ymd = date('Y-m-d');
            $userMoneyLog->create_time_ym = date('Ym');
            $userMoneyLog->create_time_y = date('Y');
            // $userMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
            $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
            // $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
            $userMoneyLog->save();
            // End

            $dealOrder->member->money = $dealOrder->member->money + $jiecunShouyi;
            $dealOrder->member->can_money = $dealOrder->member->can_money + $jiecunShouyi;
            $dealOrder->member->save();
        }

        $waitingReturns = ( $days % 30 ) * $daliy * ( $dealOrder->total_price / 10000 );        
        $dealOrder->deal_waiting_returns = $waitingReturns;
        $dealOrder->save();
        return $waitingReturns;
    }
    protected static function _singleCalculateDE($dealOrder){
        // $start = date_create($dealOrder->create_date);
        // $end = date_create($dealOrder->finish_date);
        // $daliy = $dealOrder->deal_daliy_returns;
        // $today = date_create(date('Y-m-d'));
        // if( $today > $end ){
        //     $diff = date_diff($end,$start);
        //     $dealOrder->order_status = self::ORDER_STATUS_FINISHED;
        //     // 收益天数
        //     $days = 0;
        // }else{
        //     $diff = date_diff($today,$start);
        //     $days = $diff->days - 1;
        // }

        // // 月数
        // $months = floor($days / 30 );
        // $jiecunShouyi = $months * 30 * $daliy * ( $dealOrder->total_price / 10000 );
        // if( $jiecunShouyi > 0 ){
        //     // 写资金日志
        //     // Start
        //     $userMoneyLog = new UserMoneyLog;
        //     $userMoneyLog->user_id = $dealOrder->member->getKey();
        //     $userMoneyLog->money = $jiecunShouyi; // 收益
        //     $userMoneyLog->account_money = $dealOrder->member->money + $jiecunShouyi;
        //     $userMoneyLog->can_money = $dealOrder->member->can_money + $jiecunShouyi;
        //     $userMoneyLog->type = UserMoneyLog::TYPE_BALANCE;
        //     $userMoneyLog->created_at = time();
        //     $userMoneyLog->create_time_ymd = date('Y-m-d');
        //     $userMoneyLog->create_time_ym = date('Ym');
        //     $userMoneyLog->create_time_y = date('Y');
        //     // $userMoneyLog->proof_id = $proofs ? $proofs->getKey() : 0 ;
        //     $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
        //     // $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
        //     $userMoneyLog->save();
        //     // End

        //     $dealOrder->member->money = $dealOrder->member->money + $jiecunShouyi;
        //     $dealOrder->member->can_money = $dealOrder->member->can_money + $jiecunShouyi;
        //     $dealOrder->member->save();
        // }

        // $waitingReturns = ( $days % 30 ) * $daliy * ( $dealOrder->total_price / 10000 );        
        // $dealOrder->deal_waiting_returns = $waitingReturns;
        // $dealOrder->save();
    }
}
