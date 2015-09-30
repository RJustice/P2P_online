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
        @if($ctl == 'new')
        <a href="javascript:;">设置支付密码</a>
        @elseif($ctl == 'change')
        <a href="javascript:;">修改支付密码</a>
        @elseif($ctl == 'find')
        <a href="javascript:;">找回支付密码</a>
        @endif
    </div>
</div>
<div class="tab-box pub-box resetpwd-box">
    {!! Form::open(['route'=>'member.account.resetpay','class'=>'form-horizontal','id'=>'resetpay-form']) !!}
    <div class="m-form">
    @if($ctl == 'new')
        <ul class="clearfix">
            <li class="clearfix">
                <label><em>*</em>登陆密码</label>
                <input type="password" name="oldpwd" id="oldpwd" placeholder="">
                <span class="error">请输入账号登录密码</span>
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
                <label>绑定手机号</label>{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}
            </li>
            <li class="clearfix">
                <label><em>*</em>手机验证码</label>
                <input type="text" name="smscode" id="smscode">
                <a class="get-code" id="re-sms" href="javascript:void(0);">获取手机验证码</a>
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <input type="hidden" name="ctl" value="new">
                <p style="padding: 0 30px 0 158px;"><button id="btn-mod" class="btn-group" href="javascript:void(0);" onClick="javascript:document.getElementById('bankcard-form').submit();">设置</button><a id="cancel" class="btn-group" href="{{ route('member.account.safe') }}">取消</a></p>
            </li>
        </ul>
    @elseif($ctl == 'change')
        <ul class="clearfix">
            <li class="clearfix">
                <label><em>*</em>原始支付密码</label>
                <input type="password" name="oldpwd" id="oldpwd" placeholder="">
                <span class="error"></span>
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
                <input type="hidden" name="ctl" value="change">
                <p style="padding: 0 30px 0 158px;"><button id="btn-mod" class="btn-group" href="javascript:void(0);" onClick="javascript:document.getElementById('bankcard-form').submit();">修改</button><a id="cancel" class="btn-group" href="{{ route('member.account.safe') }}">取消</a></p>
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
                <label>绑定手机号</label>{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}
            </li>
            <li class="clearfix">
                <label><em>*</em>手机验证码</label>
                <input type="text" name="smscode" id="smscode">
                <a class="get-code" id="re-sms" href="javascript:void(0);">获取手机验证码</a>
                <span class="error"></span>
            </li>
            <li class="clearfix">
                <input type="hidden" name="ctl" value="find">
                <p style="padding: 0 30px 0 158px;"><button id="btn-mod" class="btn-group" href="javascript:void(0);" onClick="javascript:document.getElementById('bankcard-form').submit();">提交</button><a id="cancel" class="btn-group" href="{{ route('member.account.safe') }}">取消</a></p>
            </li>
        </ul>
    @endif        
    </div>
    {!! Form::close() !!}
</div>
@stop

@section('js')
<script type="text/javascript">
    var seconds = 0;
    var mbTest = /^(1)[0-9]{10}$/;
    var timer = null;
    var leftsecond = 120; //倒计时
    var msg = "";
    var off = 1;
    var tip = $("#sendTip").text();

    function setLefttime(){
        var second = Math.floor(leftsecond);
        $('#re-sms').addClass('gray-span');
        $("#re-sms").html(msg + leftsecond + "秒后可重发");
        leftsecond--;
        off = 1;
        if (leftsecond < 1) {
            clearInterval(timer);
            try {
                $("#re-sms").html("重新获取验证码");
                document.getElementById('re-sms').disabled = false;
                off = 0;
            } catch (E) { }
            return;
        }
    }

    $(document).ready(function(){
        // $('#register-form').validationEngine('attach', { 
        //   promptPosition: 'centerRight', 
        //   scroll: false,
        //   autoHidePrompt:true,
        //   autoHideDelay:5000,
        //   addSuccessCssClassToField:'check-success',
        //   addFailureCssClassToField:'check-fail'
        // });

        // clearInterval(timer);
        // timer = setInterval(setLefttime,1000,'1');
        off = 0;

        $("#re-sms").on('click',function(){
            if( off ){
                return;
            }
            leftsecond = 120;
            $("#sendTip").text('短信验证码发送中……，发送至：');
            off = 1;
            $.ajax({
                url : '{{ url('sms/test') }}',
                type : 'post',
                data : {_token:'{{ csrf_token() }}'},
                dataType : 'json',
                success : function(data){
                    if( data.status == 0 ){
                        $("#sendTip").text(tip);
                        alert(data.code);
                    }else{
                        $("#sendTip").text(tip);
                        $("#send-sms-tip").text(data.msg);
                    }
                    clearInterval(timer);
                    timer = setInterval(setLefttime,1000,'1');
                },
                error : function(){
                    off =0;
                }
            });
        });
    });
</script>
@stop