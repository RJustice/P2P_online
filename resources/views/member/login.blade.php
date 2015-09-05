@extends('_layouts.login')
@section('css')
<style type="text/css">
.wrap-box{width:100%;margin-bottom: 100px;padding: 0;background: #f5f5f5}
</style>
<link rel="stylesheet" href="/css/validationEngine.jquery.css">
@stop
@section('content')
<div class="wrap-box">
    <div class="wrap clearfix" id="auth-wrap">
        <div class="login-left">
            &nbsp;
        </div>
        <div class="login-right">
            <div class="login-form">
                <div class="clearfix">
                    <h3 class="h3-title">用户登录</h3>
                    <span class="r-infor">没有账号？<a href="{{ url('member/auth/register') }}">免费注册</a></span>
                </div>                
                <div class="line-b"></div>
                <div class="login-form-innner">
                    {!! Form::open(['method'=>'post','action'=>'Auth\MemberAuthController@getLogin','id'=>'login-form']) !!}
                    <div class="f-row">
                        <input type="text" name="phone" value="{{ old('phone') }}" id="phone" class="formfield validate[required,custom[mobile]]" placeholder="请输入手机号">
                        <p class="error"></p>
                    </div>
                    <div class="f-row">
                        <input type="password" name="password" id="password" class="formfield validate[required]" placeholder="请输入密码">
                        <p class="error"></p>
                    </div>
                    <div class="f-row">
                        <input type="text" name="vercode" id="" class="formfield verification-code validate[required]" placeholder="请输入验证码">
                        {!! HTML::image(captcha_src('custom'),'Captcha Img',['id'=>'captcha-img']) !!}
                        <span class="refresh"></span>
                    </div>
                    <div class="f-row forget">
                        <label for="r_user">
                            <input type="checkbox" name="r_user" id="r-user">记住用户名
                        </label>
                        <a href="{{ route('password.forget') }}">忘记密码</a>
                    </div>
                    <button class="btn-login submit">登录</button>
                    <p class="form-error">
                        @if( count($errors) > 0)
                            @foreach( $errors->all() as $error )
                            {{ $error }}
                            @endforeach
                        @endif
                    </p>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="/js/jquery.validationEngine-zh_CN.js"></script> 
<script src="/js/jquery.validationEngine.min.js"></script>
<script type="text/javascript">
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
        $("#login-form").validationEngine('attach',{
            promptPosition : 'topLeft'
        });
    });
</script>
@stop