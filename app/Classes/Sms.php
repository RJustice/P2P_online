<?php namespace App\Classes;

use GuzzleHttp\Client;
use App\SmsLog;
use Session;
use Config;
use Response;

class Sms {

    protected $apikey;
    protected $client;
    protected $gateway;

    public function __construct(){
        $this->apikey = Config::get('sms.apikey');
        $this->gateway = Config::get('sms.gateway');
        $this->client = new Client([
                'base_uri' => $this->gateway
            ]);
    }

    public function send($phone,$msg){
        //$code = $this->randCode();
    }

    public function verCode($phone){
        $code = $this->randCode();
        $message = '【农发众诚】尊敬的用户，您的验证码是：' . $code . '，工作人员不会索取，请勿泄露。';
        $params = [
            'mobile' => urlencode($phone),
            'text' => urlencode($message),
            'apikey' => $this->apikey,
        ];
        $response = $this->client->post('',[
                'form_params' => $params
            ]);
        $response = $this->processResponse($response);
        if( $response['statusCode'] == 200 ){
            $yp_response = $response['data'];
            
        }else{
            return false;
        }
    }

    protected function processResponse(Response $response){
        $body = $response->getBody();
        $cnt = $body->getContent();
        $cntArr = json_decode($cnt,true);
        $statusCode = $response->getStatusCode();
        return ['status'=>$statusCode,'data'=$cntArr];
    }

    protected function randCode($len = 6){
        $chars = '0123456789';
        $rand = '';
        for($i==0;$i<$len;$i++){
            $start = mt_rand(1,9);
            $chars = str_shuffle($chars);
            $rand .= substr($chars,$start,1);
        }
        return $rand;
    }
}