@extends('_layouts.center')
@section('css')
<style type="text/css">
.resetpwd-box .m-form{padding:20px;}
.resetpwd-box .m-form input{width:200px;}
</style>
@stop

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">设置支付密码</a>
    </div>
</div>
<div class="tab-box pub-box resetpwd-box">
    {!! Form::open(['route'=>'member.account.resetpay','class'=>'form-horizontal','id'=>'resetpay-form']) !!}
    <div class="m-form">
    @if($ctl == 'new')
        <ul class="clearfix">
            <li class="clearfix">
                <label><em>*</em>原始支付密码</label>
                <input type="password" name="oldpwd" id="oldpwd" placeholder="">
                <span class="error"> @if(auth()->user()->paypassowrd) 如从未设置,请输入账号登录密码 @endif </span>
            </li>
            <li class="clearfix">
                <label><em>*</em>新支付密码</label>
                <input type="password" name="newpwd" id="newpwd">
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <label><em>*</em>确认支付密码</label>
                <input type="password" name="newpwd_confirmation" id="newpwd-confirmation">
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <label><em>*</em>手机验证码</label>
                <input type="text" name="smscode" id="smscode">
                <a class="get-code" id="btnGetCode" href="javascript:void(0);">获取手机验证码</a>
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <p style="padding: 0 30px 0 158px;"><button id="btn-mod" class="btn-group" href="javascript:void(0);" onClick="javascript:document.getElementById('bankcard-form').submit();">{{ auth()->user()->paypassowrd ? "修改":"设置"}}</button><a id="cancel" class="btn-group" href="{{ route('member.account.safe') }}">取消</a></p>
            </li>
        </ul>
    @elseif($ctl == 'change')
        <ul class="clearfix">
            <li class="clearfix">
                <label><em>*</em>原始支付密码</label>
                <input type="password" name="oldpwd" id="oldpwd" placeholder="">
                <span class="error"> @if(auth()->user()->paypassowrd) 如从未设置,请输入账号登录密码 @endif </span>
            </li>
            <li class="clearfix">
                <label><em>*</em>新支付密码</label>
                <input type="password" name="newpwd" id="newpwd">
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <label><em>*</em>确认支付密码</label>
                <input type="password" name="newpwd_confirmation" id="newpwd-confirmation">
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <p style="padding: 0 30px 0 158px;"><button id="btn-mod" class="btn-group" href="javascript:void(0);" onClick="javascript:document.getElementById('bankcard-form').submit();">{{ auth()->user()->paypassowrd ? "修改":"设置"}}</button><a id="cancel" class="btn-group" href="{{ route('member.account.safe') }}">取消</a></p>
            </li>
        </ul>
    @elseif($ctl == 'find' )
        <ul class="clearfix">
            <li class="clearfix">
                <label><em>*</em>新支付密码</label>
                <input type="password" name="newpwd" id="newpwd">
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <label><em>*</em>确认支付密码</label>
                <input type="password" name="newpwd_confirmation" id="newpwd-confirmation">
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <label><em>*</em>手机验证码</label>
                <input type="text" name="smscode" id="smscode">
                <a class="get-code" id="btnGetCode" href="javascript:void(0);">获取手机验证码</a>
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <p style="padding: 0 30px 0 158px;"><button id="btn-mod" class="btn-group" href="javascript:void(0);" onClick="javascript:document.getElementById('bankcard-form').submit();">{{ auth()->user()->paypassowrd ? "修改":"设置"}}</button><a id="cancel" class="btn-group" href="{{ route('member.account.safe') }}">取消</a></p>
            </li>
        </ul>
    @endif        
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('js')

@stop