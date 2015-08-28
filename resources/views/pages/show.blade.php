@extends('_layouts.default')
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
        <div class="left-box">
            <ul>
            @foreach ( $pages as $p )
                <li class="@if($p->id == $id) select @endif"><a id="page-{{ $p->id }}" href="{{ action('PagesController@show',[$p->id]) }}">{{ $p->title }}</a><i></i></li>
            @endforeach
            </ul>
        </div>
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
@endsection