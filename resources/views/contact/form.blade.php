@extends('_layouts.about')
@section('css')
<style type="text/css">
.wrap-box{width:100%;margin-bottom: 100px;padding: 0;background: #f5f5f5}
</style>
@stop
@section('content')
<div class="about-box clearfix">
    <div class="beadcrumb-nav">
        <div class="wrap clearfix">
            <h2>
                <a href="{{ url('/') }}">首页</a>
                <img src="/images/arrow03.png" alt="">
                <span id="aboutus"><a href="javascript:;">我要理财</a></span>
            </h2>
        </div>
    </div>
    <div class="wrap-box clearfix com-bg">
        <div class="wrap clearfix register" id="auth-wrap">
        <div class="clearfix">
            @if(Session::has('refresh_error')) <p class="error-info">{{ Session::get('refresh_error') }}</p>@endif
        </div>
        <div class="process p_01" style="">
            <p style="text-align:center;font-size:18px;font-weight:600;line-height:40px;height:40px;">欢迎选择我们农发众诚进行投资理财，我们将是您最好的选择。</p>
            <p style="text-align:center;font-size:18px;font-weight:600;line-height:40px;height:40px;">
                请您填写信息，我们会有理财专员跟您联系。<a href="{{ url('contact')}}" style="color:#0697da;">点击查看分公司地图</a>，客服电话：400-6090-290
            </p>
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
</div>
@stop