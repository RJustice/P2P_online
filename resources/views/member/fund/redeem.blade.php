@extends('_layouts.center')
@section('css')
<style type="text/css">
    .withdrawal label{width:160px;margin-right:15px;}
</style>
@stop

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="{{ route('member.fund.redeem') }}">赎回</a>
    </div>
    <div class="">
        <a href="{{ route('member.fund.redeemlogs') }}">赎回记录</a>
    </div>
</div>
<div class="tab-box clearfix">
    <div class="withdrawal">
        <ul>
          <li class="clearfix"><label>选择赎回的产品:</label>
            <select name="deal_order_id" id="deal-order-select">
                <option value="0">请选择</option>
                @foreach($dealOrders as $dealOrder )
                <option value="{{ $dealOrder->getKey() }}" @if( $dealOrder->getKey() == $id ) selected="selected" @endif>{{ $dealOrder->deal_title }} - 开始：{{ $dealOrder->create_date }} - {{ $dealOrder->total_price }}元</option>
                @endforeach
            </select>
            <span class="error"></span>
          </li>
          <li class="clearfix"><label>产品详情：</label>
            <div style="float:left;" id="deal-order-info">
                <p>请选择想要赎回的理财订单</p>
            </div>
          </li>
          <li class="clearfix"><label>手续费：</label><span class="money" id="sxf"></span></li>
          <li class="clearfix"><label>支付密码：</label><input placeholder="" name="" id="txtPassword" type="password">&nbsp;&nbsp;&nbsp;<a href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'find']) }}" class="blue-color">忘记密码？</a><span class="error"></span></li>
          <li><label>手机验证码：</label><input placeholder="" name="" id="txtcode" type="text"><span class="bank-information"><a href="javascript:void(0);" class="get-code" id="re-sms">获取短信验证码</a></span><span class="error"></span></li>
          <li><a href="javascript:void(0);" class="a-btn" onclick="ac()">确认赎回</a></li>
          <li style="padding-top:20px">
              <h3>温馨提示：</h3>
              <p class="p-text">1、尊敬的{{ App\User::hiddenXin(auth()->user()->name) }}，您正在提交赎回项目申请</p>
              <p class="p-text">2、赎回申请一般在十个工作日内完成，如遇国家假日则顺延。</p>
              <p class="p-text">3、赎回手续费为项目本金的3%。</p>
              <p class="p-text">4、赎回项目获取收益截止时间为赎回申请日。</p>
              <p class="p-text">5、涉及到您的资金安全，请仔细操作。 </p>
          </li>
        </ul>
    </div>
</div>
<div id="confirm-modal" style="text-align:left;" class="layer">
    <div id="deal-order-info-confirm"></div>
    <p style="text-align:center">请核对信息,确认赎回.</p>
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
<div id="alert-order-error" class="layer">  
    <p>查无此理财订单,可能已经申请赎回或者已经到期.</p>
    <p><a onClick="javascript:alertModal.close()" class="a-btn">确定</a></p>
</div>
<div id="alert-network-error" class="layer">
    <p>网络错误,请刷新重试.</p>
    <p><a onClick="javascript:alertModal.close();" class="a-btn">确定</a></p>
</div>
<div id="alert-success" class="layer">
    <p>申请已提交成功,十个工作日内完成赎回.</p>
    <p><a onClick="javascript:alertModal.close();" class="a-btn">确定</a></p>
</div>
<div id="alert-sms-send" class="layer">
    <p>验证码已发送至手机：{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}</p>
    <p><a onClick="javascript:alertModal.close();" class="a-btn">确定</a></p>
</div>
@stop

@section('js')
<script type="text/javascript">
var dealOrders = {
    @foreach($dealOrders as $k=>$dealOrder )    
    <?php 
        $start = date_create($dealOrder->create_date);
        $end = date_create($dealOrder->finish_date);
        $now = date_create(date('Y-m-d'));
        $diff1 = date_diff($end,$start);
        $diff2 = date_diff($now,$start);
        $days = $diff1->days;
        $nowDays = $diff2->days;
     ?>
    {{ $dealOrder->getKey() }}:{
        type:{{ $dealOrder->deal_type }},
        title:'{{ $dealOrder->deal_title }}',
        total_price:{{ $dealOrder->total_price }},
        start:'{{ $dealOrder->create_date}}',
        end:'{{ $dealOrder->finish_date }}',
        waiting:{{ $dealOrder->deal_waiting_returns }},
        daily:{{ $dealOrder->deal_daily_returns }},
        rate:{{ $dealOrder->deal_rate }},
        yearning:'{{ number_format($dealOrder->deal_daily_returns * $days * $dealOrder->total_price / 10000,2) }}',
        tearning:'{{ number_format($dealOrder->deal_daily_returns * $nowDays * $dealOrder->total_price / 10000,2) }}',
        sxf:'{{ number_format($dealOrder->total_price * 0.03,2) }}'
    }@if($k != count($dealOrders)-1) , @endif
    @endforeach
};
</script>
<script type="text/javascript">
    $(function(){
        var id = $("#deal-order-select").val();
        function buildOrderInfo(id){
            if( id == 0 ){
                $("#sxf").text(0);
                return '<p>请选择想要赎回的理财订单</p>';
            }
            var dealOrder = dealOrders[id];
            var tpl = '';
            tpl = '<p><label class="d-label">理财产品：</label>'+dealOrder.title+'</p>\
                <p><label class="d-label">起始日期：</label>'+dealOrder.start+' ~ '+dealOrder.end+'</p>\
                <p><label class="d-label">投资金额：</label><span class="money">'+dealOrder.total_price+'</span></p>\
                <p><label class="d-label">预期年利率：</label>'+dealOrder.rate+' %</p>\
                <p><label class="d-label">预期到期收益：</label><span class="money">'+dealOrder.yearning+'</span></p>\
                <p><label class="d-label">截止今日,待收收益：</label><span class="money">'+dealOrder.waiting+'</span></p>';
            $("#sxf").text(dealOrder.sxf);            
            return tpl;
        }

        $("#deal-order-info").html(buildOrderInfo(id));
        $("#deal-order-info-confirm").html(buildOrderInfo(id));
        $("#deal-order-select").change(function(){
            var id = $(this).val();
            var tpl = buildOrderInfo(id);
            $("#deal-order-info").html(tpl);
            $("#deal-order-info-confirm").html(tpl);
            $('.error:eq(0)').text("");
        });

        $("#txtPassword").on('focus',function(){
            $('.error:eq(1)').text("");
        });
        $("#txtcode").on('focus',function(){
            $('.error:eq(2)').text("");
        });
    });   
    function ac(){
        var dorder = $("#deal-order-select").val();
        var password = $("#txtPassword").val();
        var textcode = $("#txtcode").val();
        if(!dorder ||dorder == 0 ) {
          $('.error:eq(0)').text("请选择想赎回的理财产品");
        }
        if(!password) {
          $('.error:eq(1)').text("请输入支付密码!");
        }
        if(!textcode){
          $('.error:eq(2)').text("请输入短信验证码");
        }
        if($('.error').text() == ""){
          console.log('open modal');
          confirmModal();
        }
    }

    var modal,alertModal;
    function confirmModal(){
    var orderid = $('#deal-order-select').val();
    var smscode = $("#txtcode").val();
    var paypwd = $("#txtPassword").val();

    modal = new jBox('Confirm',{
        title : '确认赎回信息',
        content: $("#confirm-modal"),
        overlay : true,
        closeOnEsc : false,
        closeOnClick : false,
        closeButton: 'title',
        confirmButton : '确认',
        cancelButton : '取消',
        confirm : function(){
            $.ajax({
                url : '{{ route("member.fund.redeem") }}',
                type: 'post',
                data: {orderid:orderid,_token:'{{ csrf_token() }}',smscode:smscode,paypwd:paypwd},
                dataType: 'json',
                success:function(data){
                    if( data.code == 0 ){
                        alertModal = new jBox('Modal',{
                            title: "申请已提交",
                            content: $("#alert-success"),
                            overlay: true,
                            closeButton: 'title',
                            onCloseComplete: function(){
                                window.location.href = '{{ route("member.fund.redeemlogs") }}';
                            }
                        });
                        alertModal.open();
                    }else if( data.code == 1 ){
                        alertModal = new jBox('Modal',{
                            title: "验证码错误",
                            content: $("#alert-sms-error"),
                            overlay: true,
                            closeButton: 'title',
                        });
                        alertModal.open();
                    }else if( data.code == 2 ){
                        alertModal = new jBox('Modal',{
                            title: "支付密码错误",
                            content: $("#alert-pwd-error"),
                            overlay: true,
                            closeButton: 'title',
                        });
                        alertModal.open();
                    }else if( data.code ==3 ){
                        alertModal = new jBox('Modal',{
                            title: "无此订单",
                            content: $("#alert-order-error"),
                            overlay: true,
                            closeButton: 'title',
                        });
                        alertModal.open();
                    }
                },
                error:function(){
                    alertModal = new jBox('Modal',{
                        title: "网络错误",
                        content: $("#alert-network-error"),
                        overlay: true,
                        closeButton: 'title',
                    });
                    alertModal.open();
                }
            });
            modal.close();
        }
    });
    modal.open();
    }
</script>
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
        off = 0;

        $("#re-sms").on('click',function(){
            if( off ){
                return;
            }
            leftsecond = 120;
            $("#sendTip").text('短信验证码发送中……，发送至：');
            off = 1;
            $.ajax({
                url : '{{ url('sms/send') }}',
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