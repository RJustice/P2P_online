<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use Sms;
use Session;
use Validator;
use App\Bank;
use App\UserBank;

class AccountController extends Controller
{
    protected $member = '';

    public function __construct(){
        $this->member = auth()->user();
        // Session::put()
        if( !Session::has('smsphone') ){
            session(['smsphone'=>$this->member->phone]);
        }
    }

    public function getBasic(){
        return view('member.account.basic');
    }

    public function postBasic(Request $request){
        $this->member->address = $request->get('address');
        $this->member->province_id = $request->get('province_id');
        $this->member->city_id = $request->get('city_id');
        $this->member->county_id = $request->get('county_id');
        $this->member->sex = $request->get('sex');
        $this->member->email = $request->get('email');
        $this->member->save();
        return redirect()->route('member.account.basic');
    }

    public function getAuthenticate(){
        return view('member.account.authenticate');
    }

    public function postAuthenticate(Request $request){
        $real_name = $request->get('real_name');
        $idno = $request->get('idno');        
        if( ! $this->_validationFilterIDcard($idno) ){
            return redirect()->back()->withErrors(['error'=>'认证信息不正确,请核对信息重新提交']);
        }else{
            $this->member->idcardpassed = 1;
            $this->member->idno = $idno;
            $this->member->name = $real_name;
            $this->member->real_name = $real_name;
            $this->member->save();
            return redirect()->back();
        }
    }

    protected function _validationFilterIDcard($id_card){
        if(strlen($id_card)==18){
            return $this->_IDcardCheckSum18($id_card);
        }elseif((strlen($id_card)==15)){
            $id_card=$this->_IDcard15To18($id_card);
            return $this->_IDcardCheckSum18($id_card);
        }else{
            return false;
        }
    }
    // 计算身份证校验码，根据国家标准GB 11643-1999 
    protected function _IDcardVerifyNumber($idcard_base){
        if(strlen($idcard_base)!=17){
            return false;
        }
        //加权因子 
        $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        //校验码对应值 
        $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
        $checksum=0;
        for($i=0;$i<strlen($idcard_base);$i++){
            $checksum += substr($idcard_base,$i,1) * $factor[$i];
        }
        $mod=$checksum % 11;
        $verify_number=$verify_number_list[$mod];
        return $verify_number;
    }
    // 将15位身份证升级到18位 
    protected function _IDcard15To18($idcard){
        if(strlen($idcard)!=15){
            return false;
        }else{
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码 
            if(array_search(substr($idcard,12,3),array('996','997','998','999')) !== false){
                $idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
            }else{
                $idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
            }
        }
        $idcard=$idcard.$this->_IDcardVerifyNumber($idcard);
        return $idcard;
    }
    // 18位身份证校验码有效性检查 
    protected function _IDcardCheckSum18($idcard){
        if(strlen($idcard)!=18){
            return false;
        }
        $idcard_base=substr($idcard,0,17);
        if($this->_IDcardVerifyNumber($idcard_base)!=strtoupper(substr($idcard,17,1))){
            return false;
        }else{
            return true;
        }
    }

    public function getBankcard(){
        
        if( $this->member->idcardpassed == 0 ){
            return view('member.errors.noauth');
        }
        if( $this->member->bank ){
            return view('member.account.bankcard_list',['bank'=>$this->member->bank]);
        }else{
            return view('member.account.bankcard');
        }
    }

    public function postBankcard(Request $request){
        if( $this->member->idcardpassed == 0 ){
            return view('member.errors.noauth');
        }

        $smscode = $request->get('smscode');
        $bank = Bank::find($request->get('bank'));
        if( ! $bank ){
            return redirect()->back()->withErrors(['error'=>'暂时不支持该银行的银行卡绑定']);
        }

        if( $this->member->bank ){
            $userBank = $this->member->bank;
        }else{
            $userBank = new Userbank();
        }
        
        $userBank->user_id = $this->member->getKey();
        $userBank->bank_id = $request->get('bank');
        $userBank->bank_name = $bank->name;
        $userBank->bankcard = $request->get('bankcard');
        $userBank->real_name = $this->member->name;
        $userBank->bankzone = $request->get('bankzone');
        $userBank->region_lv1 = 1;
        $userBank->region_lv2 = $request->get('province_id');
        $userBank->region_lv3 = $request->get('city_id');
        $userBank->region_lv4 = $request->get('county_id');

        $userBank->save();

        return redirect()->route('member.account.bankcard')->withErrors(['message'=>'添加成功']);
    }

    public function getSafe(){
        return view('member.account.safe');
    }

    public function postSafe(){
        
    }

    // 支付密码
    public function getResetPay($ctl){
        if( in_array($ctl,['find','change','new']) ){
            if( $ctl == 'new' && $this->member->paypassword ){
                return redirect()->route('member.account.resetpay.{ctl}',['ctl'=>'change']);
            }
            return view('member.account.resetpay',compact('ctl'));
        }else{
            return abort(404);
        }
    }

    public function postResetPay(Request $request){
        $data = $request->only(['oldpwd','newpwd','newpwd_confirmation','smscode']);
        $validator = Validator::make($data, [
            // 'oldpwd' => 'required',
            'newpwd' => 'required|confirmed',
            // 'smscode' => 'required'
        ]);
        $ctl = $request->get('ctl');
        if( in_array($ctl,['find','change','new']) ){
            if( $ctl == 'new' && $this->member->paypassword ){
                return redirect()->route('member.account.resetpay.{ctl}',['ctl'=>'change']);
            }

            if ($validator->fails()) {
                return redirect()->route('member.account.resetpay.{ctl}',['ctl'=>$request->get('ctl')])->withErrors($validator);
            }else{
                $smscode = $request->get('smscode');
                switch($ctl){
                    case 'find':
                        if( ! Sms::check($smscode) ){
                            return redirect()->back()->withErrors(['error'=>Sms::getError()]);
                        }
                        $this->member->paypassword = Hash::make($data['newpwd']);
                        $this->member->save();
                        break;
                    case 'new':
                        if( ! Sms::check($smscode) ){
                            return redirect()->back()->withErrors(['error'=>Sms::getError()]);
                        }
                        if( ! Hash::check($data['oldpwd'],$this->member->password) ){
                            return redirect()->back()->withErrors(['error'=>'登录密码错误']);
                        }
                        $this->member->paypassword = Hash::make($data['newpwd']);
                        $this->member->save();
                        break;
                    case 'change':
                        if( ! Hash::check($data['oldpwd'],$this->member->paypassword) ){
                            return redirect()->back()->withErrors(['error'=>'原始密码错误']);
                        }
                        $this->member->paypassword = Hash::make($data['newpwd']);
                        $this->member->save();
                        break;
                    default:
                        return abort(404);
                        break;
                }

                return redirect()->route('member.account.safe')->withErrors(['message'=>'设置成功']);
            }
        }else{
            return abort(404);
        }
    }

    // end

    public function getResetPWD(){
        return view('member.account.resetpwd');
    }

    public function postResetPWD(Request $request){
        $data = $request->only(['oldpwd','newpwd','newpwd_confirmation','smscode']);
        $validator = Validator::make($data, [
            'oldpwd' => 'required',
            'newpwd' => 'required|confirmed',
            'smscode' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('member.account.resetpwd')->withErrors($validator);
        }else{
            if( ! Sms::check($data['smscode']) ){
                return redirect()->route('member.account.resetpwd')->withErrors(['e'=>Sms::getError()]);
            }
            if( ! Hash::check($data['oldpwd'],$this->member->password ) ){
                return redirect()->route('member.account.resetpwd')->withErrors(['e'=>'密码错误']);
            }

            $this->member->password = Hash::make($data['newpwd']);
            $this->member->save();
            return redirect()->route('member')->withErrors(['e'=>'密码修改成功']);
        }

    }


    public function getResetPhoneOne(){
        return view('member.account.resetphoneone');
    }

    public function getResetPhoneTwo(){
        if( session('resetphoneone') ){
            return view('member.account.resetphonetwo');
        }else{
            return redirect()->route('member.account.resetphone.one');
        }
    }

    public function postResetPhoneOne(Request $request){
        $code = $request->get('old_tel_code');
        if( Sms::check($code) ){
            session(['resetphoneone'=>true]);
            return redirect()->route('member.account.resetphone.two');
        }else{
            return redirect()->route('member.account.resetphone.one')->withErrors(['error'=>Sms::getError()]);
        }
    }

    public function postResetPhoneTwo(Request $request){
        if( session('resetphoneone') ){
            $code = $request->get('new_tel_code');
            if( Sms::check($code) ){
                $this->member->phone = $request->get('new_tel');
                $this->member->save();
                Session::forget('resetphoneone');
                Session::forget('sms');
                return redirect()->route('member.account.basic')->withErrors(['message'=>'手机修改成功']);
            }else{
                dd(1,Sms::getError());
                return redirect()->route('member.account.resetphone.two')->withErrors(['error'=>Sms::getError]);
            }
        }else{
            dd(2,Sms::getError());
            return redirect()->route('member.account.resetphone.one');
        }
    }
}
