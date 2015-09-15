@extends('demo._layouts.default')
@section('content')
<div class="about-box clearfix">
    <div class="beadcrumb-nav">
        <div class="wrap clearfix">
            <h2>
                <a href="{{ url('/demo') }}">首页</a>
                <img src="/images/arrow03.png" alt="">
                <span id="aboutus"><a href="">关于我们</a></span>
            </h2>
        </div>
    </div>
    <div class="wrap clearfix com-bg">
        <div class="left-box">
            <ul>
                <li class="select"><a id="jianjie" href="#">平台介绍</a><i></i></li>
                <li><a id="gltd" href="#">管理团队</a><i></i></li>
                <li><a id="gszz" href="#">荣誉资质</a><i></i></li>
                <li><a id="aqbz" href="#">安全保障</a><i></i></li>
                <li><a id="ystk" href="#">合作伙伴</a><i></i></li>
                <li><a id="fwsm" href="#">服务说明</a><i></i></li>
                <li><a id="jrwm" href="#">加入我们</a><i></i></li>
                <li><a id="lxwom" href="#">联系我们</a><i></i></li>
                <li><a id="xszy" href="#">新手指引</a><i></i></li>
            </ul>
        </div>
        <div class="right-box clearfix">
            <div id="content" class="con clearfix">
                <div class="con-main">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop