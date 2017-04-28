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
        {!! Form::ipanel_start('查看 : '.$data->order_sn.' 赎回申请') !!}
        @if($data->status == App\OrderToRedeem::STATUS_PENDING)
        <div class="alert alert-info text-center">
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::model($data,['method'=>'PUT','route'=>['admin.'.$uri.'.update',$data->getKey()],'class'=>'form-horizontal','id'=>'check-form']) !!}
                        {!! Form::iform_text('memo','备注','请输入备注或者理由',1) !!}
                        {!! Form::ihidden_input('sn',$data->order_sn) !!}
                        {!! Form::ihidden_input('status') !!}
                        <div class="row">
                            <div class="col-sm-12 text-center"><a href="javascript:;" class="btn btn-success pass">通过</a>&nbsp;&nbsp;<a href="javascript:;" class="btn btn-danger not-pass">不通过</a></div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @elseif($data->status == App\OrderToRedeem::STATUS_UNPASSED)
        <div class="alert alert-danger text-center">
            <h5>该条操作已经由 {{ $data->whoConfirm->name}} 审核,但是没有通过!</h5>
            <p>备注/理由：{{ $data->memo }}</p>
        </div>
        @elseif($data->status == App\OrderToRedeem::STATUS_PASSED)
        <div class="alert alert-success text-center">
            <h5>该条操作已经由 {{ $data->whoConfirm->name}} 审核通过</h5>
            <p>备注/理由：{{ $data->memo }}</p>
        </div>
        @endif
        <div class="col-sm-12">
            <div class="col-sm-3 text-center">
                赎回金额
            </div>            
            <div class="col-sm-3 text-center">
                赎回时待收益
            </div>
            <div class="col-sm-3 text-center">
                赎回时间
            </div>
            <div class="col-sm-3 text-center">
                手续费
            </div>   
        </div>
        <div class="col-sm-12">
            <div class="col-sm-3 text-center">
                <span class="price">{{ number_format($data->order_money,2) }}</span>
            </div>            
            <div class="col-sm-3 text-center">
                <span class="price">{{ number_format($data->order_return,2) }}</span>
                @if( $data->dealOrder->deal_type == App\Deal::LOANTYPE_FUXIFANBEN )
                <?php 
                    $redeem = date_create($data->created_at->format('Y-m-d'));
                    $start = date_create($data->dealOrder->create_date);
                    $diff = date_diff($redeem,$start);
                    $days = $diff->days - 1;
                    if( $start == $redeem ){
                        $days = 0;
                    }                    
                ?>
                (月回息,已付:<span class="price">{{ number_format($days * $data->dealOrder->deal_daily_returns * ( $data->dealOrder->total_price / 10000 ) - $data->order_return,2) }}</span>)
                @endif
            </div>
            <div class="col-sm-3 text-center">
                {{ $data->created_at->format('Y-m-d') }}
            </div>
            <div class="col-sm-3 text-center">
                <span class="price">{{ number_format($data->order_money * App\OrderToRedeem::FEE_PERCENT,2) }}</span>
            </div>   
        </div>
        <p class="col-sm-12" style="font-size:16px;font-weight:600;padding-left:50px;margin-top:15px;line-height:30px;height:30px;">赎回应付: <span class="price">{{ number_format($data->order_money + $data->order_return - ($data->order_money * App\OrderToRedeem::FEE_PERCENT) ) }}</span></p>
        <ul class="list-group col-md-12 col-sm-12">
            <li class="list-group-item">
                理财订单详情
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">订单备注：</span>{{ $data->dealOrder->admin_meno }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">客户：</span>{{ $data->dealOrder->member->name }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">身份证：</span>{{ $data->dealOrder->member->idno }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">手机号码：</span>{{ $data->dealOrder->member->phone }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">购买金额：</span><span class="price">{{ number_format($data->dealOrder->total_price,2) }}</span>&nbsp;
            </li>
            <li class="list-group-item list-group-item-info">
                <span class="labelx col-sm-3">开始时间：</span>{{ $data->dealOrder->create_date }}
            </li>
            <li class="list-group-item list-group-item-info">
                <span class="labelx col-sm-3">结束时间：</span>{{ $data->dealOrder->finish_date }} @if(strtotime($data->dealOrder->finish_date) - time() <= 0 ) <span class="label label-danger">已经到期</span> @elseif( strtotime($data->dealOrder->finish_date) - time() <= 5 * 24 * 60 * 60 && strtotime($data->dealOrder->finish_date) - time() > 0 ) <span class="label label-warning">即将到期</span> @endif
            </li>
        </ul>
        <ul class="list-group col-md-12 col-sm-12">
            <li class="list-group-item">
                <span class="labelx col-sm-3">理财项目：</span>{{ $data->dealOrder->deal_title }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">预计年收益：</span>{{ $data->dealOrder->deal_rate }}&nbsp;
            </li>
            <li class="list-group-item">
                <span class="labelx col-sm-3">还款方式：</span>{{ \App\Deal::getLoanTypeTitle($data->dealOrder->deal_type) }}&nbsp;
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
            $("input:hidden[name=status]").val( {{ App\OrderToRedeem::STATUS_PASSED }} );
            $('#check-form').submit();
        });

        $('.not-pass').on('click',function(){
            $("input:hidden[name=status]").val( {{ App\OrderToRedeem::STATUS_UNPASSED }} );
            $('#check-form').submit();
        });
    });
    </script>
@stop