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
            @if(Session::has('refresh_error')) <p class="error-info">{{ Session::get('refresh_error') }}</p>@endif
        </div>
        <div class="clearfix">
            <h3 class="h3-title">新用户注册</h3>
            <span class="r-infor">已有账号? <a href="{{ url('member/auth/login') }}">立即登录</a></span>
        </div>
        <div class="line-b"></div>
        <div class="process p_01">
            <img src="/images/process.png">
        </div>
        <div class="register-content">
            {!! Form::open(['method'=>'post','action'=>'Auth\MemberAuthController@postRegister','id'=>'register-form']) !!}
            <div class="f-row">
                <label for="phone">手机号码：</label>
                {!! Form::text('phone',old('phone'),['id'=>'phone','class'=>($errors->has('phone')?'check-fail':'') . ' validate[required,custom[mobile]]','placehoder'=>'请输入手机号码','style'=>'width:78%']) !!}
                <p class="error-info">@if($errors->has('phone')) {{ $errors->first('phone') }} @endif</p>
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
                <label for="rec_user">推荐人：</label>
                {!! Form::text('rec_user','',['id'=>'rec-user','class'=>'validate[funcCall[checkRecUser]]','style'=>'width:78%']) !!}
                <p class="error-info">@if($errors->has('rec_user')) {{ $errors->first('rec_user') }} @endif</p>
            </div>
            <div class="f-row">
                <label for=""></label>
                <input type="checkbox" name="agreement" id="agreement" value="1" checked class="validate[required]">同意<a href="{{ url('member/agreement') }}" target="_blank">《农发众诚用户注册协议》</a>
                <p class="error-info">@if($errors->has('agreement')) {{ $errors->first('agreement') }} @endif</p>
            </div>
            <div class="f-row">
                {!! Form::hidden('step',1) !!}
                <button class="btn-login submit">下一步</button>
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
@stop