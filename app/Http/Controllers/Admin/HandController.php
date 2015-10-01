<?php

namespace App\Http\Controllers\Admin;

use Forone\Admin\Controllers\BaseController as Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Deal;
use App\DealOrder;
use App\DealOrderItem;
use App\User;
use App\UserMoneyLog;
use App\UserLockMoneyLog;
use App\Proof;
use Form;
use Storage;
use Hashids;

class HandController extends Controller
{
    function __construct(){
        parent::__construct('hand','手动操作');
    }


    // 快速充值
    public function getRecharge($uid){
        return view("forone::".$this->uri.'.recharge',compact('uid'));
    }

    public function postRecharge(Request $request){
        $member = User::findOrFail($request->get('uid'));
        $salesManager = auth()->user();
        $proofs = $request->get('proof');
        $proofsLen = $request->get('proof_len');

        // $data = $request->only(['create_date','total_price']);
        $data['create_date'] = date('Y-m-d');
        $data['total_price'] = $request->get('total_price');
        $data['admin_meno'] = $request->get('admin_meno') ? $request->get('admin_meno') : '';

        // $data['deal_title'] = $deal->title;
        // $data['deal_sub_title'] = $deal->sub_title;
        // $data['deal_daliy_returns'] = $deal->daliy_returns;
        // $data['deal_rate'] = $deal->rate;
        // $data['order_status'] = DealOrder::ORDER_STATUS_INVALID;
        
        $data['status'] = DealOrder::STATUS_PENDING;  // 待审核
        $data['user_id'] = $member->getKey();
        $data['type'] = DealOrder::TYPE_OFFLINE_RECHARGE;
        $data['pay_status'] = DealOrder::PAY_STATUS_FINISH;
        $data['pay_amount'] = $data['total_price'];
        // 判断订单状态
        // $data['order_status'] = ( time() - strtotime($data['create_date']) ) > ( ( $deal->repay_time + 1 ) * 24 * 60 * 60 ) ? DealOrder::ORDER_STATUS_FINISHED : DealOrder::ORDER_STATUS_VALID;
        $data['order_status'] = DealOrder::ORDER_STATUS_FINISHED;
        $data['is_deleted'] = 0;
        $data['mobile'] = $member->phone;
        $data['account_money'] = $data['total_price'];
        // $data['referer'] = ''; 
        $data['user_name'] = $member->name;
        // $data['finish_date'] = date('Y-m-d',strtotime("+".($deal->repay_time + 1)." day",strtotime($data['create_date'])));
        $data['finish_date'] = $data['create_date'];
        $data['company_id'] = $salesManager->company_id;
        $data['who_sale'] = $salesManager->getKey();

        $data['order_sn'] = DealOrder::buildSN($data['type']);
        
        // To-do validation 
        $dealOrder = DealOrder::create($data);

        // dd($proofs);
        if( $dealOrder ){
            if( $proofs ){
                $pfiles = [];
                foreach($proofs as $k=>$proof){
                    if( $proofsLen[$k] != strlen($proof) ){
                        continue;
                    }
                    $pfiles[] = $this->_storageProof($proof,$dealOrder->order_sn);
                }

                $proofModel = new Proof();
                //$proofModel->hash_id = Hashids::encode();
                $proofModel->proofs = json_encode($pfiles);
                $proofModel->user_id = $member->getKey();
                $proofModel->type = Proof::TYPE_OFFLINE_RECHARGE;
                $proofModel->type_id = $dealOrder->getKey();
                $proofModel->who_upload = $salesManager->getKey();
                $proofModel->save();
            }
        }

        /*$userMoneyLog = new UserMoneyLog();
        $userMoneyLog->user_id = $member->getKey();
        $userMoneyLog->money = $dealOrder->total_price;
        $userMoneyLog->account_money = $member->money + $dealOrder->total_price;
        $userMoneyLog->can_money = $member->can_money + $dealOrder->total_price;
        $userMoneyLog->type = UserMoneyLog::TYPE_HAND_RECHARGE;
        $userMoneyLog->created_at = strtotime($dealOrder->create_date);
        $userMoneyLog->create_time_ymd = $dealOrder->create_date;
        $userMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
        $userMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
        $userMoneyLog->proof_id = $proofs ? $proofModel->getKey() : 0 ;
        $userMoneyLog->log_type = UserMoneyLog::LOG_TYPE_ADDITION;
        $userMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userMoneyLog->save();


        // 用户资金变化
        $member->money = $member->money + $userMoneyLog->money;
        $member->can_money = $member->can_money + $dealOrder->total_price;
        $member->save();*/


        return redirect()->route('admin.members.show',['id'=>$member->getKey()])->withErrors(['default'=>'操作成功,等待审核']);
    }

    // 快速冻结资金
    public function getFreeze($uid){
        return view("forone::".$this->uri.'.freeze',compact('uid'));
    }

    public function postFreeze(Request $request){
        $member = User::findOrFail($request->get('uid'));
        $salesManager = auth()->user();
        $proofs = $request->get('proof');
        $proofsLen = $request->get('proof_len');

        if( $member->can_money < $request->get('total_price') ){
            return redirect()->route('admin.members.show',['id'=>$member->getKey()])->withErrors(['default'=>'可用资金不足,不能执行冻结操作,请重新核实客户资金']);
        }

        
        $data['create_date'] = date('Y-m-d');
        $data['total_price'] = $request->get('total_price');
        $data['admin_meno'] = $request->get('admin_meno') ? $request->get('admin_meno') : '';

        // $data['deal_title'] = $deal->title;
        // $data['deal_sub_title'] = $deal->sub_title;
        // $data['deal_daliy_returns'] = $deal->daliy_returns;
        // $data['deal_rate'] = $deal->rate;
        // $data['order_status'] = DealOrder::ORDER_STATUS_INVALID;
        
        $data['status'] = DealOrder::STATUS_PENDING;  // 待审核
        $data['user_id'] = $member->getKey();
        $data['type'] = DealOrder::TYPE_HAND_FREEZE;
        $data['pay_status'] = DealOrder::PAY_STATUS_FINISH;
        $data['pay_amount'] = $data['total_price'];
        // 判断订单状态
        // $data['order_status'] = ( time() - strtotime($data['create_date']) ) > ( ( $deal->repay_time + 1 ) * 24 * 60 * 60 ) ? DealOrder::ORDER_STATUS_FINISHED : DealOrder::ORDER_STATUS_VALID;
        $data['order_status'] = DealOrder::ORDER_STATUS_FINISHED;
        $data['is_deleted'] = 0;
        $data['mobile'] = $member->phone;
        $data['account_money'] = $data['total_price'];
        // $data['referer'] = ''; 
        $data['user_name'] = $member->name;
        // $data['finish_date'] = date('Y-m-d',strtotime("+".($deal->repay_time + 1)." day",strtotime($data['create_date'])));
        $data['finish_date'] = $data['create_date'];
        $data['company_id'] = $salesManager->company_id;
        $data['who_sale'] = $salesManager->getKey();

        $data['order_sn'] = DealOrder::buildSN($data['type']);
        
        // To-do validation 
        $dealOrder = DealOrder::create($data);

        // dd($proofs);
        if( $dealOrder ){
            if( $proofs ){
                $pfiles = [];
                foreach($proofs as $k=>$proof){
                    if( $proofsLen[$k] != strlen($proof) ){
                        continue;
                    }
                    $pfiles[] = $this->_storageProof($proof,$dealOrder->order_sn);
                }

                $proofModel = new Proof();
                //$proofModel->hash_id = Hashids::encode();
                $proofModel->proofs = json_encode($pfiles);
                $proofModel->user_id = $member->getKey();
                $proofModel->type = Proof::TYPE_HAND_FREEZE;
                $proofModel->type_id = $dealOrder->getKey();
                $proofModel->who_upload = $salesManager->getKey();
                $proofModel->save();
            }
        }


/*
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
        $userLockMoneyLog->proof_id = $proofs ? $proofModel->getKey() : 0 ;
        $userLockMoneyLog->log_type = UserMoneyLog::LOG_TYPE_LOCK;
        $userLockMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userLockMoneyLog->save();

        // 用户冻结资金变化
        $member->lock_money = $member->lock_money + $userLockMoneyLog->money;
        // 用户可用资金变化
        $member->can_money = $member->can_money - $userLockMoneyLog->money;
        // 保存信息
        $member->save();*/

        return redirect()->route('admin.members.show',['id'=>$member->getKey()])->withErrors(['default'=>'操作成功,等待审核']);

    }

    // 快速扣款
    public function getDebit($uid){
        return view("forone::".$this->uri.'.debit',compact('uid'));
    }

    public function postDebit(Request $request){
        $member = User::findOrFail($request->get('uid'));
        $salesManager = auth()->user();
        $proofs = $request->get('proof');
        $proofsLen = $request->get('proof_len');

        if( $member->can_money < $request->get('total_price') ){
            return redirect()->route('admin.members.show',['id'=>$member->getKey()])->withErrors(['default'=>'可用资金不足,不能执行扣除操作,请重新核实客户资金']);
        }

        // $data = $request->only(['create_date','total_price']);
        $data['create_date'] = date('Y-m-d');
        $data['total_price'] = $request->get('total_price');
        $data['admin_meno'] = $request->get('admin_meno') ? $request->get('admin_meno') : '';

        // $data['deal_title'] = $deal->title;
        // $data['deal_sub_title'] = $deal->sub_title;
        // $data['deal_daliy_returns'] = $deal->daliy_returns;
        // $data['deal_rate'] = $deal->rate;
        // $data['order_status'] = DealOrder::ORDER_STATUS_INVALID;
        
        $data['status'] = DealOrder::STATUS_PENDING;  // 待审核
        $data['user_id'] = $member->getKey();
        $data['type'] = DealOrder::TYPE_HAND_DEBIT;
        $data['pay_status'] = DealOrder::PAY_STATUS_FINISH;
        $data['pay_amount'] = $data['total_price'];
        // 判断订单状态
        // $data['order_status'] = ( time() - strtotime($data['create_date']) ) > ( ( $deal->repay_time + 1 ) * 24 * 60 * 60 ) ? DealOrder::ORDER_STATUS_FINISHED : DealOrder::ORDER_STATUS_VALID;
        $data['order_status'] = DealOrder::ORDER_STATUS_FINISHED;
        $data['is_deleted'] = 0;
        $data['mobile'] = $member->phone;
        $data['account_money'] = $data['total_price'];
        // $data['referer'] = ''; 
        $data['user_name'] = $member->name;
        // $data['finish_date'] = date('Y-m-d',strtotime("+".($deal->repay_time + 1)." day",strtotime($data['create_date'])));
        $data['finish_date'] = $data['create_date'];
        $data['company_id'] = $salesManager->company_id;
        $data['who_sale'] = $salesManager->getKey();

        $data['order_sn'] = DealOrder::buildSN($data['type']);
        
        // To-do validation 
        $dealOrder = DealOrder::create($data);

        // dd($proofs);
        if( $dealOrder ){
            if( $proofs ){
                $pfiles = [];
                foreach($proofs as $k=>$proof){
                    if( $proofsLen[$k] != strlen($proof) ){
                        continue;
                    }
                    $pfiles[] = $this->_storageProof($proof,$dealOrder->order_sn);
                }

                $proofModel = new Proof();
                //$proofModel->hash_id = Hashids::encode();
                $proofModel->proofs = json_encode($pfiles);
                $proofModel->user_id = $member->getKey();
                $proofModel->type = Proof::TYPE_HAND_DEBIT;
                $proofModel->type_id = $dealOrder->getKey();
                $proofModel->who_upload = $salesManager->getKey();
                $proofModel->save();
            }
        }

        /*$userDebitMoneyLog = new UserMoneyLog();
        $userDebitMoneyLog->user_id = $member->getKey();
        $userDebitMoneyLog->money = $dealOrder->total_price;
        $userDebitMoneyLog->account_money = $member->money - $dealOrder->total_price;
        $userDebitMoneyLog->can_money = $member->can_money - $dealOrder->total_price;
        $userDebitMoneyLog->type = UserMoneyLog::TYPE_HAND_DEBIT;
        $userDebitMoneyLog->created_at = strtotime($dealOrder->create_date);
        $userDebitMoneyLog->create_time_ymd = $dealOrder->create_date;
        $userDebitMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
        $userDebitMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
        $userDebitMoneyLog->proof_id = $proofs ? $proofModel->getKey() : 0 ;
        $userDebitMoneyLog->log_type = UserMoneyLog::LOG_TYPE_DEDUCTION;
        $userDebitMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userDebitMoneyLog->save();

        // 用户资金变化
        $member->money = $member->money - $userDebitMoneyLog->money;
        $member->can_money = $member->can_money - $userDebitMoneyLog->money;
        $member->save();*/

        return redirect()->route('admin.members.show',['id'=>$member->getKey()])->withErrors(['default'=>'操作成功,等待审核']);
    }


    // 线下订单录入
    public function getOffline($uid){
        return view("forone::".$this->uri.'.offline',compact('uid'));
    }

    public function postOffline(Request $request){
        $deal = Deal::findOrFail($request->get('deal_id'));
        $member = User::findOrFail($request->get('uid'));
        $salesManager = auth()->user();
        $proofs = $request->get('proof');
        $proofsLen = $request->get('proof_len');

        $data = $request->only(['create_date','total_price']);
        $data['admin_meno'] = $request->get('admin_meno') ? $request->get('admin_meno') : '';
        $data['deal_id'] = $request->get('deal_id');
        $data['deal_title'] = $deal->title;
        $data['deal_sub_title'] = $deal->sub_title;
        $data['deal_daliy_returns'] = $deal->daliy_returns;
        $data['deal_rate'] = $deal->rate;
        $data['deal_type'] = $deal->loan_type;
        // $data['order_status'] = DealOrder::ORDER_STATUS_INVALID;
        $data['status'] = DealOrder::STATUS_PENDING;  // 待审核
        $data['user_id'] = $member->getKey();
        $data['type'] = DealOrder::TYPE_OFFLINE_ORDER;
        $data['pay_status'] = DealOrder::PAY_STATUS_FINISH;
        $data['pay_amount'] = $data['total_price'];
        // 判断订单状态
        $data['order_status'] = ( time() - strtotime($data['create_date']) ) > ( ( $deal->repay_time + 1 ) * 24 * 60 * 60 ) ? DealOrder::ORDER_STATUS_FINISHED : DealOrder::ORDER_STATUS_VALID;
        $data['is_deleted'] = 0;
        $data['mobile'] = $member->phone;
        $data['account_money'] = $data['total_price'];
        // $data['referer'] = ''; 
        $data['user_name'] = $member->name;
        $data['finish_date'] = date('Y-m-d',strtotime("+".($deal->repay_time + 1)." day",strtotime($data['create_date'])));
        $data['company_id'] = $salesManager->company_id;
        $data['who_sale'] = $salesManager->getKey();

        $data['order_sn'] = DealOrder::buildSN(DealOrder::TYPE_OFFLINE_ORDER);
        
        // To-do validation 
        $dealOrder = DealOrder::create($data);

        // dd($proofs);
        if( $dealOrder ){
            if( $proofs ){
                $pfiles = [];
                foreach($proofs as $k=>$proof){
                    if( $proofsLen[$k] != strlen($proof) ){
                        continue;
                    }
                    $pfiles[] = $this->_storageProof($proof,$dealOrder->order_sn);
                }

                $proofModel = new Proof();
                //$proofModel->hash_id = Hashids::encode();
                $proofModel->proofs = json_encode($pfiles);
                $proofModel->user_id = $member->getKey();
                $proofModel->type = Proof::TYPE_OFFLINE_ORDER;
                $proofModel->type_id = $dealOrder->getKey();
                $proofModel->who_upload = $salesManager->getKey();
                $proofModel->save();
            }
        }

        /*$userMoneyLog = new UserMoneyLog();
        $userMoneyLog->user_id = $member->getKey();
        $userMoneyLog->money = $dealOrder->total_price;
        $userMoneyLog->account_money = $member->money + $dealOrder->total_price;
        $userMoneyLog->can_money = $member->can_money + $dealOrder->total_price;
        $userMoneyLog->type = UserMoneyLog::TYPE_OFFLINE_ORDER;
        $userMoneyLog->created_at = strtotime($dealOrder->create_date);
        $userMoneyLog->create_time_ymd = $dealOrder->create_date;
        $userMoneyLog->create_time_ym = date('Ym',strtotime($dealOrder->create_date));
        $userMoneyLog->create_time_y = date('Y',strtotime($dealOrder->create_date));
        $userMoneyLog->proof_id = $proofs ? $proofModel->getKey() : 0 ;
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
        $userLockMoneyLog->proof_id = $proofs ? $proofModel->getKey() : 0 ;
        $userLockMoneyLog->log_type = UserMoneyLog::LOG_TYPE_LOCK;
        $userLockMoneyLog->deal_order_sn = $dealOrder->order_sn;
        $userLockMoneyLog->save();

        // 用户冻结资金变化
        $member->lock_money = $member->lock_money + $userLockMoneyLog->money;
        // 用户可用资金变化
        $member->can_money = $member->can_money - $userLockMoneyLog->money;
        // 保存信息
        $member->save();*/

        return redirect()->route('admin.members.show',['id'=>$member->getKey()])->withErrors(['default'=>'操作成功,等待审核']);
    }

    protected function _storageProof($proof,$sn){
        $path = 'upload/proofs/'.date('Ymd').'/';
        // Storage::makeDirectory($path);
        $fileId = substr($sn,0,2) .'/'. HashIds::connection('proof')->encode(substr($sn, -8)) . mt_rand(1,100) ;
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $proof, $result)){
            $type = $result[2];
            $new_file = $path.$fileId. ".{$type}";
            Storage::put($new_file, base64_decode(str_replace($result[1], '', $proof)));
        }
        return $new_file;
    }
}
