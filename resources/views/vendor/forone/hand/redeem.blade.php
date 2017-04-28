@extends('forone::layouts.master')

@section('title', '线下赎回')

@section('main')
    
    @if (Input::old())
        {!! Form::model(Input::old(),['url'=>route('admin.'.$uri.'.{id}.redeem',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'redeem-form']) !!}
    @else
        {!! Form::open(['url'=>route('admin.'.$uri.'.{id}.redeem',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'redeem-form']) !!}
    @endif
    {!! Form::ipanel_start('线下赎回') !!}
    @include('forone::'. $uri.'.redeemform')
    {!! Form::ipanel_end('保存') !!}
    
    {!! Form::close() !!}

@stop