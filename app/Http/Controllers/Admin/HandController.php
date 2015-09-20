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
use Form;

class HandController extends Controller
{
    function __construct(){
        parent::__construct('hand','手动操作');
    }


    // 快速充值
    public function getRecharge(){
        return 'get';
    }

    public function postRecharge(){
        return 'post';
    }

    // 快速冻结资金
    public function getFreeze(){

    }

    public function postFreeze(){

    }

    // 快速扣款
    public function getDebit(){

    }

    public function postDebit(){

    }


    // 线下订单录入
    public function getOffline(){
        // check access
        return view("forone::".$this->uri.'.offline');
    }

    public function postOffline(){

    }
}
