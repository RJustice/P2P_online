@extends('forone::layouts.master')

@section('main')
    
    {!! Html::ilist_header([
    ]) !!}

    {!! Html::idatagrid($results) !!}

@stop