@extends('_layouts.login')
@section('css')
<style type="text/css">
.wrap-box{width:100%;margin-bottom: 100px;padding: 0;background: #f5f5f5}
</style>
<link rel="stylesheet" href="/css/validationEngine.jquery.css">
@stop
@section('content')
<div class="wrap-box">
    <div class="wrap clearfix register" id="auth-wrap">
        <div class="clearfix">
            <p class="error-info"></p>
        </div>
        <div class="clearfix">
            <h3 class="h3-title">新用户注册</h3>
            <span class="r-infor">已有账号? <a href="{{ url('member/auth/login') }}">立即登录</a></span>
        </div>
        <div class="line-b"></div>
        <div class="process p_02">
            <img src="/images/process2.png" usemap="#reg">
            <map name="reg"><area shape="rect" coords="0,0,120,100" href ="{{ url('member/auth/register') }}" alt="填写账户信息" /></map>
        </div>
        <div class="register-content register_confirm">
            {!! Form::open(['method'=>'post','action'=>'Auth\MemberAuthController@postRegister','id'=>'register-form']) !!}
            <p style="float: left;margin-left: 17%;margin-bottom: 10px;font-size: 18px;">
                <span style="color:#999;" id="sendTip">验证码已经发送至您的手机：</span>
                <span style="color:#999;">{{ $phone }}</span>
            </p>
            <div class="f-row clearfix">
                <label for="txt_smscode">短信验证码：</label>
                <input type="text" name="txt_smscode" id="txt-smscode" style="width:50%;" class="validate[required] f-l">
                <a style="width:140px;" id="re-sms" class="date gray-span">重新获取验证码</a>
                <p id="send-sms-tip" class="error-hint" style="float: left;width:100%;margin-left:15%;padding:0;color:#f00;line-height: 24px;">@if( $errors->has('e') ) {{ $errors->first('e')  }} @elseif( $errors->has('sms')) {{ $errors->first('sms') }} @endif</p>
            </div>
            <div class="matters" style="margin-top:20px;">
                <dl>
                    <dt><i></i>请注意以下事项</dt>
                    <dd>1.根据省份、城市、地区不同，一般会在5秒-5分钟内收到验证码</dd>
                    <dd>2.如果长时间收不到短信请联系客服：400-6090 290</dd>
                </dl>
            </div>
            <div class="f-row">
                <button class="btn-login submit" type="submit" >验证并注册</button>
            </div>
            {!! Form::hidden('step',2) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('js')
<script src="/js/jquery.validationEngine-zh_CN.js"></script> 
<script src="/js/jquery.validationEngine.min.js"></script>
<script type="text/javascript">
    var seconds = 0;
    var mbTest = /^(1)[0-9]{10}$/;
    var timer = null;
    var leftsecond = 120; //倒计时
    var msg = "";
    var off = 1;
    var tip = $("#sendTip").text();

    function setLefttime(){
        var second = Math.floor(leftsecond);
        $('#re-sms').addClass('gray-span');
        $("#re-sms").html(msg + leftsecond + "秒后可重发");
        leftsecond--;
        off = 1;
        if (leftsecond < 1) {
            clearInterval(timer);
            try {
                $("#re-sms").html("重新获取验证码");
                document.getElementById('re-sms').disabled = false;
                off = 0;
            } catch (E) { }
            return;
        }
    }

    $(document).ready(function(){
        $('#register-form').validationEngine('attach', { 
          promptPosition: 'centerRight', 
          scroll: false,
          autoHidePrompt:true,
          autoHideDelay:5000,
          addSuccessCssClassToField:'check-success',
          addFailureCssClassToField:'check-fail'
        });

        clearInterval(timer);
        timer = setInterval(setLefttime,1000,'1');

        $("#re-sms").on('click',function(){
            if( off ){
                return;
            }
            leftsecond = 120;
            $("#sendTip").text('短信验证码发送中……，发送至：');
            off = 1;
            $.ajax({
                url : '{{ url('sms/send') }}',
                type : 'post',
                data : {_token:'{{ csrf_token() }}'},
                dataType : 'json',
                success : function(data){
                    if( data.status == 0 ){
                        $("#sendTip").text(tip);
                    }else{
                        $("#sendTip").text(tip);
                        $("#send-sms-tip").text(data.msg);
                    }
                    clearInterval(timer);
                    timer = setInterval(setLefttime,1000,'1');
                },
                error : function(){

                }
            });
        });
    });
</script>
@stop