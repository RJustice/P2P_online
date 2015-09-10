<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Sms;
use Session;
use Response;

class SmsController extends Controller
{
    public function postSendCode(Request $request){
        $return = [];
        if ($request->ajax()) {
            if( Session::has('smsphone') ){
                $smsStatus = Sms::sendVerCode(Session::get('smsphone'));
                if( $smsStatus ){
                    $return = [
                        'status' => 0,
                        'msg' => 'OK',
                    ];
                }else{
                    $return = [
                        'status' => 1,
                        'msg' => Sms::getError()
                    ];
                }
            }else{
                $return = [
                    'status' => 1,
                    'msg' => '超时，请重新填写信息'
                ];
            }
        }
        return Response::json($return);
    }
}
