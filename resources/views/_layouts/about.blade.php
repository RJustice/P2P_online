<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','农发众诚资产管理有限公司')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="description" content="一家专业充实财富管理、投融资服务、信用风险评估与管理、信用数据整合服务、小额贷款行业投资、小微借款咨询服务与交易促成业务于一体的金融咨询服务公司。">
    <meta name="keywords" content="农发众诚 北京 A2P 资产管理 理财管理 年化收益率高 安全">
    <link rel="stylesheet" href="/css/app.css">
    <!-- <link rel="stylesheet" href="css/about.css"> -->
    <style type="text/css">
    #layoutabout{width:100%;background: url(/images/aboutbg.jpg) no-repeat top center #b69159;background-size:100%;padding-top:35px;}
    #layoutabout #header{width:1200px;margin-bottom:35px;}
    #layoutabout .wrap-box {width:1200px;}
    #layoutabout .com-bg{width:1200px;}
    </style>
    @yield('css')
</head>
<body>
    <div id="layoutabout">
        <div id="header" class="clearfix">
            @include('common.header')
        </div>
        <div class="wrap-box clearfix">
            @yield('content')
        </div>
        <!-- @include('main_friend') -->
        <div id="footer">
            @include('common.footer')
        </div>
    </div>
<script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
@yield('js')
</body>
</html>