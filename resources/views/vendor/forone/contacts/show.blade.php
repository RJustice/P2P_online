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
    {!! Form::ipanel_start('咨询') !!}
        <ul class="list-group">
            <li class="list-group-item">
                <span class="labelx col-sm-3">称呼：</span>{{ $data->title }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">电话：</span><span class="price">{{ $data->phone }}</span>&nbsp;
            </li>                        
            <li class="list-group-item">
                <span class="labelx col-sm-3">留言：</span>{{ $data->msg }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">咨询时间：</span>{{ $data->created_at->format('Y-m-d') }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">咨询类型：</span>{{ $data->type == 1 ? '投资理财' : '借贷' }}&nbsp;
            </li>
            <li class="list-group-item clearfix">
                <span class="labelx col-sm-3">已联系：</span>
                @if( $data->status )
                    {!! Form::form_button(['name'=>'是','class'=>'btn-success','uri'=>'','method'=>'POST','id'=>$data->id],['status'=>0]) !!}
                @else
                    {!! Form::form_button(['name'=>'否','class'=>'btn-danger','uri'=>'','method'=>'POST','id'=>$data->id],['status'=>1]) !!}
                @endif
            </li>
        </ul>
        {!! Form::ipanel_end() !!}
    </div>
</div>
@stop

@section('js')
@stop
