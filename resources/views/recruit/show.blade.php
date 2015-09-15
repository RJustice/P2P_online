@extends('_layouts.about')
@section('css')
<style type="text/css">
.recruit-box{width:900px;background: #b69159;min-height:400px;padding:40px 50px 90px;}
.recruitment-list{width:200px;min-height:400px;}
.title-4edge{display: inline-block;font-size: 18px;font-weight: bold;padding: 0 50px;transform: skew(-15deg);background-color: #fff;color: #b69159;}
.recruitment-list ul{margin-top:25px;padding-left:40px;}
.recruitment-list ul li{font-size: 16px;line-height: 30px;list-style:none;}
.recruitment-list ul li a{text-decoration: none;color: rgba(255, 255, 255, 0.6);}
.recruitment-list ul li.current{}
.recruitment-list ul li.current a{color:#fff;}
.recruitment{border-left:1px solid #fff;margin-top:40px;width:670px;padding-left:20px;color:#fff;}
.recruitment h2{font-size:30px;color:#fff;margin-bottom:15px;}
.recruitment p{color:#fff;font-size:14px;line-height: 22px;}
</style>
@stop
@section('content')
<div class="recruit-box clearfix">
    <div class="recruitment-list f-l">
        <div class="title-4edge">CAREER</div>
        <ul>
        @foreach ( $pages as $p )
            <li class="@if($p->id == $page->id) current @endif"><a id="page-{{ $p->id }}" href="{{ empty($p->out_link) ? action('PagesController@show',[$p->id]) : $p->out_link }}">{{ $p->title }}</a><i></i></li>
        @endforeach
        </ul>
    </div>
    <div class="recruitment f-l">
        <div id="recruitment-content" class="con clearfix">
            <div class="con-main">
                <h2>{{ $page->title }}</h2>
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
@stop