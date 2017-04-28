@extends('_layouts.about')
@section('css')
@parent
<style type="text/css">
.about-box .right-box{clear:both;float: none;}
.about-box .right-box .con{margin:20px;}
.about-box .right-box .con-main h2{text-align: center;}
</style>
@stop
@section('content')
<div class="about-box clearfix">
    <div class="beadcrumb-nav">
        <div class="wrap clearfix">
            <h2>
                <a href="{{ url('/') }}">首页</a>
                <img src="/images/arrow03.png" alt="">
                <span id="aboutus"><a href="javascript:;">{{ $page->title }}</a></span>
            </h2>
        </div>
    </div>
    <div class="wrap clearfix com-bg">
        <div class="right-box clearfix">
            <div id="content" class="con clearfix">
                <div class="con-main">
                    <h2>{{ $page->title }}</h2>
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop