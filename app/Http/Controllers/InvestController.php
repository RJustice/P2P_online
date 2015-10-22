<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Deal;
use App\DealOrder;
use Form,Html,Hash,Auth,Validator;

class InvestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     * @return Response
     */
    public function index()
    {
        $deals = Deal::where('is_effect',1)->where('is_deleted',0)->where('published',1)->orderByRaw('sort desc')->get();
        return view('invest.index',compact('deals'));
    }

    public function checkmoney(){
        if( ! Auth::check() ){
            return response()->json(['code'=>2,'balance'=>0],200);
        }
        $member = auth()->user();
        if( $member->can_money <= 0 ){
            return response()->json(['code'=>1,'balance'=>$member->can_money]);
        }

        return response()->json(['code'=>3,'balance'=>$member->can_money]);
    }

    public function doinvest(Request $request){
        if(! Auth::check() ){
            return response()->json(['code'=>6],200);
        }
        $member = auth()->user();
        if( ! $member->paypassword ){
            return response()->json(['code'=>5],200);
        }
        $id = $request->get('id');
        $deal = Deal::find($id);
        if( $deal ){
            $paypass = $request->get('paypass');
            $money = $request->get('money');
            if( $money > $member->can_money ){
                return response()->json(['code'=>2],200);
            }
            if( ! Hash::check($paypass,$member->paypassword) ){
                return response()->json(['code'=>3],200);
            }

            $data['total_price'] = $money;
            $data['create_date'] = date('Y-m-d');
            $data['admin_meno'] = $request->get('admin_meno') ? $request->get('admin_meno') : '';
            $data['deal_id'] = $deal->getKey();
            $data['deal_title'] = $deal->title;
            $data['deal_sub_title'] = $deal->sub_title;
            $data['deal_daily_returns'] = $deal->daily_returns;
            $data['deal_rate'] = $deal->rate;
            $data['deal_type'] = $deal->loan_type;
            $data['status'] = DealOrder::STATUS_PASSED;  
            $data['user_id'] = $member->getKey();
            $data['type'] = DealOrder::TYPE_ONLINE_ORDER;
            $data['pay_status'] = DealOrder::PAY_STATUS_FINISH;
            $data['pay_amount'] = $money;
            // 判断订单状态
            $data['order_status'] = DealOrder::ORDER_STATUS_VALID;
            $data['is_deleted'] = 0;
            $data['mobile'] = $member->phone;
            $data['account_money'] = $money;
            // $data['referer'] = ''; 
            $data['user_name'] = $member->name;
            $data['finish_date'] = date('Y-m-d',strtotime("+".($deal->repay_time + 1)." day",strtotime(date('Y-m-d'))));
            $data['company_id'] = 1;
            $data['who_sale'] = 1;

            $data['order_sn'] = DealOrder::buildSN(DealOrder::TYPE_ONLINE_ORDER);

            $dealOrder = DealOrder::create($data);

            return response()->json(['code'=>1],200); 
        }else{
            return response()->json(['code'=>4],200);
        }
    }

    public function posinvest(Request $request){
        // return '<script>console.log(parent.$(".money-input"))</script>';
        $validator = Validator::make(['pospic'=>$request->file('pospic')], [
            'pospic' => 'image|max:500',
        ]);
        
        if( $validator->fails() || !$request->file('pospic')->isValid() ){
            return '<script>parent.pospicErrorAlert.open();parent.$("#pos-invest #pinvest-step2").hide();
                            parent.$("#pos-invest #pinvest-step1").show();</script>';
        }
        
        if(! Auth::check() ){
            // return response()->json(['code'=>6],200);
            return '<script>parent.balanceInvestModal.close();parent.notSignAlert.open();</script>';
        }
        $member = auth()->user();
        if( ! $member->paypassword ){
            // return response()->json(['code'=>2],200);
            return '<script>parent.balanceInvestModal.close();parent.noPaypassAlert.open();</script>';
        }
        $id = $request->get('id');
        $deal = Deal::find($id);
        if( $deal ){
            $paypass = $request->get('paypass');
            $money = $request->get('money');

            if( ! Hash::check($paypass,$member->paypassword) ){
                // return response()->json(['code'=>3],200);
                return '<script>parent.paypassErrorAlert.open();parent.$("#pos-invest #pinvest-step2").hide();
                            parent.$("#pos-invest #pinvest-step1").show();</script>';
            }

            $data['total_price'] = $money;
            $data['create_date'] = date('Y-m-d');
            $data['admin_meno'] = $request->get('admin_meno') ? $request->get('admin_meno') : '';
            $data['deal_id'] = $deal->getKey();
            $data['deal_title'] = $deal->title;
            $data['deal_sub_title'] = $deal->sub_title;
            $data['deal_daily_returns'] = $deal->daily_returns;
            $data['deal_rate'] = $deal->rate;
            $data['deal_type'] = $deal->loan_type;
            // $data['order_status'] = DealOrder::ORDER_STATUS_INVALID;
            $data['status'] = DealOrder::STATUS_PENDING;  // 待审核
            $data['user_id'] = $member->getKey();
            $data['type'] = DealOrder::TYPE_POST_INVEST;
            $data['pay_status'] = DealOrder::PAY_STATUS_FINISH;
            $data['pay_amount'] = $money;
            // 判断订单状态
            $data['order_status'] = DealOrder::ORDER_STATUS_INVALID;  // 未通过,失效状态
            $data['is_deleted'] = 0;
            $data['mobile'] = $member->phone;
            $data['account_money'] = $money;
            // $data['referer'] = ''; 
            $data['user_name'] = $member->name;
            $data['finish_date'] = date('Y-m-d',strtotime("+".($deal->repay_time + 1)." day",strtotime(date('Y-m-d'))));
            $data['company_id'] = 1;
            $data['who_sale'] = 1;

            $data['order_sn'] = DealOrder::buildSN(DealOrder::TYPE_POST_INVEST);

            // 上传文件
            $file = $request->file('pospic');
            $clientName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newName = md5(date('ymdhis').$clientName).".".$extension;
            $path = $file->move('uploads/pos/'.date('Ymd'),$newName);
            $data['pospic'] = $path;
            $data['posno'] = $request->get('posno');
            $dealOrder = DealOrder::create($data);

            // return response()->json(['code'=>1],200); 
            return '<script>parent.$("#pos-invest #pinvest-step2").hide();parent.$("#pos-invest #pinvest-step3").show();setTimeout("parent.balanceInvestModal.close()",5000)</script>';
        }else{
            // return response()->json(['code'=>4],200);
            return '<script>parent.balanceInvestModal.close();parent.dealErrorAlert.open();</script>';
        }
    }
}
