<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','P2P Online System')</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div id="header">
        @include('demo.common.loginheader')
    </div>
    <div id="wrap">
        @yield('content')
    </div>
    <div id="footer">
        @include('demo.common.footer')
    </div>
<script type="text/javascript" src="/js/app.js"></script>
</body>
</html>