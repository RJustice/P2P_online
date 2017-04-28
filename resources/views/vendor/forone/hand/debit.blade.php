@extends('forone::layouts.master')

@section('title', '快速扣款')

@section('main')
    
    @if (Input::old())
        {!! Form::model(Input::old(),['url'=>route('admin.'.$uri.'.{id}.debit',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'debit-form']) !!}
    @else
        {!! Form::open(['url'=>route('admin.'.$uri.'.{id}.debit',['id'=>$uid]),'class'=>'form-horizontal','files'=>true,'id'=>'debit-form']) !!}
    @endif
    {!! Form::ipanel_start('快速扣款') !!}
    @include('forone::'. $uri.'.debitform')
    {!! Form::ipanel_end('保存') !!}
    
    {!! Form::close() !!}

@stop