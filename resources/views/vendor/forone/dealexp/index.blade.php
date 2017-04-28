@extends('forone::layouts.master')

@section('main')
    
    {!! Html::ilist_header([
    'new'=>true,
    ]) !!}

    {!! Html::idatagrid($results) !!}

@stop