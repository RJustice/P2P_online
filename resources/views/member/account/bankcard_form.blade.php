{!! Form::open(['route'=>'member.account.bankcard','class'=>'form-horizontal','id'=>'bankcard-form']) !!}
<div class="m-form">
    <ul class="clearfix">
        <li class="clearfix">
            <label><em>*</em>银行账户类型</label>
            <span class="wrap-span">借记卡&nbsp;&nbsp;&nbsp;&nbsp;不支持提现至信用卡账户</span>
        </li>
        <li class="clearfix">
            <label><em>*</em>开户人姓名</label>
            <span class="wrap-span">{{ App\User::hiddenXin(auth()->user()->name) }}</span>
        </li>
        <li class="clearfix">
            <label><em>*</em>银行卡号</label>
            <input type="text" name="bankcard" id="bankcard">
            <span class="error"></span>
        </li>
        <li class="clearfix">
            <label><em>*</em>确认银行卡号</label>
            <input type="text" name="bankcard_confirmation" id="bankcard_confirmation">
            <span class="error"></span>
        </li>
        <li class="clearfix">
            <label>选择银行</label>
            {!! Form::select('bank',App\Bank::getBankOption()) !!}
        </li>
        <li class="clearfix">
            <label><em>*</em>开户行所在地</label>
            {!! Form::select('province_id',[]) !!}<span class="span-instructions">（省/直辖市）</span>
            {!! Form::select('city_id',[]) !!}<span class="span-instructions">（市）</span>            
            {!! Form::select('county_id',[]) !!}<span class="span-instructions">（区/地级市）</span>
        </li>
        <li class="clearfix">
            <label><em>*</em>开户行名称</label>
            <input type="text" name="bankzone" id="txt-bankName">
            <span class="error">（如不能确定，请拨打开户行的客服热线咨询）</span>
        </li>
        <li class="clearfix">
            <label><em>*</em>手机验证码</label>
            <input type="text" name="smscode" id="txt-smscode">
            <a class="get-code" id="re-sms" href="javascript:void(0);">获取手机验证码</a>
            <span class="error"></span>
        </li>
        <li class="clearfix">
            <p><a id="btn-mod" class="btn-group" href="javascript:void(0);" onClick="javascript:document.getElementById('bankcard-form').submit();">修改</a><a id="cancel" class="btn-group" href="javascript:void(0);">取消</a></p>
        </li>
        <li class="clearfix">
            <p class="p-title">温馨提示</p>
            <p class="p-text">1、请用户尽量填写较大的银行（如农行、工行、建行、中国银行等），避免填写那些比较少见的银行（如农
村信用社、平安银行、恒丰银行等）。 否则提现资金很容易会被退票。</p>
            <p class="p-text">2、请您填写完整联系方式，以便遇到问题时，工作人员可以及时联系到您。</p>
        </li>
    </ul>
</div>
{!! Form::close() !!}

@section('js')
    @parent
    @include('common.regionjs',['uri'=>'bank'])
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