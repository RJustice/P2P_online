@extends('_layouts.about')
@section('css')
<style type="text/css">
.wrap-box{width:100%;margin-bottom: 30px;padding: 0;background: #f5f5f5}
</style>
@stop
@section('content')
<div class="about-box clearfix">
    <div class="beadcrumb-nav">
        <div class="wrap clearfix">
            <h2>
                <a href="{{ url('/') }}">首页</a>
                <img src="/images/arrow03.png" alt="">
                <span id="aboutus"><a href="javascript:;">我要借款</a></span>
            </h2>
        </div>
    </div>
    <div class="wrap-box clearfix com-bg">
        <div class="wrap clearfix" id="auth-wrap" style="padding:2%">
        <div class="clearfix">
            @if(Session::has('refresh_error')) <p class="error-info">{{ Session::get('refresh_error') }}</p>@endif
        </div>
        <div class="process p_01" style="">
            <p style="text-align:center;font-size:18px;font-weight:600;line-height:40px;height:40px;">欢迎选择我们农发众诚进行借款投资，我们将是您最好的选择。</p>
            <p style="text-align:center;font-size:18px;font-weight:600;line-height:40px;height:40px;">
                稍后我们将有专员跟您联系，我们的客服电话：400-6090-290，欢迎垂询
            </p>
        </div>
    </div>
    </div>
</div>
@stop