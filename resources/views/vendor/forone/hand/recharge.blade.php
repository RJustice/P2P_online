@extends('forone::layouts.master')

@section('title', '快速充值')

@section('main')
    
    @if (Input::old())
        {!! Form::model(Input::old(),['url'=>route('admin.'.$uri.'.{id}.recharge',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'recharge-form']) !!}
    @else
        {!! Form::open(['url'=>route('admin.'.$uri.'.{id}.recharge',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'recharge-form']) !!}
    @endif
    {!! Form::ipanel_start('快速充值') !!}
    @include('forone::'. $uri.'.rechargeform')
    {!! Form::ipanel_end('保存') !!}
    
    {!! Form::close() !!}

@stop