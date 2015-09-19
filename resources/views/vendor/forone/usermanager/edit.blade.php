@extends('forone::layouts.master')

@section('title', '更新'.$page_name)

@section('main')

    {!! Form::ipanel_start('编辑'.$page_name) !!}
    {!! Form::model($data,['method'=>'PUT','route'=>['admin.users.update',$data->id],'class'=>'form-horizontal']) !!}
        @include('forone::' . $uri.'.form', ['edit'=>true])
    {!! Form::ipanel_end('保存') !!}
    {!! Form::close() !!}

@stop