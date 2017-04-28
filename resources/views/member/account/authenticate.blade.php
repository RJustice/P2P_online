@extends('_layouts.center')
<style type="text/css">
    .alert{width:475px;margin:20px 0 20px 155px;border: 1px solid transparent;
    border-radius: 4px;
    margin-bottom: 20px;
    padding: 15px;}
    .alert-danger{ background-color: #f2dede;
    border-color: #ebccd1;
    color: #a94442;}
</style>
@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="/index.php?ctl=uc_money">身份认证</a>
    </div>
</div>
<div class="tab-box clearfix  authenticate-info">
    @if( auth()->user()->idcardpassed )
        
<div class="m-form">
    <ul>
        <li class="clearfix">
            <label>真实姓名：</label><span>{{ App\User::hiddenXin(auth()->user()->name) }}</span>
        </li>
        <li class="clearfix">
            <label>身份证号：</label><span>{{ preg_replace('/([0-9]{4})[0-9]{10}([0-9]{4})/i','$1*******$2',auth()->user()->idno) }}</span>
        <input type="hidden" value="2271097" id="uid" name="uid">
        </li>
        <li class="clearfix"><label class="red-color">温馨提示：</label><p class="p-text"> 如果您在公安机关修改过姓名，请联系您的理财师或网站客服，凭有关公安机关改名的核证材料修改您的身份信息，谢谢！客服电话：400-6090-290</p></li>
    </ul>
</div>
    @else
    {!! Form::open(['route'=>'member.account.authenticate','class'=>'auth-form','id'=>'auth-form']) !!}
    <div class="m-form">
        @if( count($errors) > 0)
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <ul class="clearfix">
            <li class="clearfix">
                <label><em>*</em>真实姓名</label>
                <input type="text" name="real_name" id="real-name">
            </li>
            <li class="clearfix">
                <label><em>*</em>身份证号</label>
                <input type="text" name="idno" id="idno">
            </li>
            <li class="clearfix">
                <p class="p-text"><button id="btn-mod" class="btn-group" href="javascript:void(0);">提交认证</button></p>
            </li>
            <li class="clearfix">
                <p class="p-title">温馨提示</p>
                <p class="p-text">1、请填写真实的认证信息。</p>
                <p class="p-text">2、认证信息跟提现相关,提现使用认证信息的相关信息进行验证。</p>
                {{-- <p class="p-text">3、认证信息跟提现相关,提现使用认证信息的相关信息进行验证。</p> --}}
            </li>
        </ul>
    </div>
    @endif    
</div>
@stop

@section('js')
@stop