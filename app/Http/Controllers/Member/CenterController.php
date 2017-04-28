<?php

namespace App\Http\Controllers\Member;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $dealOrders = auth()->user()->dealOrders()->whereIn('type',[\App\DealOrder::TYPE_OFFLINE_ORDER,\App\DealOrder::TYPE_ONLINE_ORDER,\App\DealOrder::TYPE_POS_INVEST])->where('status',\App\DealOrder::STATUS_PASSED)->where('order_status','<>',\App\DealOrder::ORDER_STATUS_INVALID)->get();
        $data = [
            'ready' => 0,
            'yihuo' => 0,
            'benjin' => 0,
            'lock' => 0,
            'touzi' => [0,0,0,0,0,0,0,0,0,0,0,0],
            'shouyi' => [0,0,0,0,0,0,0,0,0,0,0,0],
            'leiji' => 0,
            'redeem_returns' => 0
        ];
        foreach( $dealOrders as $dealOrder ){
            $m = date('m',strtotime($dealOrder->create_date));
            $end = date_create($dealOrder->finish_date);
            $start = date_create($dealOrder->create_date);
            $now = date_create(date('Y-m-d'));
            if( $dealOrder->order_status == \App\DealOrder::ORDER_STATUS_FINISHED ){
                $diff = date_diff($end,$start);
            }elseif($dealOrder->order_status == \App\DealOrder::ORDER_STATUS_REDEEM || $dealOrder->order_status == \App\DealOrder::ORDER_STATUS_REDEEM_FINISHED ){
                $redeemDate = date_create($dealOrder->redeem_date);
                $diff = date_diff($redeemDate,$start);
            }else{
                $diff = date_diff($now,$start);
            }
            $days = $diff->days - 1;
            $zong = $days * $dealOrder->deal_daily_returns * ( $dealOrder->total_price / 10000 );
            $yihuo = $zong - $dealOrder->deal_waiting_returns;

            $data['ready'] = $data['ready'] + $dealOrder->total_price;
            if( $dealOrder->order_status == \App\DealOrder::ORDER_STATUS_VALID || $dealOrder->order_status == \App\DealOrder::ORDER_STATUS_REDEEM ){
                $data['benjin'] = $data['benjin'] + $dealOrder->total_price;
            }
            // dd($days);
            if( $dealOrder->deal_type == \App\Deal::LOANTYPE_FUXIFANBEN && $days > 30){
                $data['yihuo'] = $data['yihuo'] + $yihuo;

                $m_shouyi = 30 * $dealOrder->deal_daily_returns * ( $dealOrder->total_price / 10000 ) ;
                $n = floor( $yihuo / $m_shouyi );
                for($i=0;$i<$n;$i++){
                    $data['shouyi'][$m+$i] = $m_shouyi;
                }
            }
            $data['touzi'][$m-1] = $data['touzi'][$m-1] + $dealOrder->total_price;
            
            $data['leiji'] = $data['leiji'] + $zong;

            // if( $dealOrder->order_status == \App\DealOrder::ORDER_STATUS_REDEEM || $dealOrder->order_status == \App\DealOrder::ORDER_STATUS_REDEEM_FINISHED ) 
        }
        // dd($data);
        return view('member.center',compact('data'));
    }
}
