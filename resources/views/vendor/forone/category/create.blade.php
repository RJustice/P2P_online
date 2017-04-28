@extends('forone::layouts.master')

@section('title', '创建'.$page_name)

@section('main')

    {!! Form::ipanel_start('创建'.$page_name) !!}
    @if (Input::old())
        {!! Form::model(Input::old(),['url'=>'admin/'.str_slug($uri),'class'=>'form-horizontal']) !!}
    @else
        {!! Form::open(['url'=>'admin/'.str_slug($uri),'class'=>'form-horizontal']) !!}
    @endif
    @include('forone::'. $uri.'.form')
    {!! Form::ipanel_end('保存') !!}
    {!! Form::close() !!}

@stop