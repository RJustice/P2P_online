@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="/index.php?ctl=uc_money">基础信息</a>
    </div>
</div>
<div class="tab-box clearfix  safe-info">
    <ul class="security-ul">
        <li>
            <div class="it cf clearfix">
                <div class="icon nicheng"></div>
                <h3>个人信息</h3>
                <p class="f_red">未完善</p>
                <div class="update"><a href="{{ route('member.account.basic') }}">修改</a></div>
            </div>
        </li>
        <li>
            <div class="it cf clearfix">
                <div class="icon reaname"></div>
                <h3>实名认证</h3>
                @if( auth()->user()->idcardpassed )
                <p>{{ auth()->user()->formatInfo(true) }}</p>
                <div class="update">已认证</div>
                @else
                <p class="f_red">未认证</p>
                <div class="update"><a id="go-auth" href="{{ route('member.account.authenticate') }}">认证</a></div>    
                @endif
                
            </div>
            <div style="display:none;" id="setting-idno-box"></div>
        </li>
        
        <li>
            <div class="it cf clearfix">
                <div class="icon pwd"></div>
                <h3>登录密码</h3>
                <p>已设置</p>
                <div class="update"><a id="reset-pwd" href="{{ route('member.account.resetpwd') }}">修改</a></div>
            </div>            
        </li>
        {{-- <li>
            <div class="it cf clearfix">
                <div class="icon email"></div>
                <h3>绑定邮箱</h3>
                <p>已设置</p>
                <div class="update"><a id="J_setting_email" href="javascript:void(0);">修改</a></div>
            </div>            
            <div style="display:none;" id="setting-email-box"></div>
        </li> --}}
        <li>
            <div class="it cf clearfix">
                <div class="icon mobile"></div>
                <h3>绑定手机</h3>
                <p>{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}</p>
                {{-- <div class="update"><a id="reset-phone" href="{{ route('member.account.resetphone.one') }}">修改</a></div> --}}
            </div>
        </li>        
        <li>
            <div class="it cf clearfix">
                <div class="icon paypwd"></div>
                <h3>支付密码</h3>
                @if( auth()->user()->paypassword )
                <p class="">已设置</p>
                <div class="update"><a id="reset-pay" href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'change']) }}">修改</a>&nbsp;/&nbsp;<a href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'find']) }}">找回</a></div>
                @else
                <p class="f_red">未设置</p>
                <div class="update"><a id="reset-pay" href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'new']) }}">设置</a></div>
                @endif
            </div>
        </li>
    </ul>
</div>{{-- 

<div id="setting-pwd-box" class="layer">
    <div class="inc_main">
        <div style="margin-bottom:20px;padding-left:52px;padding-top:50px;" class="lh22 f14">
            <div class="field password">
                <label for="settings-old-password"><span class="red">*</span>旧密码</label>
                <input type="password" id="settings-old-password" name="old_password" class="f-input ipttxt" value="">
            </div>
            <div class="blank10"></div>            
            <div class="field password">
                <label for="settings-password"><span class="red">*</span>新密码</label>
                <input type="password" id="settings-password" name="password" class="f-input" value="">
                <span class="hint">最少 6 个字符 </span> 
            </div>
            <div class="blank10"></div>
            <div class="field passwrod">
                <label for="settings-password-comfirm"><span class="red">*</span>确认密码</label>
                <input type="password" id="settings-password-confirm" name="password-confirm" class="f-input" value="">
            </div>
            <div class="blank20"></div>
            <div style="padding-left:190px;_padding-left:180px;">
                <input type="button" value="保存更改" name="commit" id="settings-password-submit" class="sub_btn">
            </div>
        </div>
    </div>
</div> --}}
@stop