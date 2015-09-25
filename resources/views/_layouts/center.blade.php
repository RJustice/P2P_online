<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','用户中心 -- 农发众诚资产管理有限公司')</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/center.css">
    @yield('css')
</head>
<body>
    <div id="header" class="clearfix">
        @include('common.header')
    </div>
    <div class="wrap-box clearfix" style="position:relative;">
        <div class="uc-container clearfix">
        {{-- <div style="width:1000px;margin:auto;margin-top:20px;">
            <img src="/images/centerdemo.jpg" alt="" width="1000">
        </div>
        <div style="background:rgba(0,0,0,0.30);width:100%;height:100%;display:block;position:absolute;top:0;left:0;text-align:center;">
            <h2 style="color:#fff;font-size:32px;margin-top:220px">敬请期待</h2>
        </div> --}}
            <div class="center-left">
                @include('common.centermenu')
            </div>
            <div class="center-right">
                @yield('content')
            </div>
        </div>
    </div>
    <div id="footer">
        @include('common.footer')
    </div>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
@yield('js')
</body>
</html>