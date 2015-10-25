<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sms;
use Hash;
use App\UserCarry;
use App\UserMoneyLog;
use App\DealOrder;
use App\OrderToRedeem;
use Session;

class FundController extends Controller
{
    protected $member;

    public function __construct(){
        $this->member = auth()->user();
        session(['smsphone'=>$this->member->phone]);
    }

    // public function getRecharge(){

    // }

    // public function postRecharge(){

    // }
    // 
    
    public function getCarry(){
        // $this->member = auth()->user();
        if( ! $this->member->bank ){
            return view('member.errors.nobank');
        }
        return view('member.fund.carry');
    }

    public function postCarry(Request $request){
        $return = [];
        if ($request->ajax()) {
            $bank = $request->get('bank');
            $money = $request->get('money');
            $smscode = $request->get('smscode');
            $paypwd = $request->get('paypwd');
            // $this->member = auth()->user();
            
            if( ! Sms::check($smscode) ){
                $return = [
                    'code' => 1
                ];
                return response()->json($return);
            }
            if( $money > $this->member->can_money ){
                $return = [
                    'code' => 3
                ];
                return response()->json($return);
            }
            if( ! Hash::check($paypwd,$this->member->paypassword) ){
                $return = [
                    'code' => 2
                ];
                return response()->json($return);
            }

            $userCarry = new UserCarry();
            $userCarry->user_id = $this->member->getKey();
            $userCarry->money = $money;
            $userCarry->fee = 0; // 手续费
            $userCarry->bank_id = $this->member->bank->bank_id;
            $userCarry->bank_card = $this->member->bank->bankcard;
            $userCarry->status = UserCarry::STATUS_PENDING;
            $userCarry->real_name = $this->member->name;
            $userCarry->bankzone = $this->member->bank->bankzone;
            $userCarry->region_lv1 = $this->member->bank->region_lv1;
            $userCarry->region_lv2 = $this->member->bank->region_lv2;
            $userCarry->region_lv3 = $this->member->bank->region_lv3;
            $userCarry->region_lv4 = $this->member->bank->region_lv4;

            $userCarry->save();

            $return = [
                'code' => 0
            ];
            Session::forget('sms');
        }
        return response()->json($return);
    }

    public function carryLogs(){
        $logs = UserCarry::where('user_id',$this->member->getKey())->orderBy('id','desc');
        $logs = $logs->paginate(30);
        return view('member.fund.carrylogs',compact('logs'));
    }

    public function carryCancel(Request $request){
        $id = $request->get('carry_id');
        $userCarry = UserCarry::where('id',$id)->where('user_id',$this->member->getKey())->where('status',UserCarry::STATUS_PENDING)->first();
        if( $userCarry ){
            $userCarry->status = UserCarry::STATUS_CANCEL;
            $userCarry->save();
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }

    public function getSummaryDetail(){
        return view('member.fund.summary');
    }

    public function getLogs(){
        $logs = UserMoneyLog::where('user_id',$this->member->getKey())->orderBy('id','desc');
        $logs = $logs->paginate(30);
        return view('member.fund.logs',compact('logs'));
    }


    public function getRedeem($id = 0){
        $dealOrders = $this->member->dealOrders()->where('order_status',DealOrder::ORDER_STATUS_VALID)->get();
        if( $dealOrders->isEmpty() ){
            return view('member.errors.noorder');
        }else{
            return view('member.fund.redeem',compact('dealOrders','id'));
        }
    }

    public function postRedeem(Request $request){
        $return = [];
        if ($request->ajax()) {
            $dealOrderId = $request->get('dealid');
            $smscode = $request->get('smscode');
            $paypwd = $request->get('paypwd');
            $dealOrder = DealOrder::find($dealOrderId);
            if( ! $dealOrder ){
                $return = [
                    'code' => 3
                ];
            }
            if( ! Sms::check($smscode) ){
                $return = [
                    'code' => 1
                ];
                return response()->json($return);
            }
            if( ! Hash::check($paypwd,$this->member->paypassword) ){
                $return = [
                    'code' => 2
                ];
                return response()->json($return);
            }

            $orderToRedeem = new OrderToRedeem;
            $orderToRedeem->order_id = $dealOrder->id;
            $orderToRedeem->order_sn = $dealOrder->order_sn;
            $orderToRedeem->order_money = $dealOrder->total_price;
            $orderToRedeem->order_return = $dealOrder->deal_waiting_returns;
            $orderToRedeem->user_id = $this->member->getKey();
            $orderToRedeem->status = OrderToRedeem::STATUS_PENDING;
            $orderToRedeem->save();

            $return = [
                'code' => 0
            ];
            Session::forget('sms');
        }
        return response()->json($return);
    }

    public function redeemLogs(){

    }

    public function redeemCancel(){

    }
}
