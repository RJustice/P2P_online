@extends("_layouts.center")

@section('css')
<style type="text/css">
.invest-tc-box .me-invest {
    padding: 30px 45px 0;
}
.me-invest .step {
    margin: 0 auto;
    padding: 0 0 20px;
}

.tc {
    text-align: center;
}
.me-invest .tc {
    height: 48px;
    width: 100%;
}
.me-invest .step .p-invest {
    padding-top: 15px;
}

.me-invest .step .p-invest span {
    color: #999;
    font-size: 18px;
    padding-left: 20px;
}
.me-invest .step .p-invest .span02 {
    margin: 0 108px;
}

.me-invest .form-box {
    border-top: 1px solid #eaeaea;
    margin: 22px auto 0;
    padding: 30px 25px 0;
    width: 450px;
}
.me-invest .form-box li {
    clear: both;
    color: #999;
    font-size: 14px;
    line-height: 24px;
    padding: 0 0 22px;
    position: relative;
}
.me-invest .form-box li label {
    color: #999;
    float: left;
    font-size: 14px;
    height: 24px;
    line-height: 24px;
    padding: 0 14px 0 0;
    text-align: right;
    width: 7em;
}
.me-invest .form-box input[type="text"], .me-invest .form-box input[type="password"] {
    border: 1px solid #cccccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    height: 22px;
    line-height: 1.42857;
    margin-right: 0;
    padding: 0 15px;
    width: 176px;
}
.me-invest .form-box li .error {
    color: #ff0000;
}
.me-invest .form-box li .error, .me-invest .form-box li .int-num {
    clear: both;
    display: block;
    font-size: 12px;
    left: 0;
    line-height: 16px;
    padding-left: 84px;
    position: absolute;
    top: 26px;
}
.error {
    color: #ff0000;
    padding: 0 10px;
}
.me-invest .form-box .p-btn {
    padding: 15px 0 0;
}

.me-invest .form-box .a-btn {
    background: #009dde none repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
    display: block;
    float: none;
    font-size: 18px;
    height: 40px;
    line-height: 40px;
    margin: 0 auto;
    text-align: center;
    width: 150px;
}
.change-pad .form-box {
    border: 0 none;
    margin-top: 0;
    padding: 0;
    width: 100%;
}
.change-pad .form-box li {
    padding: 0 0 30px;
}

.change-pad .form-box li label {
    color: #666;
    font-size: 17px;
    height: 50px;
    line-height: 50px;
    padding: 0 10px 0 0;
    width: 153px;
}

.change-pad .span-pho {
    color: #898989;
    font-size: 18px;
    line-height: 50px;
}

.change-pad .step .p-invest .fz-color {
    color: #00b4ff;
}
.change-pad .step .p-invest .mar-left {
    margin-left: 54px;
}
.change-pad .step .p-invest .span02 {
    margin: 0 44px;
}
.change-pad .step .p-invest .span03 {
    margin: 0 43px;
}
.change-pad .form-box input[type="password"], .change-pad .form-box input[type="text"] {
    border-radius: 5px;
    float: left;
    height: 48px;
    line-height: 48px;
    width: 362px;
}
.change-pad .form-box input.change-input-wid {
    border-radius: 5px;
    float: left;
    height: 48px;
    line-height: 48px;
    width: 200px;
}

.change-pad .getcode {
    background: #00ccff none repeat scroll 0 0;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    display: inline-block;
    float: left;
    font-size: 18px;
    height: 50px;
    line-height: 50px;
    margin-left: 33px;
    text-align: center;
    width: 130px;
}
.change-pad .form-box li .error {
    padding-left: 164px;
    top: 54px;
}

.change-pad .form-box .p-btn {
    padding: 15px 0 0 164px;
}
.change-pad .form-box .a-btn {
    background: #00b4ff none repeat scroll 0 0;
    float: left;
    height: 44px;
    line-height: 44px;
    width: 364px;
}
</style>
@stop

@section("content")
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">绑定手机修改</a>
    </div>
</div>
<div class="tab-box pub-box resetphone-box invest-tc-box" style="width:720px">
    {!! Form::open(['route'=>'member.account.resetphone.one','class'=>'reset-phone-one','id'=>'reset-phone-one']) !!}
    <div class="me-invest change-pad">
        <div class="step" style="display: block;">
            <p class="tc"><img src="/images/step1.png"></p>
            <p class="p-invest"><span class="fz-color mar-left">验证原手机号码</span><span class="span02">验证新手机号码</span><span class="span03">成功</span></p>
        </div>
        <div class="form-box" style="display: block;">
            <ul>
                <li class="clearfix"><label>原手机号码：</label><span class="span-pho">{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}</span></li>
                <li class="clearfix"><label>手机验证码：</label><input type="text" placeholder="" class="change-input-wid" id="old-tel-code" name="old_tel_code"><span class="getcode" id="re-sms">获取验证码</span><span id="send-sms-tip" class="error"></span></li>
            </ul>
            <p class=" clearfix p-btn"><button class="a-btn" id="modifytel-firststep" href="javascript:void(0)">下一步</button></p>
        </div>        
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