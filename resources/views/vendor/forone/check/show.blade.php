@extends('forone::layouts.master')
@section('css')
<style type="text/css">
span.labelx{font-size:14px;font-weight: 600;text-align:right;color:#000;display: inline-block;}
span.price{font-size:14px;font-weight: 600;color:#ff5a13;letter-spacing: 1px;}
</style>
@stop
@section('main')
<div class="row">
    <div class="col-sm-12">
        {!! Form::ipanel_start('查看 : '.$data->order_sn) !!}
        @if($data->status == App\DealOrder::STATUS_PENDING)
        <div class="alert alert-info text-center">
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::model($data,['method'=>'PUT','route'=>['admin.'.$uri.'.update',$data->order_sn],'class'=>'form-horizontal','id'=>'check-form']) !!}
                        {!! Form::iform_text('memo','备注','请输入备注或者理由',1) !!}
                        {!! Form::ihidden_input('id',$data->getKey()) !!}
                        {!! Form::ihidden_input('status') !!}
                        <div class="row">
                            <div class="col-sm-12 text-center"><a href="javascript:;" class="btn btn-success pass">通过</a>&nbsp;&nbsp;<a href="javascript:;" class="btn btn-danger not-pass">不通过</a></div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @elseif($data->status == App\DealOrder::STATUS_NOT_PASSED)
        <div class="alert alert-danger text-center">
            <h5>该条操作已经由 {{ $data->whoConfirm->name}} 审核,但是没有通过!</h5>
        </div>
        @elseif($data->status == App\DealOrder::STATUS_PASSED)
        <div class="alert alert-success text-center">
            <h5>该条操作已经由 {{ $data->whoConfirm->name}} 审核通过</h5>
        </div>
        @endif
        <ul class="list-group col-md-12 col-sm-12">
            <li class="list-group-item">
                <span class="labelx col-sm-3">订单备注：</span>{{ $data->admin_meno }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">客户：</span>{{ $data->member->name }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">身份证：</span>{{ $data->member->idno }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">手机号码：</span>{{ $data->member->phone }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">购买金额：</span><span class="price">{{ number_format($data->total_price,2) }}</span>&nbsp;
            </li>
            <li class="list-group-item list-group-item-info">
                <span class="labelx col-sm-3">开始时间：</span>{{ $data->create_date }}
            </li>
            <li class="list-group-item list-group-item-info">
                <span class="labelx col-sm-3">结束时间：</span>{{ $data->finish_date }} @if(strtotime($data->finish_date) - time() <= 0 ) <span class="label label-danger">已经到期</span> @elseif( strtotime($data->finish_date) - time() <= 5 * 24 * 60 * 60 && strtotime($data->finish_date) - time() > 0 ) <span class="label label-warning">即将到期</span> @endif
            </li>
        </ul>
        <ul class="list-group col-md-12 col-sm-12">
            <li class="list-group-item">
                <span class="labelx col-sm-3">理财项目：</span>{{ $data->deal_title }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">预计年收益：</span>{{ $data->deal_rate }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">还款方式：</span>{{ \App\Deal::getLoanTypeTitle($data->deal_type) }}&nbsp;
            </li>
        </ul>
        {!! Form::ipanel_end() !!}
    </div>
</div>
@stop

@section('js')
    @parent
    <script type="text/javascript">
    $(function(){
        $('.pass').on('click',function(){
            $("input:hidden[name=status]").val( {{ App\DealOrder::STATUS_PASSED }} );
            $('#check-form').submit();
        });

        $('.not-pass').on('click',function(){
            $("input:hidden[name=status]").val( {{ App\DealOrder::STATUS_NOT_PASSED }} );
            $('#check-form').submit();
        });
    });
    </script>
@stop