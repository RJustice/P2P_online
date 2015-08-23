<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','P2P Online System')</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div id="header" class="clearfix">
        @include('demo.common.header')
    </div>
    @yield('main_ad')
    <div class="wrap-box clearfix">
        @yield('content')
    </div>
    <!-- @include('demo.main_friend') -->
    <div id="footer">
        @include('demo.common.footer')
    </div>
<script type="text/javascript" src="/js/app.js"></script>
</body>
</html>