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
        {!! Form::ipanel_start('查看 : '.$data->real_name.' 于 '. $data->create_date . ' 提交的提现申请'.'<span class="label"></span>') !!}
        @if( $data->status == \App\UserCarry::STATUS_PENDING)
        <div class="row" style="margin-bottom:20px;">
            <div class="col-sm-12">
                {!! Form::model($data,['method'=>'PUT','route'=>['admin.'.$uri.'.update',$data->getKey()],'class'=>'form-horizontal','id'=>'check-form']) !!}
                    {!! Form::iform_text('msg','备注','请输入备注或者理由',1) !!}
                    {!! Form::ihidden_input('id',$data->getKey()) !!}
                    {!! Form::ihidden_input('status') !!}
                    <div class="row">
                        <div class="col-sm-12 text-center"><a href="javascript:;" class="btn btn-success pass">已处理</a>&nbsp;&nbsp;<a href="javascript:;" class="btn btn-danger not-pass">不通过</a></div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        @elseif($data->status <> \App\UserCarry::STATUS_CANCEL )
        <div class="row" style="margin-bottom:20px">
            <div class="col-sm-12">
                <div class="alert @if($data->status == \App\UserCarry::STATUS_PASSED ) alert-success @else alert-danger @endif">
                    <p>状态: <span class="label @if($data->status == \App\UserCarry::STATUS_PASSED ) label-success @else label-danger @endif ">{{ \App\UserCarry::getStatusTitle($data->status) }}</span></p>
                    <p>该条申请已经由 {{ $data->passed->name }} 进行操作</p>
                    <p>操作备注: {{ $data->msg }}</p>
                </div>
            </div>
        </div>
        @else
        <div class="row" style="margin-bottom:20px">
            <div class="col-sm-12">
                <div class="alert alert-warning">
                    <p>状态: <span class="label label-warning">{{ \App\UserCarry::getStatusTitle($data->status) }}</span></p>
                    <p>该条申请用户已经取消</p>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="labelx col-sm-3">客户：</span>{{ $data->real_name }}&nbsp;
                    </li>
                    <li class="list-group-item">
                        <span class="labelx col-sm-3">电话：</span>{{ $data->user->phone }}&nbsp;
                    </li>
                    <li class="list-group-item">
                        <span class="labelx col-sm-3">提现银行：</span>{{ $data->bank->name }} : {{ $data->bankzone}}&nbsp;
                    </li>
                    <li class="list-group-item">
                        <span class="labelx col-sm-3">银行卡号：</span>{{ $data->bank_card }}&nbsp;
                    </li>
                    <li class="list-group-item">
                        <span class="labelx col-sm-3">提现金额：</span><span class="price">{{ number_format($data->money,2) }}</span>&nbsp;
                    </li>
                    <li class="list-group-item list-group-item-success">
                        <span class="labelx col-sm-3 ">申请时间：</span>{{ $data->created_at->format('Y-m-d') }}&nbsp;
                    </li>                    
                </ul>
            </div>
        </div>
        {!! Form::ipanel_end() !!}
    </div>
</div>
@stop
@section('js')
    @parent
    <script type="text/javascript">
    $(function(){
        $('.pass').on('click',function(){
            $("input:hidden[name=status]").val( {{ App\UserCarry::STATUS_PASSED }} );
            if( confirm("确定已经向该用户打款?") ){
                $('#check-form').submit();
            }
        });

        $('.not-pass').on('click',function(){
            $("input:hidden[name=status]").val( {{ App\UserCarry::STATUS_NOT_PASSED }} );
            if( confirm('确定不通过该用户的提现申请?') ){
                $('#check-form').submit();
            }            
        });
    });
    </script>
@stop