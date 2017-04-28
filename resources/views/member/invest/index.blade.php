@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">我的投资项目</a>
    </div>
</div>
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
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            @if( $dealOrders )
                @foreach( $dealOrders as $dealOrder )
                <tr class="more-info" id="more-info-{{ $dealOrder->getKey() }}">
                    <td>{{ $dealOrder->deal_title }}</td>
                    <td>{{ $dealOrder->create_date }}</td>
                    <td>{{ number_format($dealOrder->total_price,2) }}</td>
                    <td>{{ $dealOrder->deal_rate }}</td>
                    <td>{{ $dealOrder->finish_date }}</td>
                    <td>@if($dealOrder->order_status == App\DealOrder::ORDER_STATUS_VALID) <a href="{{ route('member.fund.redeem.{id?}',[$dealOrder->getKey()]) }}" style="width:120px;height:35px;line-height:35px;text-align:center;background:#009dde;color:#fff;display:inline-block;font-size:14px;font-weight:600;">赎回</a> @endif</td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <p class="pager">{!! $dealOrders ? $dealOrders->render() : "" !!}</p>
  </div>
</div>
@stop

@section('js')
@stop