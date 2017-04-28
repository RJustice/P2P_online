@extends('_layouts.login')
@section('css')
<style type="text/css">
.wrap-box{width:100%;margin-bottom: 100px;padding: 0;background: #f5f5f5}
.get-code {
    background: #009dde none repeat scroll 0 0;
    border-radius: 3px;
    color: #fff;
    cursor: pointer;
    display: block;
    float: left;
    height: 40px;
    line-height: 40px;
    margin-left: 12px;
    padding: 0 15px;
}
</style>
<link rel="stylesheet" href="/css/validationEngine.jquery.css">
@stop
@section('content')
<div class="wrap-box">
    <div class="wrap clearfix register" id="auth-wrap">
        <div class="clearfix">
            @if(Session::has('refresh_error')) <p class="error-info">{{ Session::get('refresh_error') }}</p>@endif
        </div>
        <div class="clearfix">
            <h3 class="h3-title">密码找回 第二步{{ session('code') }}</h3>
        </div>
        <div class="line-b"></div>
        <div class="register-content">
            {!! Form::open(['method'=>'post','route'=>'password.forgettwo','id'=>'register-form']) !!}
            <div class="f-row">
                <label for="password">短信验证码：</label>
                {!! Form::text('smscode','',['id'=>'smscode','class'=>$errors->has('smscode')?'check-fail':''.' verification-code validate[required]','style'=>'width:78%;']) !!}
                <p class="error-info">@if($errors->has('smscode')) {{ $errors->first('smscode') }} @endif</p>
            </div>
            <div class="f-row">
                <label for="password">密码：</label>
                {!! Form::password('password',['id'=>'password','class'=>'validate[required,funcCall[checkPWD]]','style'=>'width:78%']) !!}
                <p class="error-info">@if($errors->has('password')) {{ $errors->first('password') }} @endif</p>
            </div>
            <div class="f-row">
                <label for="password_confirmation ">确认密码：</label>
                {!! Form::password('password_confirmation ',['id'=>'pwd-confirm','class'=>'validate[required,equals[password]]','style'=>'width:78%']) !!}
                <p class="error-info">@if($errors->has('password_confirmation')) {{ $errors->first('password_confirmation') }} @endif</p>
            </div>
            <div class="f-row">
                <button class="btn-login submit">提交</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('js')
<script src="/js/jquery.validationEngine-zh_CN.js"></script> 
<script src="/js/jquery.validationEngine.min.js"></script>
<script type="text/javascript">
    function checkPWD(field, rules, i, options){
        var pwd = field.val();
        // if( /^.*?[\d]+.*$/.test(str) && /^.*?[A-Za-z]/.test(str) && /^.*?[_@#%].*$/.test(str) && /^.{8,20}$/.test(str) ){
        if( /^.*?[\d]+.*$/.test(pwd) && /^.*?[A-Za-z]/.test(pwd) && /^.{8,20}$/.test(pwd) ){
            return true;
        }else{
            return "密码必须包含数字和字母,可以包含特殊字符,并且大于8位!";
        }        
    }

    function checkRecUser(field, rules, i, options){
        console.log('checkRecUser');
    }
    $(document).ready(function(){
        $("span.refresh").on('click',function(){
            var src = $('#captcha-img').attr('src');
            queryPos = src.indexOf('?');
            if(queryPos != -1) {
               src = src.substring(0, queryPos);
            }    
            $('#captcha-img').attr('src', src + '?' + Math.random());
            return false;
        });
        //  /^.*?[\d]+.*$/.test(str)&&/^.*?[A-Za-z]/.test(str)&&/^.*?[_@#%].*$/.test(str)&&/^.{8,20}$/.test(str)
        

        $('#register-form').validationEngine('attach', { 
          promptPosition: 'centerRight', 
          scroll: false,
          autoHidePrompt:true,
          autoHideDelay:5000,
          addSuccessCssClassToField:'check-success',
          addFailureCssClassToField:'check-fail'
        }); 
    });
</script>
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
        off = 0;

        $("#re-sms").on('click',function(){
            if( off ){
                return;
            }
            leftsecond = 120;
            $("#sendTip").text('短信验证码发送中……，发送至：');
            off = 1;
            $.ajax({
                url : '{{ url('sms/test') }}',
                type : 'post',
                data : {_token:'{{ csrf_token() }}'},
                dataType : 'json',
                success : function(data){
                    if( data.status == 0 ){
                        $("#sendTip").text(tip);
                        alert(data.code);
                    }else{
                        $("#sendTip").text(tip);
                        $("#send-sms-tip").text(data.msg);
                    }
                    clearInterval(timer);
                    timer = setInterval(setLefttime,1000,'1');
                },
                error : function(){
                    off =0;
                }
            });
        });
    });
</script>
@stop