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
            <h3 class="h3-title">密码找回</h3>
        </div>
        <div class="line-b"></div>
        <div class="register-content">
            {!! Form::open(['method'=>'post','route'=>'password.forget','id'=>'register-form']) !!}
            <div class="f-row">
                <label for="phone">绑定的手机号码：</label>
                {!! Form::text('phone',old('phone'),['id'=>'phone','class'=>($errors->has('phone')?'check-fail':'') . ' validate[required,custom[mobile]]','placehoder'=>'请输入手机号码','style'=>'width:78%']) !!}
                <p class="error-info">@if($errors->has('phone')) {{ $errors->first('phone') }} @endif</p>
            </div>
            <div class="f-row clearfix">
                <label for="vercode">验证码：</label>
                {!! Form::text('vercode','',['id'=>'vercode','class'=>$errors->has('vercode')?'check-fail':''.' verification-code validate[required]','style'=>'width:56%;float:left;margin-left:0px;']) !!}
                {!! HTML::image(captcha_src('custom'),'Captcha Img',['id'=>'captcha-img','style'=>'margin-top:6px;margin-right:5px;']) !!}
                <span class="refresh"></span>
                <p class="error-info">@if($errors->has('vercode')) {{ $errors->first('vercode') }} @endif</p>
            </div>
            <div class="f-row">
                <button class="btn-login submit">发送验证码</button>
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