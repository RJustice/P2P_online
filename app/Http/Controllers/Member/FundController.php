<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FundController extends Controller
{
    // public function getRecharge(){

    // }

    // public function postRecharge(){

    // }
    // 
    
    public function getCarry(){
        return view('member.fund.carry');
    }

    public function postCarry(){
        return redirect()->route('member.fund.carrylogs')->withErrors(['default'=>'ddd']);
    }

    public function carrylogs(){
        return view('member.fund.carrylogs');
    }

    public function getSummaryDetail(){
        return view('member.fund.summary');
    }

    public function getLogs(){
        return view('member.fund.logs');
    }
}
