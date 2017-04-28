@extends('_layouts.center')
@section('css')
@parent
<style type="text/css">
    .info-card{margin:10px 0px;}
    .deal-order-card{margin:10px 0px;}
    .info-title{font-size:16px;font-weight: 600;color:#000;background: #d8d8d8;height:40px;line-height: 40px;padding-left:30px;}
    .info-content{}
    .info-content ul{}
    .info-content ul li{height:30px;line-height: 30px;font-size:14px;padding-left:20px;}
    .info-content ul li label{font-weight: 600;margin-right:15px;width:120px;text-align: right;display: inline-block;}
</style>
@stop
@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">我的客户</a>
    </div>
</div>
<div class="customer-information tab-box pub-tab clearfix ">
    <div class="table-box clearfix customer">
        <div class="info-card">
            <p class="info-title">客户信息</p>
            <div class="info-content">
                <ul>
                    <li><label for="">姓名：</label>{{ $customer->name }}</li>
                    <li><label for="">手机号：</label><span class="money">{{ $customer->phone }}</span></li>
                    <li><label for="">身份证号：</label><span class="money">{{ $customer->formatInfo(true,false) }}</span></li>
                    <li><label for="">所在地：</label>{{ $customer->formatRegion() }}</li>
                </ul>
            </div>
        </div>
        <div class="deal-order-card">
            <p class="info-title">客户投资项目</p>
            @if($dealOrders->count() > 0)
                <div class="tab-box clearfix pub-tab invest-box">
                    <div class="table-box clearfix">
                       <table cellspacing="0" cellpadding="0">
                            <colgroup>
                                <col width="20%">
                                <col width="15%">
                                <col width="15%">
                                <col width="15%">
                                <col width="15%">
                                <col width="15%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th class="tl">项目名称</th>
                                    <th>投资时间</th>
                                    <th>投资金额(元)</th>
                                    <th>年化收益(%)</th>
                                    <th>到期时间</th>
                                    <th>状态</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $dealOrders as $dealOrder )
                                <tr class="more-info @if($dealOrder->order_status == App\DealOrder::ORDER_STATUS_REDEEM_FINISHED ) no-click @endif" id="more-info-{{ $dealOrder->getKey() }}">
                                    <td>{{ $dealOrder->deal_title }}</td>
                                    <td>{{ $dealOrder->create_date }}</td>
                                    <td><span class="money">{{ number_format($dealOrder->total_price,2) }}</span></td>
                                    <td>{{ $dealOrder->deal_rate }}</td>
                                    <td>{{ $dealOrder->finish_date }}</td>
                                    <td>
                                    @if($dealOrder->order_status == App\DealOrder::ORDER_STATUS_REDEEM ) 
                                        赎回处理中 
                                    @elseif($dealOrder->order_status == App\DealOrder::ORDER_STATUS_REDEEM_FINISHED ) 
                                        已赎回 
                                    @elseif($dealOrder->order_status == App\DealOrder::ORDER_STATUS_FINISHED)
                                        已到期
                                    @elseif($dealOrder->order_status == App\DealOrder::ORDER_STATUS_INVALID )
                                        无效
                                    @elseif($dealOrder->order_status == App\DealOrder::ORDER_STATUS_VALID)
                                        @if($dealOrder->status == App\DealOrder::STATUS_PASSED)
                                        有效
                                        @elseif($dealOrder->status == App\DealOrder::STATUS_PENDING)
                                        待审核
                                        @endif
                                    @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                  </div>
                </div>
            @else
            <div class="alert alert-danger">
                您的该客户尚未投资任何项目，快联系他吧。
            </div>
            @endif
        </div>
    </div>
</div>
@stop
