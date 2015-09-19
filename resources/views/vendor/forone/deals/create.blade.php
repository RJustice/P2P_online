@extends('forone::layouts.master')

@section('title', '新增'.$page_name)

@section('main')

    {!! Form::ipanel_start('新增'.$page_name) !!}
    @if (Input::old())
        {!! Form::model(Input::old(),['url'=>'admin/'.$uri,'class'=>'form-horizontal']) !!}
    @else
        {!! Form::open(['url'=>'admin/'.$uri,'class'=>'form-horizontal']) !!}
    @endif
    @include('forone::'. $uri.'.form')
    {!! Form::ipanel_end('保存') !!}
    {!! Form::close() !!}

@stop