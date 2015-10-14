<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Sms;
use Hash;

class MemberExtraController extends Controller
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function getSysMemberResetPWD(){
        if( $this->auth->guest() ){
            return redirect()->guest('member/auth/login');
        }
        if( auth()->user()->state == User::STATE_SYS_CREATED ){
            session(['smsphone'=>auth()->user()->phone]);
            return view('member.sysmemberresetpwd');
        }else{
            return redirect()->route('member');
        }
    }

    public function postSysMemberResetPWD(Request $request){
        if( $this->auth->guest() ){
            return redirect()->guest('member/auth/login');
        }
        if( auth()->user()->state == User::STATE_SYS_CREATED ){
            // $data = $request->only('smscode','password','password_confirmation','vercode');
            if( !captcha_check($request->get('vercode')) ){
                return redirect()->back()->withErrors(['vercode'=>'验证码错误']);
            }
            if( ! Sms::check($request->get('smscode')) ){
                return redirect()->back()->withErrors(['smscode'=>'验证码错误']);
            }
            auth()->user()->password = Hash::make($request->get('password'));
            auth()->user()->state = User::STATE_VALID;
            auth()->user()->save();
            return redirect()->route('member');
        }else{
            return redirect()->route('member');
        }
    }
}
