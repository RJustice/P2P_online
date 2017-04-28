@extends('forone::layouts.master')

@section('main')
    
    {!! Html::ilist_header([
        'title' => '赎回申请列表'
    ]) !!}

    {!! Html::idatagrid($results) !!}

@stop