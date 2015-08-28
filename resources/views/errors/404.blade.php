@extends('_layouts.default')
@section('content')
<style type="text/css">
    .wrap-box{background:#f5f5f5;border-top: 2px solid #00bef0;padding-bottom: 8%}
    .wrap-404{width:800px;margin:8% auto 0;}
    .wrap-404 .con-l{float:left;width: 289px;}
    .wrap-404 .con-r{float: right;margin-left: 65px;padding-top: 60px;}
    .wrap-404 .con-r h2{font-size: 36px;font-weight: 600;}
    .wrap-404 .con-r p{font-size: 24px;}
    .wrap-404 .con-r p a{color:#e5a802;margin-left: 10px;text-decoration: underline;}
    #footer{margin-top: 0;}
</style>
<div class="wrap">
    <div class="wrap-404">
        <div class="con-l">
            <img src="/images/prompted.jpg" alt="" width="289" height="280">
        </div>
        <div class="con-r">
            <h2>壕,您访问的页面不存在</h2>
            <p>可以<a href="{{ url('/') }}">返回首页</a></p>
            <p>或者<a href="{{ url('/') }}">投资一笔压压惊</a></p>
        </div>
    </div>
</div>
@stop