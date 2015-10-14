@extends('forone::layouts.master')

@section('main')
    
    {!! Html::ilist_header([
        'search' => true,
        'title' =>'提现申请列表'
    ]) !!}

    {!! Html::idatagrid($results) !!}

@stop