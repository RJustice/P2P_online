<?php namespace App\Classes;

use GuzzleHttp\Client;
use App\SmsLog;
use Session;
use Config;
use Psr\Http\Message\ResponseInterface;
use Hash;

class Sms {

    protected $apikey = '';
    protected $client = '';
    protected $gateway = '';
    protected $error = '';
    protected $code = '';
    protected $request;

    public function __construct(){
        $this->apikey = Config::get('sms.apikey');
        $this->gateway = Config::get('sms.gateway');
        $this->client = new Client();
    }

    public function send(){
        //$code = $this->randCode();
        // Session::flush();
        return Session::has('sms');
    }

    public function sendVerCode($phone){
        if( Session::has('sms') && time() - Session::get('sms.sendtime') < 120 ){
            $this->setError('发送太频繁,请稍后发送');
            return false;
        }
        
        if( SmsLog::Where('phone',Session::get('sms.phone'))->today()->count() > 10 ){
            $this->setError('发送太频繁,请明天再来');
            return false;
        }

        $code = $this->randCode();
        $message = '【农发众诚】尊敬的用户，您的验证码是：'.$code.'，工作人员不会索取，请勿泄露。';
        Session::put('sms',[
            'sendtime' => time(),
            'code' => Hash::make($code),
            'count' => 0,
            'phone' => $phone
        ]);
        $params = [
            'mobile' => $phone,
            'text' => $message,
            'apikey' => $this->apikey,
        ];
        $res = $this->client->post($this->gateway,[
                'form_params' => $params
            ]);
        $response = $this->processResponse($res);
        /*$response = [
            'statusCode' => 200,
            'data' => [
                'code' => 0,
                'msg' => 'OK',
                'result' => [
                    'count' => 1,
                    'fee' => 1,
                    'sid' => 2988887233
                ]
            ]
        ];
        $this->code = $code;
        */
        
        if( $response['statusCode'] == 200 ){
 /*           {
                  "code": 0,
                  "msg": "OK",
                  "result": {
                    "count": 1,
                    "fee": 1,
                    "sid": 2988887233
                  }
                }
*/
            $yp_response = $response['data'];
            if( $yp_response['code'] == 0 || $yp_response['msg'] == 'OK' ){
                SmsLog::create([
                    'phone'=>Session::get('sms.phone'),
                    'type'=>SmsLog::TYPE_VERCODE,
                    'code'=>$code,
                    'sms_state'=>$yp_response['msg'],
                    'smsid'=>$yp_response['result']['sid'],
                    'message' => $message,
                    // 'ip' => Request::getClientIp()
                ]);
            }elseif($yp_response['code'] == 22){
                $this->setError('验证码发送太频繁,一小时内同一号码只能发送3次,请稍后再获取!');
                return false;
            }else{
                $this->setError('验证短信发送失败,请稍后再获取');
                return false;
            }
            return true;
        }else{
            $this->setError('网络错误');
            return false;
        }
    }

    public function check($code=''){
        if( Session::has('sms') && !empty($code) ){
            $count = Session::get('sms.count');
            Session::put('sms.count',$count+1);
            if( Session::get('sms.count') > 5 ){
                $this->setError('验证次数过多,请重新获取验证码');
                Session::forget('sms');
                return false;
            }
            $sendtime = Session::get('sms.sendtime');
            $smscode = Session::get('sms.code');
            $now = time();
            if( $now - $sendtime > 1800 ){
                $this->setError('验证码超时失效');
                return false;
            }
            if( ! Hash::check($code,$smscode) ){
                $this->setError('验证码不正确');
                return false;
            }
            // SmsLog::updateLog(Session::get('sms'));
            Session::forget('sms');
            return true;
        }else{
            $this->setError('验证码不正确!!!');
            return false;
        }
    }

    public function getError(){
        return $this->error;
    }

    protected function setError($error){
        $this->error = $error;
    }

    protected function processResponse(ResponseInterface $response){
        $body = $response->getBody();
        $cnt = $body->getContents();
        $cntArr = json_decode($cnt,true);
        $statusCode = $response->getStatusCode();
        return ['statusCode'=>$statusCode,'data'=>$cntArr];
    }

    protected function randCode($len = 6){
        $chars = '0123456789';
        $rand = '';
        for($i=0;$i<$len;$i++){
            $start = mt_rand(1,9);
            $chars = str_shuffle($chars);
            $rand .= substr($chars,$start,1);
        }
        return $rand;
    }
}