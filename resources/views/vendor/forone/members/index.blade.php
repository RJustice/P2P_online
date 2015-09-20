@extends('forone::layouts.master')

@section('main')
    
    {!! Html::ilist_header([
    'new'=>true,
    'search' => true
    ]) !!}

    {!! Html::idatagrid($results) !!}

@stop