@extends('_layouts.center')
@section('css')
@stop

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">银行卡管理</a>
    </div>
</div>
<div class="bank-information tab-box clearfix ">
    @include('member.account.bankcard_form')
</div>
@stop
