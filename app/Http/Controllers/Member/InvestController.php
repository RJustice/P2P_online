<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Deal;
use App\DealOrder;
use App\User;

class InvestController extends Controller
{
    protected $member;

    public function __construct(){
        $this->member = auth()->user();
    }

    public function index(){
        $dealOrders = $this->member->dealOrders()->with('borrowers')->whereIn('type',[DealOrder::TYPE_OFFLINE_ORDER,DealOrder::TYPE_ONLINE_ORDER,DealOrder::TYPE_POS_INVEST])->where('status',DealOrder::STATUS_PASSED)->where('is_deleted',0)->orderBy('id','desc');
        $dealOrders = $dealOrders->paginate(20);
        return view('member.invest.index',compact('dealOrders'));
    }
}
