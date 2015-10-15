@extends('_layouts.about')
@section('css')
<style type="text/css">
.wrap-box{width:100%;margin-bottom: 100px;padding: 0;background: #f5f5f5}
</style>
<link rel="stylesheet" href="/css/validationEngine.jquery.css">
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
            {!! Form::open(['method'=>'post','action'=>'ContactController@licai','id'=>'contact-form']) !!}
            <div class="f-row">
                <label for="title">您的称呼：</label>
                {!! Form::text('title',old('title'),['id'=>'title','class'=>($errors->has('title')?'check-fail':'') . ' validate[required]','placehoder'=>'请如您的称呼','style'=>'width:78%']) !!}
            </div>
            <div class="f-row">
                <label for="phone">手机号码：</label>
                {!! Form::text('phone',old('title'),['id'=>'phone','class'=>'validate[required]','style'=>'width:78%']) !!}
                <p class="error-info">@if($errors->has('phone')) {{ $errors->first('phone') }} @endif</p>
            </div>
            <div class="f-row">
                <label for="password_confirmation ">留言：</label>
                {!! Form::textarea('msg',old('msg'),['id'=>'msg','class'=>'','style'=>'width:78%']) !!}
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
                <button class="btn-login submit">提交</button>
            </div>
            {!! Form::close() !!}
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

        $('#contact-form').validationEngine('attach', { 
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