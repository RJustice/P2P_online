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
    /*width: 95px;*/
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
            <h3 class="h3-title">重置密码</h3>
        </div>
        <div class="line-b"></div>
        <div class="process p_01" style="height:40px;">
            <p style="text-align:center;font-size:18px;font-weight:600;line-height:40px;height:40px;">因该账号为系统后台创建，为保证您的账户安全，所以需要重新设置登录密码才可以正常使用。</p>
            <p style="text-align:center;font-size:18px;font-weight:600;line-height:40px;height:40px;">您绑定的手机号码: {{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}</p>
        </div>
        <div class="register-content">
            {!! Form::open(['method'=>'post','route'=>'sysmember','id'=>'register-form']) !!}
            <div class="f-row">
                <label for="password">短信验证码：</label>
                {!! Form::text('smscode','',['id'=>'smscode','class'=>$errors->has('smscode')?'check-fail':''.' verification-code validate[required]','style'=>'width:56%;float:left;margin-left:0px;']) !!}
                <a class="get-code" id="re-sms" href="javascript:void(0);">获取手机验证码</a>
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
            <div class="f-row clearfix">
                <label for="vercode">验证码：</label>
                {!! Form::text('vercode','',['id'=>'vercode','class'=>$errors->has('vercode')?'check-fail':''.' verification-code validate[required]','style'=>'width:56%;float:left;margin-left:0px;']) !!}
                {!! HTML::image(captcha_src('custom'),'Captcha Img',['id'=>'captcha-img','style'=>'margin-top:6px;margin-right:5px;']) !!}
                <span class="refresh"></span>
                <p class="error-info">@if($errors->has('vercode')) {{ $errors->first('vercode') }} @endif</p>
            </div>
            <div class="f-row">
                <button class="btn-login submit">确认修改</button>
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
                url : '{{ url('sms/send') }}',
                type : 'post',
                data : {_token:'{{ csrf_token() }}'},
                dataType : 'json',
                success : function(data){
                    if( data.status == 0 ){
                        $("#sendTip").text(tip);
                        // alert(data.code);
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