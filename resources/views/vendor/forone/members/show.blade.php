@extends('forone::layouts.master')
@section('title', '查看详情'.$page_name)
@section('main')
{!! Form::ipanel_start($data->name. '的详情') !!}
<div class="row">
    <h4 class="alert alert-info">基础信息</h4>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">姓名:</div>
            <div class="col-md-9 col-sm-8">{{ $data->name }}</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">性别:</div>
            <div class="col-md-9 col-sm-8">{{ $data->sex ? '男':'女' }}</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">年龄:</div>
            <div class="col-md-9 col-sm-8">{{ $data->name }}</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">出生日期:</div>
            <div class="col-md-9 col-sm-8">{{ $data->byear }}-{{ $data->bmonth }}-{{ $data->bday }}</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">身份证号:</div>
            <div class="col-md-9 col-sm-8">{{ $data->idno }}</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">手机号码:</div>
            <div class="col-md-9 col-sm-8">{{ $data->phone }}</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">区域: </div>
            <div class="col-md-9 col-sm-8">{{ $data->province_id }}  {{ $data->city_id }}</div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">住址: </div>
            <div class="col-md-9 col-sm-8">{{ $data->address }}</div>
        </div>
    </div>
</div>
<div class="row">
    <h4 class="alert alert-info">资金状况</h4>
    <div class="col-md-3 col-sm-12">
        <div class="row">
            <div class="col-md-5 col-sm-4">总资金:</div>
            <div class="col-md-7 col-sm-8">{{ $data->money }}</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="row">
            <div class="col-md-5 col-sm-4">可用资金:</div>
            <div class="col-md-7 col-sm-8">{{ $data->money }}</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="row">
            <div class="col-md-5 col-sm-4">冻结资金:</div>
            <div class="col-md-7 col-sm-8">{{ $data->lock_money }}</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12">
        <div class="row">
            <div class="col-md-5 col-sm-4">红包金额:</div>
            <div class="col-md-7 col-sm-8">{{ $data->lock_money }}</div>
        </div>
    </div>
    {{-- <div class="col-md-4 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-4">代金券金额:</div>
            <div class="col-md-9 col-sm-8">{{ $data->lock_money }}</div>
        </div>
    </div> --}}
</div>
{!! Form::ipanel_end() !!}

{!! Form::ipanel_start('理财项目') !!}
    @if( $data->dealOrders ) 
        <div class="alert alert-info">
            <p>该用户暂时没有购买任何理财产品</p>
            <p>如果有线下购买请对应销售经理<a href="{{ route('admin.hand.offline',['id'=> $data->id]) }}" class="btn btn-info">填写信息</a></p>
        </div>
    @else
        {{-- {!! Html::idatagrid_header([]) !!} --}}

        {!! Html::idatagrid($dealOrders,false) !!}
    @endif
{!! Form::ipanel_end() !!}
@if( ! $data->salesManager()->first() )
{!! Form::ipanel_start('分配用户') !!}
    <div class="row">
        {!! Form::open(['url'=>'admin/'.$uri.'/add-ref','class'=>'form-horizontal']) !!}
        {!! Form::close() !!}
    </div>
{!! Form::ipanel_end() !!}
@endif
@stop