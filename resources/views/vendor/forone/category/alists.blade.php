@extends('forone::layouts.master')

@section('main')

    {!! Html::list_header([
    'title' => '分类&nbsp;&nbsp;&nbsp;<strong style="font-size:16px;">'.$cat->name.'</strong>&nbsp;&nbsp;&nbsp;下的文章列表',
    ]) !!}

    {!! Html::datagrid($results) !!}

@stop