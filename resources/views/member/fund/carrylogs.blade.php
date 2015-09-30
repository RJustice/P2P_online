@extends('_layouts.center')
@section('css')
<style type="text/css">
.carry-cancel-form .a-btn{border:none;height:26px;line-height: 26px;text-align:center;background:#ff0000;font-size:14px;margin:0;padding:0 15px;width:auto;clear:both;float: none;}
</style>
@stop

@section('content')
<div class="list-title clearfix">
    <div class="">
        <a href="{{ route('member.fund.carry') }}">提现</a>
    </div>
    <div class="cur">
        <a href="{{ route('member.fund.carrylogs') }}">提现记录</a>
    </div>
</div>
<div class="tab-box clearfix pub-tab recharge">  
   {{-- <div class="search-data">
       <div class="text-describe"></div>
       <div class="div-search change-wid">
         起止日期<input class="Wdate" id="start-time" value="" type="text">-<input class="Wdate" id="end-time" value="" type="text"><span class="search-btn" id="charge-search-btn">搜&nbsp;&nbsp;索</span>
       </div>
   </div> --}}
<div id="Idiv" style="display:none;position:absolute;z-index:1000;background:#67a3d9;height: 200px;width:100px;">
</div>
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
                    <th>编号</th>
                    <th>申请时间</th>
                    <th> 提现金额（元）</th>
                    <th>提现账户</th>
                    <th>申请状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
              @if( $logs )
                @foreach($logs as $log)
                <tr>
                  <td>{{ $log->getKey() }}</td>
                  <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                  <td>{{ number_format($log->money,2) }}</td>
                  <td>{{ preg_replace('/([0-9]{6})[0-9]{4,}([0-9]{4})/i','$1****$2',$log->bank_card)}}</td>
                  <td>{{ App\UserCarry::getStatusTitle($log->status) }}</td>
                  <td>
                  @if($log->status == App\UserCarry::STATUS_PENDING )
                      {!! Form::open(['route'=>'member.fund.carrycancel','class'=>'carry-cancel-form','id'=>'cancel-form-'.$log->getKey()]) !!}
                      <input type="hidden" name="carry_id" value="{{ $log->getKey() }}">
                      <input type="submit" value="取消" class="a-btn">
                      {!! Form::close() !!}
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