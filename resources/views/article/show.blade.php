@extends('_layouts.main')
@section('content')
{{ $article->title }}
<br />
{{ $article->content }}
<br />
{{ $article->created_at }}
<br />
{{ $article->updated_at }}
<br />
{{ $article->category->name }}
<br />
{{ $article->section->name }}
@endsection