@extends('forone::layouts.master')

@section('title', '冻结资金')

@section('main')
    
    @if (Input::old())
        {!! Form::model(Input::old(),['url'=>route('admin.'.$uri.'.{id}.recharge',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'freeze-form']) !!}
    @else
        {!! Form::open(['url'=>route('admin.'.$uri.'.{id}.freeze',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'freeze-form']) !!}
    @endif
    {!! Form::ipanel_start('冻结资金') !!}
    @include('forone::'. $uri.'.freezeform')
    {!! Form::ipanel_end('保存') !!}
    
    {!! Form::close() !!}

@stop