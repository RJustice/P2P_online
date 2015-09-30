@extends('_layouts.center')
@section('css')
@stop

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="{{ route('member.fund.carry') }}">提现</a>
    </div>
    <div class="">
        <a href="{{ route('member.fund.carrylogs') }}">提现记录</a>
    </div>
</div>
<div class="tab-box clearfix">
    <div class="withdrawal">
        <ul>
          <input type="hidden" id="bank" value="{{ auth()->user()->bank->getKey() }}">
          <li class="clearfix"><label>您的银行卡：</label>{{ auth()->user()->bank->bank_name }}&nbsp;&nbsp;{{ App\UserBank::formatBankCard(auth()->user()->bank->bankcard) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ route('member.account.bankcard') }}" class="blue-color">修改</a></li>
          <li class="clearfix"><label>可提金额：</label><em class="orange-color" id="cash">{{ number_format(auth()->user()->can_money,2) }}</em> 元</li>
          <li class="clearfix pb20"><label>提现金额：</label><input placeholder="" id="J_Deposit" value="" type="text">元<span class="capital"></span><span class="error-hint"><i class="error"></i></span></li>
          <li class="clearfix"><label>手续费：</label>当前免收手续费，后期收取费用会另行通知</li>
          <li class="clearfix"><label>到账提示：</label>72小时-24小时（72小时内到账，到账时间因各个银行不同）</li>
          <li class="clearfix"><label>支付密码：</label><input placeholder="" name="" id="txtPassword" type="password">&nbsp;&nbsp;&nbsp;<a href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'find']) }}" class="blue-color">忘记密码？</a><span class="error"></span></li>
          <li><label>手机验证码：</label><input placeholder="" name="" id="txtcode" type="text"><span class="bank-information"><a href="javascript:void(0);" class="get-code" id="re-sms">获取短信验证码</a></span><span class="error"></span></li>
          <li><a href="javascript:void(0);" class="a-btn" onclick="ac()">提&nbsp;&nbsp;现</a></li>
          <li style="padding-top:20px">
              <h3>温馨提示：</h3>
              <p class="p-text">1、尊敬的{{ App\User::hiddenXin(auth()->user()->name) }}，提现操作涉及您的资金变动，请仔细核对您的提现信息；</p>
              <p class="p-text">2、工作日，15点前的提现一般可当日到达；500万元以上的提现，预计在48小时内可到达； 周末及法定假日顺延；</p>
              <p class="p-text">3、每月10日至13日为提现高峰期，可能会出现提现处理滞后（48-72小时左右），请您提前做好资金安排； </p>
              <p class="p-text">4、涉及到您的资金安全，请仔细操作。 </p>
          </li>
        </ul>
    </div>
</div>
<div id="confirm-modal" style="text-align:left;" class="layer">
    <p>提款金额：<span style="color:#ff6600" id="cmoney"></span></p>
    <p>提款账号：{{ App\UserBank::formatBankCard(auth()->user()->bank->bankcard) }}</p>
    <p style="text-align:center">请核对信息,确认提款.</p>
</div>
<div id="alert-sms-error" class="layer">
    <p>短信验证码错误,请重新输入或重新获取验证码.</p>
    <p><a onClick="javascript:alertModal.close()" class="a-btn">确定</a></p>
</div>
<div id="alert-pwd-error" class="layer">
    <p>支付密码错误,请重新输入.</p>
    <p><a href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'find']) }}">忘记密码</a></p>
    <p><a onClick="javascript:alertModal.close()" class="a-btn">确定</a></p>
</div>
<div id="alert-money-error" class="layer">  
    <p>您账户可用余额不足!请核对您的资金账户.</p>
    <p><a onClick="javascript:alertModal.close()" class="a-btn">确定</a></p>
</div>
<div id="alert-network-error" class="layer">
    <p>网络错误,请刷新重试.</p>
    <p><a onClick="javascript:alertModal.close();" class="a-btn">确定</a></p>
</div>
<div id="alert-success" class="layer">
    <p>提现申请成功,72小时内到账.</p>
    <p><a onClick="javascript:alertModal.close();" class="a-btn">确定</a></p>
</div>
<div id="alert-sms-send" class="layer">
    <p>验证码已发送至手机：{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}</p>
    <p><a onClick="javascript:alertModal.close();" class="a-btn">确定</a></p>
</div>
@stop

@section('js')
<script type="text/javascript">
    var carryUrl = '{{ route('member.fund.carry') }}';
    var token = '{{ csrf_token() }}';
    var carryLog = '{{ route('member.fund.carrylogs') }}';
</script>
<script type="text/javascript" src="/js/carry.js"></script>
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
                        alertModal = new jBox('Modal',{
                            title: "验证码已发送",
                            content: $("#alert-sms-send"),
                            overlay: true,
                            closeButton: 'title',
                        });
                        alertModal.open();
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