@extends('forone::layouts.master')

@section('main')
    
    {!! Html::ilist_header([ 
        'title' => $panel_title,
        'search' => true
    ]) !!}

    {!! Html::idatagrid($results) !!}

@stop