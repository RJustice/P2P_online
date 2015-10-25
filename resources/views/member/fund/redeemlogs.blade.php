@extends('_layouts.center')
@section('css')
<style type="text/css">
.carry-cancel-form .a-btn{border:none;height:26px;line-height: 26px;text-align:center;background:#ff0000;font-size:14px;margin:0;padding:0 15px;width:auto;clear:both;float: none;}
.label{display: inline;padding: .2em .6em .3em;font-size: 13px;font-weight: bold;line-height: 1;color: #fff;text-align: center;white-space: nowrap;vertical-align: baseline;}
.label-info{background: #5bc0de;}
.label-success{background: #5cb85c;}
.label-danger{background: #d9534f;}
</style>
@stop

@section('content')
<div class="list-title clearfix">
    <div class="">
        <a href="{{ route('member.fund.redeem') }}">赎回</a>
    </div>
    <div class="cur">
        <a href="{{ route('member.fund.redeemlogs') }}">赎回记录</a>
    </div>
</div>
<div class="tab-box clearfix pub-tab recharge">
   <div class="table-box clearfix">
       <table cellpadding="0" cellspacing="0">
            <colgroup>
            <col width="16%">
            <col width="16%">
            <col width="16%">
            <col width="20%">
            <col width="16%">
            <col width="16%">
            </colgroup>
            <thead>                                                                                
                <tr>                                                                           
                    <th>申请时间</th>
                    <th>理财项目</th>
                    <th>理财金额</th>
                    <th>待收益</th>
                    <th>手续费</th>
                    <th>申请状态</th>
                </tr>
            </thead>
            <tbody>
              @if( $logs )
                @foreach($logs as $log)
                <tr>
                  <td>{{ $log->created_at->format('Y-m-d') }}</td>
                  <td>{{ $log->dealOrder->deal_title }}</td>
                  <td>{{ $log->order_money }}</td>
                  <td>{{ $log->order_return }}</td>
                  <td>{{ number_format($log->order_money * App\OrderToRedeem::FEE_PERCENT,2) }}</td>
                  <td>
                  @if($log->status == App\OrderToRedeem::STATUS_PENDING )
                     {{--  {!! Form::open(['route'=>'member.fund.carrycancel','class'=>'carry-cancel-form','id'=>'cancel-form-'.$log->getKey()]) !!}
                      <input type="hidden" name="carry_id" value="{{ $log->getKey() }}">
                      <input type="submit" value="取消" class="a-btn">
                      {!! Form::close() !!} --}}
                      <span class="label label-info">等待处理</span>
                  @elseif($log->status == App\OrderToRedeem::STATUS_PASSED)
                      <span class="label label-info">已处理</span>
                  @else
                      <span class="label label-danger">未通过</span>
                  @endif
                  </td>
                </tr>
                @endforeach
              @endif
            </tbody>
        </table>
        <p class="pager">
            {{ $logs ? $logs->render() : "" }}
        </p>
    </div>
</div>
@stop

@section('js')
@stop