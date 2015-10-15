@extends('_layouts.center')
@section('css')
@stop

@section('content')
<div class="list-title clearfix">
    {{-- <div class="cur">
        <a href="{{ route('member.fund.summarydetail') }}">资金明细</a>
    </div> --}}
    <div class="">
        <a href="{{ route('member.fund.logs') }}">资金明细</a>
    </div>
</div>
<div class="tab-box clearfix tab-box pub-tab fund-details">
    <div class="table-box clearfix">
       <table cellspacing="0" cellpadding="0">
            <colgroup>
            <col width="30%">
            <col width="35%">
            <col width="35%">
            </colgroup>
            <thead>
                <tr>
                    <th>资金类别</th>
                    <th>详情</th>
                    <th>备注</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center" class="td1" rowspan="10"><span class="dd1">资金损益</span></td>
                    <td><span class="dd2">净赚利息</span><span class="dd3"><span style="color:#f47107;">￥0.00</span></span></td>
                    <td class="td2">投资净赚的投资利息总和，已扣除管理费</td>
                </tr>
                <tr>
                    <td><span class="dd2">支付会员认证费</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">支付的从e租宝会员费及认证费用总和</td>
                </tr>
                <tr>
                    <td><span class="dd2"> 累计提现手续费</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">支付的提现手续费总和</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计投标奖励</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">投标获得的奖励总和</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计募集期获息</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">投标募集期间获得的奖励总和</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计投标奖励</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">投资所获得投标奖励总和</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计推广奖励</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">推广下线获得的奖励总和</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计线下充值奖励</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">线下充值获得的奖励总和</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计续投奖励</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">投资回款后续投获得的奖金总和</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计充值手续费</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">支付的充值手续费总和</td>
                </tr>
                <tr>
                    <td align="center" class="td1" rowspan="3"><span class="dd1">资金流量</span></td>
                    <td><span class="dd2">累计投资金额</span><span class="dd3"><span style="color:#f47107;">￥0.00</span></span></td>
                    <td class="td2">注册至今，您账户借出资金总和</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计充值金额</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">注册至今，您账户累计充值总额</td>
                </tr>
                <tr>
                    <td><span class="dd2">累计提现金额</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">注册至今，您账户累计提现总额</td>
                </tr>
                <tr>
                    <td align="center" class="td1"><span class="dd1">资金预期</span></td>
                    <td><span class="dd2">待收利息总额</span><span class="dd3">￥0.00</span></td>
                    <td class="td2">已经投资，尚未回收的利息总额，未扣除管理费</td>
                </tr>
            </tbody>
        </table>
</div>
</div>
@stop

@section('js')
@stop