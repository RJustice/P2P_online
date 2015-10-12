@extends('forone::layouts.master')

@section('css')
<style type="text/css">
span.labelx{font-size:14px;font-weight: 600;text-align:right;color:#000;margin-right:15px;display: inline-block;}
span.price{font-size:14px;font-weight: 600;color:#ff5a13;letter-spacing: 1px;}
</style>
@stop
@section('main')
<div class="row">
    <div class="col-sm-12">
    {!! Form::ipanel_start('理财项目: '.$data->title.' <a href="'.route('admin.deals.edit',['id'=>$data->id]).'" class="btn btn-info">编辑</a> ') !!}
        <ul class="list-group">
            <li class="list-group-item">
                <span class="labelx col-sm-3">项目名称：</span>{{ $data->title }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">预计年收益：</span>{{ $data->rate }} %&nbsp;
            </li>                        
            <li class="list-group-item">
                <span class="labelx col-sm-3">万元日收益：</span>{{ $data->daliy_returns }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">期限：</span>{{ $data->repay_time }} 天&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">还款方式：</span>{{ \App\Deal::getLoanTypeTitle($data->loan_type) }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">状态：</span>{{ $data->is_effect ? '有效' : '无效' }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">简介：</span>{{ $data->intro_info }}&nbsp;
            </li>
        </ul>
        {!! Form::ipanel_end() !!}
    </div>
</div>
@stop

@section('js')
@stop