<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','农发众诚资产管理有限公司')</title>
    <link rel="stylesheet" href="/css/app.css">
    @yield('css')
</head>
<body>
    <div id="header" class="clearfix">
        @include('common.header')
    </div>
    <div class="wrap-box clearfix">
        @yield('content')
    </div>
    <div id="footer">
        @include('common.footer')
    </div>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
@yield('js')
</body>
</html>