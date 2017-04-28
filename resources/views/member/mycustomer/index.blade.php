@extends('_layouts.center')
@section('css')
@parent
<style type="text/css">
    .table-box td.blue-color, .table-box td a.redeem-btn{width:120px;height:35px;line-height:35px;text-align:center;background:#009dde;color:#fff;display:inline-block;font-size:14px;font-weight:600;color:#fff;}
</style>
@stop
@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">我的客户</a>
    </div>
</div>
<div class="bank-information tab-box pub-tab clearfix ">
    <div class="table-box clearfix bank-card">
        <table cellspacing="0" cellpadding="0">
            <colgroup>
            <col width="20%">
            <col width="30%">
            <col width="30%">
            <col width="20%">
            </colgroup>
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>总投资</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            @if( $customers )
                @foreach( $customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',$customer->phone) }}</td>
                    <td><span class="money">{{ number_format($customer->getTotalDealMoney(),2)  }}</span></td>
                    <td><a href="{{ route('member.mycustomer.show',['id'=>$customer->hash_id]) }}" class="redeem-btn">查看详情</a></td>
                </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <p class="pager">{!! $customers ? $customers->render() : "" !!}</p>
    </div>
</div>
<div id="change-form" class="layer">
    <div class="bank-information tab-box clearfix ">        
        @include('member.account.bankcard_form')
    </div>
</div>
@stop
