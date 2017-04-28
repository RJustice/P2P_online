@extends('forone::layouts.master')

@section('title', '线下订单补填')

@section('main')
    
    @if (Input::old())
        {!! Form::model(Input::old(),['url'=>route('admin.'.$uri.'.{id}.offline',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'offline-form']) !!}
    @else
        {!! Form::open(['url'=>route('admin.'.$uri.'.{id}.offline',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'offline-form']) !!}
    @endif
    {!! Form::ipanel_start('线下订单登记') !!}
    @include('forone::'. $uri.'.offlineform')
    {!! Form::ipanel_end('保存') !!}
    
    {!! Form::close() !!}

@stop