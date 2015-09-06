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
            <img src="/images/process2.png">
        </div>
        <div class="register-content register_confirm">
            {!! Form::open(['method'=>'post','action'=>'Auth\MemberAuthController@postRegister','id'=>'register-form']) !!}
            <p style="float: left;margin-left: 17%;margin-bottom: 10px;font-size: 18px;">
                <span style="color:#999;">验证码已经发送至您的手机：</span>
                <span style="color:#999;">{{ $phone[0] }}</span>
            </p>
            <div class="f-row clearfix">
                <label for="txt_smscode">短信验证码：</label>
                <input type="text" name="txt_smscode" id="txt-smscode" style="width:50%;" class="validate[required] f-l">
                <a style="width:140px;" id="re-sms" class="date gray-span">重新获取验证码</a>
                <p id="send-sms-tip" class="error-hint" style="float: left;width:100%;margin-left:15%;padding:0;color:#f00;line-height: 24px;"></p>
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
    $(document).ready(function(){
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