@extends('_layouts.default')
@section('content')
<style type="text/css">
.wrap-box{background: #d8e8f6;padding:16px 0;}
</style>
<div class="wrap">
    <div class="beadcrumbs clearfix">
        <div class="m-investment">
              <h2 class="beadcrumb-nav"><a href="{{ url('/') }}">农发众诚</a> &gt;&gt; <a href="{{ action('ArticlesController@clist',[$c->id]) }}">{{ $c->name }}</a></h2>
        </div>
    </div>
    <div class="articles clearfix">
        <div class="categories-bar">
            <ul>
            @foreach ($cats as $cat)
                <li class=" @if( $cat->id == $c->id ) selected @endif"><a href="{{ action('ArticlesController@clist',[$cat->id]) }}">{{ $cat->name }}</a></li>
            @endforeach
            </ul>
        </div>
        <div class="article-lists">
            <ul class="clearfix new-list">
                @foreach ( $articles as $article )
                <li><span class="span01"><a href="{{ action('ArticlesController@show',[$article->id]) }}">{{ $article->title }}</a></span><span class="span02">{{ $article->created_at }}</span></li>
                @endforeach
            </ul>
            <div class="text-center">
            {!! $articles->render() !!}
            </div>
            {{-- <p class="pager"><a class="homepage" href="#">首页</a><a class="prevnext delcolor" href="#">上一页</a> &nbsp;<span class="current">1</span>&nbsp;<a href="#">&nbsp;2&nbsp;</a>&nbsp;<a href="#">&nbsp;3&nbsp;</a>&nbsp;<a href="#">&nbsp;4&nbsp;</a>&nbsp;<a href="#">&nbsp;5&nbsp;</a>&nbsp;<a href="#">&nbsp;6&nbsp;</a>&nbsp;<a href="#">&nbsp;7&nbsp;</a>&nbsp;<a href="#">&nbsp;8&nbsp;</a>&nbsp;<a href="#">&nbsp;9&nbsp;</a><a class="prevnext" href="#">下一页</a><a class="last" href="#">尾页</a></p> --}}
        </div>
    </div>
</div>
@endsection
