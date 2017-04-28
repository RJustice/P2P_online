@extends('forone::layouts.master')

@section('main')
    
    {!! Html::ilist_header([
        'title' => 'POS单投资',
        'search' => true
    ]) !!}

    {!! Html::idatagrid($results) !!}

@stop