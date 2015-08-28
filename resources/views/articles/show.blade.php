@extends('_layouts.default')
@section('content')
<style type="text/css">
.wrap-box{background: #d8e8f6;padding:16px 0;}
</style>
<div class="wrap">
    <div class="beadcrumbs clearfix">
        <div class="m-investment">
              <h2 class="beadcrumb-nav"><a href="{{ url('/') }}">农发众诚</a> &gt;&gt; <a href="{{ action('ArticlesController@clist',[$article->category->id]) }}">{{ $article->category->name }}</a></h2>
        </div>
    </div>
    <div class="articles clearfix">
        <h3 class="title-h3">{{ $article->title }}</h3>
        <p class="p-time">发布时间: {{ $article->created_at }}</p>
        <div class="final-content">
            {!! $article->content !!}
        </div>
    </div>
</div>
@endsection
