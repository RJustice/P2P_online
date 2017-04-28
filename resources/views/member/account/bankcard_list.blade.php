@extends('_layouts.center')
@section('css')
@stop

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">银行卡管理</a>
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
                    <th>银行名称</th>
                    <th>开户行名称</th>
                    <th>卡号</th>
                    <th>状态</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td title="head">{{ $bank->bank_name }}</td>
                    <td>{{ $bank->bankzone}}</td>
                    <td>{{ App\UserBank::formatBankCard($bank->bankcard) }}</td>
                    <td>
                        <a href="javascript:void(0)" class="gray-color"> 已认证</a> 
                        <a id="change-bank" href="javascript:void(0);">更换</a>
                    </td>
                </tr>
                <tr>
                    <td class="tr" colspan="4">
                        {{-- <a class="btn bg-blue" href="{{ route('member.fund.recharge') }}">充值</a> --}}
                        <a class="btn bg-orange" href="{{ route('member.fund.carry') }}">提现</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="change-form" class="layer">
    <div class="bank-information tab-box clearfix ">        
        @include('member.account.bankcard_form')
    </div>
</div>
@stop

@section('js')
    <script type="text/javascript">
        $(function(){
            $("#change-bank").on('click',function(){
                $("#change-form").show();
            });
            $("#change-form #cancel").on('click',function(){
                $("#change-form").hide();
            });
        });
    </script>
@stop