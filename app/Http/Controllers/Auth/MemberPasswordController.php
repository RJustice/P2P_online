<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Sms;
use Hash;
use App\User;
use Session;

class MemberPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forget(){
        return view('member.pwdforget');
    }

    public function postForget(Request $request){
        $phone = $request->get('phone');
        $member = User::where('phone',$phone)->whereIn('state',[User::STATE_VALID,User::STATE_SYS_CREATED])->first();
        if( ! $member ){
            return redirect()->back()->withErrors(['phone'=>'未找到该用户']);
        }else{
            if( !captcha_check($request->get('vercode')) ){
                return redirect()->back()->withErrors(['vercode'=>'验证码错误']);
            }
            session(['forget'=>'stepone']);
            session(['smsphone'=>$request->get('phone')]);
            session(['pwdphone'=>$request->get('phone')]);
            // $smsStatus = Sms::sendVerCode(Session::get('smsphone'));
            $smsStatus = Sms::testSend(Session::get('smsphone'));
            if( $smsStatus ){
                return redirect()->route('password.forgettwo');
            }else{
                return redirect()->back()->withErrors(['sms'=>Sms::getError()]);
            }
        }
    }

    public function forgetTwo(){
        if( ! Session::has('forget') ){
            return redirect()->route('password.forget');
        }
        return view('member.pwdforgettwo');
    }

    public function postForgetTwo(Request $request){
        if( ! Session::has('forget') ){
            return redirect()->route('password.forget');
        }
    
        if( ! Sms::check($request->get('smscode')) ){
            return redirect()->back()->withErrors(['smscode'=>'验证码错误']);
        }
        
        $member = User::where('phone',session('pwdphone'))->whereIn('state',[User::STATE_VALID,User::STATE_SYS_CREATED])->first();
        if( $member ){
            $member->password = Hash::make($request->get('password'));
            if( $member->state == User::STATE_SYS_CREATED ){
                $member->state = User::STATE_VALID;
            }
            $member->save();
            Session::forget('forget');
            Session::forget('pwdphone');
            Session::forget('smsphone');
            return redirect()->guest('member/auth/login');
        }
    }
}
