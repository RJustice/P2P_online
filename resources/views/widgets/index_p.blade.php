@section('css')
@parent
    <link rel="stylesheet" href="{{ asset('css/jBox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/invest_box.css') }}">
    <style type="text/css">
    .layer{display: none;padding:15px 30px;}
    .layer p{font-size:14px;font-weight: 600;text-align:center;height:30px;line-height: 30px;}
    .layer p .a-btn{font-size:16px;height:38px;line-height:39px;width:auto;float:none;padding:7px 25px;margin:auto;cursor: pointer;}
    .money{color: #ff5a13;font-size: 14px;}
    .binvest-submit.disabled,.pinvest-submit.disabled{background: #c0c0c0;}
    </style>
@stop
<div class="new-wrap g-list clearfix">
    <ul id="pl_home_projectList" class="clearfix">
        @foreach( $deals  as $k=>$deal )
        <li class="invest-box">
            <div class="m-list m-list01">
                <div class="padding-lr">
                    <div class="top-icon">
                        <a href="javascript:;"><i class="icon-{{ $k+1 }}"></i><p>{{ $deal->title }}<i></i></p></a>
                    </div>
                    <a href="javascript;">
                        <div class="m-subject clearfix">
                            <dl class="subject-left">
                                <dt class="the-big">{{ $deal->rate }}<em>%</em></dt>
                                <dd>预期年化收益率</dd>
                            </dl>
                            <dl class="subject-right">
                                <dt class="the-small">{{ $deal->repay_time }}<em>天</em></dt>
                                <dd>投资期限</dd>
                            </dl>
                        </div>
                    </a>
                </div>
                <div class="btn-investment">
                    <a class="invest-unfold" href="javascript:;">立即投资</a>
                </div>
            </div>
            <!-- 弹出投资start -->
            <div class="big-show @if( $k % 3 == 2) big-show-right @endif" style="width: 0px;">
            <!-- big-show-right大块 -->
                <div class="big-show-inner" style="width: 632px;">
                    <div class="m-list show-left show-right">
                <!-- show-right -->
                    <div class="padding-lr inner">
                        <div class="top-icon">
                            <i class="icon-{{ $k+1 }}"></i><p>{{ $deal->title }}<i></i></p>
                        </div>
                        <div class="m-subject clearfix">
                            <dl class="subject-left">
                                <dt class="the-big">{{ $deal->rate }}<em>%</em></dt>
                                <dd>预期年化收益率</dd>
                            </dl>
                            <dl class="subject-right">
                                <dt class="the-small">{{ $deal->repay_time }}<em>天</em></dt>
                                <dd>投资期限</dd>
                            </dl>
                        </div>
                        <p class="p-text03">付息方式：{{ \App\Deal::getLoanTypeTitle($deal->loan_type) }}</p>
                        <p class="p-text04">赎回方式：T+10 ， 计息截止日期赎回当日0点</p>
                    </div>
                </div>
                    <div class="pop-investment pop-investment-left">
                <!-- pop-investment-left -->
                    <span class="close01">关闭</span>
                    <h3><i></i>{{ $deal->title }}</h3>
                    <p class="z-text01"><a href="javascript:;">{{ $deal->title }}</a></p>
                    <div class="m-progress">
                        <div class="progress-bar">
                            <div style="width:{{ number_format($deal->load_money / $deal->borrow_amount *100 ,2) }}%" class="z-bar"><em></em></div>
                        </div>
                        <p class="z-total">
                            <span>总额：<em>{{ floor($deal->borrow_amount / 10000) }}</em>万元</span>
                            <span>可投：<em>{{ number_format(( $deal->borrow_amount - $deal->load_money ) / 10000,2) }}万元</em></span>
                        </p>
                    </div>
                    <div style=" position: relative;" class="row-mg">
                        <em>输入金额：</em>
                        <i>元</i>
                        <input type="text" data-id="{{ $deal->getKey() }}" id="h_enter_value{{ $deal->getKey() }}" class="money-input" maxlength="11">
                        <span class="p-error" id="h_jx_notice{{ $deal->getKey() }}" style="display:none;"></span>
                    </div>

                    <div class="row-mg">
                        <em>预计收益：</em>
                        <i>元</i>
                        <span class="expected-text" id="h_ys{{ $deal->getKey() }}"></span>
                    </div>

                    <div class="investment-btn">
                        <a data-name="{{ $deal->title }}" data-tzqx="{{ floor( $deal->repay_time / 30 ) }}" data-borrowinterestrate="{{ $deal->rate }}" data-startmoney="{{ $deal->min_loan_money }}" data-borrowmin="0" data-borrowmax="" data-model="ewealth" data-need="" data-ishetong="1" data-pass="0" data-id="{{ $deal->getKey() }}" id="h_jx_payment{{ $deal->getKey() }}" id="h_jx_payment{{ $deal->getKey() }}" class="invest-btn invest-layer" href="javascript:;"></a>
                    </div>
                </div>
                </div>
            </div>
            <!-- 弹出投资end -->
        </li>
        @endforeach        
    </ul>
    <p class="clearfix ckwq"><a target="_blank" href="/invest">查看全部</a> </p>
</div>
<div id="balance-invest" class="" style="display:none;">
    <div id="binvest-form" style="width:550px;">
        <input type="hidden" name="id" value="" class="deal-id">
        <div class="me-invest succ">
            <div class="form-box">
                <div id="binvest-step1">
                    <div class="step">
                        <p class="tc step1"><i></i></p>
                        <p class="p-invest">
                            <span>确认支付</span>
                            <span class="span02">确认投资</span>
                            <span>投资完成</span>
                        </p>
                    </div>
                    <ul>
                        <li class="clearfix">
                            <label>投资项目：</label>
                            <a href="javascript:;" target="_blank" class="binvest-deal-title"></a>,预期年化收益: <span class="binvest-deal-rate"></span>%
                        </li>
                        <li class="clearfix">
                            <label>投资金额：</label>
                            <input type="text" name="money" class="binvest-money-input" value="" maxlength="11">
                            <span class="error money-input-error"></span>
                            <span class="yuan">元</span>
                        </li>
                        <li class="clearfix">
                            <label>预期收益：</label>
                            <input type="text" class="binvest-expect-input" value="" disabled>
                            <span class="yuan">元</span>
                        </li>
                        <li class="clearfix">
                            <label>支付密码：</label>
                            <input type="password" name="paypass" class="pass-input">
                            <span class="error pass-input-error"></span>
                            <a href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'find']) }}" target="_blank" class="forget-password">忘记支付密码？</a>
                        </li>
                    </ul>
                    <p class="read clearfix">
                        <input type="checkbox" name="agree" class="agree-check">已阅读并同意
                        <a target="_blank" href="javascript:;">《保理服务协议》</a>
                        <a target="_blank" href="javascript:;">《债权转让协议》</a>
                    </p>
                    <p class="error agree-error" style="display:none;">请同意上述协议</p>
                    <p class=" clearfix p-btn">
                        <a href="javascript:;" class="a-btn pay-btn next-step02">下一步</a>
                    </p>
                </div>
                <div id="binvest-step2" style="display:none;">
                    <div class="step">
                        <p class="tc step2"><i></i></p>
                        <p class="p-invest">
                            <span>确认支付</span>
                            <span class="span02">确认投资</span>
                            <span>投资完成</span>
                        </p>
                    </div>
                    <ul>
                        <li>
                            <p class="confirm-invest">
                            尊敬的<span>{{ Auth::check() ? auth()->user()->name : '' }}</span>，您是否确定要进行以下投资？
                            </p>
                        </li>
                        <li class="clearfix">
                            <label>投资项目：</label>
                            <a href="javascript:;" target="_blank" class="binvest-deal-title"></a>
                        </li>
                        <li class="clearfix">
                            <label>投资金额：</label><span class="money binvest-money"></span>元
                        </li>
                        <li class="clearfix">
                            <label>预期收益：</label><span class="money binvest-earnings"></span>元
                        </li>
                        <li class="clearfix">
                            <label>账户余额：</label><span class="money binvest-balance"></span>元
                        </li>
                    </ul>
                    <p class=" clearfix p-btn">
                        <a href="javascript:;" class="a-btn invest-btn binvest-submit">确&nbsp;&nbsp;&nbsp;定</a>
                    </p>
                </div>
                <div id="binvest-step3" style="display:none;">
                    <div class="step">
                        <p class="tc step3"><i></i></p>
                        <p class="p-invest">
                            <span>确认投资</span>
                            <span class="span02">确认支付</span>
                            <span>投资完成</span>
                        </p>
                    </div>
                    <ul>
                        <li>
                            <p class="confirm-invest">
                            尊敬的<span>{{ Auth::check() ? auth()->user()->name : '' }}</span>，恭喜您投资成功，预期收益为<span class="money binvest-earnings"></span>元
                            </p>
                        </li>
                        <li class="clearfix">
                            <label>投资项目：</label>
                            <a href="javascript:;" target="_blank" class="binvest-deal-title"></a>
                        </li>
                        <li class="clearfix">
                            <label>投资金额：</label><span class="money binvest-money"></span>元
                        </li>
                        <li class="clearfix">
                            <label>预期收益：</label><span class="money binvest-earnings"></span>元
                        </li>
                        <li class="clearfix">
                            <label>账户余额：</label><span class="money binvest-balance"></span>元
                        </li>
                    </ul>
                    <p class=" clearfix self-closing">投资完成，<span class="seconds">5</span>秒后对话框自动关闭……</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="pos-invest" class="" style="display:none;">
    <div id="pinvest-form" style="width:550px;">
        {!! Form::open(['url'=>'invest/posinvest','class'=>'form-horizontal','id'=>'pos-invest-form','target'=>'posinvestiframe','enctype'=>'multipart/form-data']) !!}
        <input type="hidden" name="id" value="" class="deal-id">
        <div class="me-invest succ">
            <div class="form-box">
                <div id="pinvest-step1">
                    <div class="step">
                        <p class="tc step1"><i></i></p>
                        <p class="p-invest">
                            <span>确认支付</span>
                            <span class="span02">确认投资</span>
                            <span>投资完成</span>
                        </p>
                    </div>
                    <ul>
                        <li class="clearfix">
                            <label>投资项目：</label>
                            <a href="javascript:;" target="_blank" class="pinvest-deal-title"></a>,预期年化收益: <span class="pinvest-deal-rate"></span>%
                        </li>
                        <li class="clearfix">
                            <label>投资金额：</label>
                            <input type="text" name="money" class="pinvest-money-input" value="" maxlength="11">
                            <span class="error money-input-error"></span>
                            <span class="yuan">元 （*若低于POS单金额,其他资金将作为余额存入账户）</span>
                        </li>
                        <li class="clearfix">
                            <label>预期收益：</label>
                            <input type="text" class="pinvest-expect-input" value="" disabled>
                            <span class="yuan">元</span>
                        </li>
                        <li class="clearfix">
                            <label>POS单号：</label>
                            <input type="text" name="posno" class="pinvest-posno-input" value="">
                            <span class="error posno-input-error"></span>
                        </li>
                        <li class="clearfix">
                            <label>POS单照片：</label>
                            <input type="file" name="pospic" class="pinvest-pospic-input" value="">
                            <span class="error pospic-input-error"></span>
                        </li>
                        <li class="clearfix">
                            <label>支付密码：</label>
                            <input type="password" name="paypass" class="pass-input">
                            <span class="error pass-input-error"></span>
                            <a href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'find']) }}" target="_blank" class="forget-password">忘记支付密码？</a>
                        </li>
                    </ul>
                    <p class="read clearfix">
                        <input type="checkbox" name="agree" class="agree-check">已阅读并同意
                        <a target="_blank" href="javascript:;">《保理服务协议》</a>
                        <a target="_blank" href="javascript:;">《债权转让协议》</a>
                    </p>
                    <p class="error agree-error" style="display:none;">请同意上述协议</p>
                    <p class=" clearfix p-btn">
                        <a href="javascript:;" class="a-btn pay-btn next-step02">下一步</a>
                    </p>
                </div>
                <div id="pinvest-step2" style="display:none;">
                    <div class="step">
                        <p class="tc step2"><i></i></p>
                        <p class="p-invest">
                            <span>确认支付</span>
                            <span class="span02">确认投资</span>
                            <span>投资完成</span>
                        </p>
                    </div>
                    <ul>
                        <li>
                            <p class="confirm-invest">
                            尊敬的<span>{{ Auth::check() ? auth()->user()->name : '' }}</span>，您是否确定要进行以下投资？
                            </p>
                        </li>
                        <li class="clearfix">
                            <label>投资项目：</label>
                            <a href="javascript:;" target="_blank" class="pinvest-deal-title"></a>
                        </li>
                        <li class="clearfix">
                            <label>投资金额：</label><span class="money pinvest-money"></span>元
                        </li>
                        <li class="clearfix">
                            <label>预期收益：</label><span class="money pinvest-earnings"></span>元
                        </li>
                        <li class="clearfix">
                            <label>说明：</label>使用POS单进行充值投资,需要1-2天审核时间,若POS单内金额不全部投资,则剩余部分作为余额返还给账户.
                        </li>
                    </ul>
                    <p class=" clearfix p-btn">
                        <a href="javascript:;" class="a-btn invest-btn pinvest-submit">确&nbsp;&nbsp;&nbsp;定</a>
                    </p>
                </div>
                <div id="pinvest-step3" style="display:none;">
                    <div class="step">
                        <p class="tc step3"><i></i></p>
                        <p class="p-invest">
                            <span>确认投资</span>
                            <span class="span02">确认支付</span>
                            <span>投资完成</span>
                        </p>
                    </div>
                    <ul>
                        <li>
                            <p class="confirm-invest">
                            尊敬的<span>{{ Auth::check() ? auth()->user()->name : '' }}</span>，恭喜您投资申请成功，请等待后台审核。
                            </p>
                        </li>
                        <li class="clearfix">
                            <label>投资项目：</label>
                            <a href="javascript:;" target="_blank" class="pinvest-deal-title"></a>
                        </li>
                        <li class="clearfix">
                            <label>投资金额：</label><span class="money pinvest-money"></span>元
                        </li>
                    </ul>
                    <p class=" clearfix self-closing">投资申请完成，<span class="seconds">5</span>秒后对话框自动关闭……</p>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <iframe name='posinvestiframe' style='display: none;'>
        <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/1.9.1/jquery.min.js"></script>
    </iframe>
</div>

<div id="paychoose-alert" class="layer">
    <p>您的账户可用资金：<span class="money balance-money"></span>元</p>
    <p>您此次投资金额：<span class="money invest-money"></span>元</p>
    <p>选择投资方式：</p>
    <p>
        <a href="javascript:;" class="balance-invest" style="background: #009dde none repeat scroll 0 0;border-radius: 5px;color: #fff;display: inline-block;float: none;font-size: 18px;height: 40px;line-height: 40px;margin: 0 auto;text-align: center;width: 150px;" onClick="javascript:payChooseAlert.close();balanceInvestModal.open();">资金余额</a>
        <a href="javascript:;" class="pos-invest" onClick="javascript:payChooseAlert.close();posInvestModal.open();" style="background: #ff8213  none repeat scroll 0 0;border-radius: 5px;color: #fff;display: inline-block;float: none;font-size: 18px;height: 40px;line-height: 40px;margin: 0 auto;text-align: center;width: 150px;">线下POS单</a>
    </p>
    <p style="color:#a0a0a0;font-size:12px;margin-top:15px;">若您有我公司线下POS机刷卡凭条,可选线下POS单投资,审核时间1天</p>
</div>

<div id="balance-less-alert" class="layer">
    <p>您的账户可用资金：<span class="money balance-money"></span>元，不足此次投资额：<span class="money invest-money"></span>元</p>
    <p>选择投资方式：</p>
    <p>
        <a href="javascript:;" class="pos-invest" onClick="javascript:balanceLessAlert.close();posInvestModal.open();" style="background: #ff8213  none repeat scroll 0 0;border-radius: 5px;color: #fff;display: inline-block;float: none;font-size: 18px;height: 40px;line-height: 40px;margin: 0 auto;text-align: center;width: 150px;">线下POS单</a>
    </p>
    <p style="color:#a0a0a0;font-size:12px;margin-top:15px;">若您有我公司线下POS机刷卡凭条,可选线下POS单投资,审核时间1天</p>
</div>

<div id="not-signin-alert" class="layer">
    <p>您还没有登录或登录超时，(⊙_⊙?)</p>
    <p>请您<a href="{{ url('/member/auth/login') }}" style="color:#009dde;">登录</a>，如果还没有账号，可以<a href="{{ url('/member/auth/register') }}" style="color:#009dde;">免费注册</a></p>    
</div>

<div id="network-error-alert" class="layer">
    <p>提交投资未成功!</p>
    <p>网络错误,请稍后重试，(⊙_⊙?)</p>
</div>

<div id="paypass-error-alert" class="layer">
    <p>支付密码错误,请重新输入.</p>
    <p><a href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'find']) }}">忘记密码</a></p>    
</div>
<div id="nopaypass-error-alert" class="layer">
    <p>未设置支付密码</p>
    <p><a href="{{ route('member.account.resetpay.{ctl}',['ctl'=>'new']) }}">设置支付密码</a></p>
</div>
<div id="deal-error-alert" class="layer">
    <p>无此项目或者此项目已过期失效.</p>
</div>
<div id="pospic-error-alert" class="layer">
    <p>POS单格式错误,必须是JPEG、JPG、PNG，大小不大于500KB</p>
</div>
@section('js')
    @parent    
    <script type="text/javascript" src="{{ asset('js/jBox.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){
            var width = $('.invest-box').outerWidth()*2 + ( +$('.invest-box').css('marginLeft').replace('px','') )*2;
            $(".big-show-inner").width(width);

            $(".invest-box .invest-unfold").on("click",function(){
                var $otherBigShow = $(this).closest(".invest-box").siblings().find(".big-show");
                var $bigShow = $(this).closest(".invest-box").find(".big-show");

                $otherBigShow.animate({width:0},800);
                $bigShow.animate({width:width},800);
                $bigShow.find(".money-input").focus();
            });
            $(".invest-box .close01").on("click",function(){
                var $bigShow = $(this).closest(".invest-box").find(".big-show");
                $bigShow.animate({width:0},800);
            });

            // var deals = {
            //     @foreach($deals as $jsk=>$jsd)
            //     {{ $jsd->getKey() }}:{daily:{{ $jsd->daily_returns}},days:{{ $jsd->repay_time}} }@if($jsk!=count($deals)) , @endif
            //     @endforeach
            // };
            // $(".money-input").on('keyup',function(){
            //     var id = $(this).data('id');
            //     var date = deals[id].days;
            //     var daily = deals[id].daily;
            //     var tz = $(this).val();
            //     var $sy = $("#h_ys"+id);
            //     var sy = '';
            //     if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) ){
            //         sy = ( tz / 10000 * daily ) * date;
            //         $sy.text(sy.toFixed(3));
            //     }else{
            //         $sy.text(0);
            //         return;
            //     }
            // });
        });

        var balanceInvestModal,posInvestModal,balanceLessAlert,notSignAlert,payChooseAlert,networkErrorAlert,paypassErrorAlert,dealErrorAlert,noPaypassAlert,pospicErrorAlert;
        var dealTitle,dealMoney,dealEarning,balanceMoney,dealMin,dealRate,dealID;
        var formSign,submitSuccess = false;
        $(function(){
            var deals = {
                @foreach($deals as $jsk=>$jsd)
                {{ $jsd->getKey() }}:{daily:{{ $jsd->daily_returns}},days:{{ $jsd->repay_time}} }@if($jsk!=count($deals)) , @endif
                @endforeach
            };
            $(".money-input").on('keyup',function(){
                var id = $(this).data('id');
                var date = deals[id].days;
                var daily = deals[id].daily;
                var tz = $(this).val();
                var $sy = $("#h_ys"+id);
                var sy = '';
                if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) ){
                    sy = ( tz / 10000 * daily ) * date;
                    $sy.text(sy.toFixed(3));
                }else{
                    $sy.text(0);
                    $("#h_jx_notice"+id).html('请输入正确数字');
                    return;
                }
            });
            $('.money-input,#balance-invest .binvest-money-input,.pass-input,#pos-invest .pinvest-money-input,#pos-invest .pinvest-posno-input').on('focus',function(){
                var id = $(this).data('id');
                $("#h_jx_notice"+id).html('');
                $(".money-input-error").html('');
                $(".pass-input-error").html('')
                $(".posno-input-error").html('')
                $(".pospic-input-error").html('')
            });

            $("#balance-invest .binvest-money-input").on('keyup',function(){
                var tz = $(this).val();
                var $sy = $("#balance-invest .binvest-expect-input");
                var sy = '';
                if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) && parseFloat(tz) >= parseFloat(dealMin) && parseFloat(tz) <= parseFloat(balanceMoney) ){
                    dealMoney = tz;
                    sy = buildEarnin(dealID,dealMoney);
                    $sy.val(sy);
                }else{
                    $sy.val(0);
                    $("#balance-invest .money-input-error").html('请输入正确资金,并且不小于'+dealMin+'元,不大于余额'+balanceMoney+'元');
                    formSign = false;
                    return;
                }
            });

            $("#balance-invest .binvest-money-input").on('blur',function(){
                var tz = $(this).val();
                var $sy = $("#balance-invest .binvest-expect-input");
                // var sy = '';
                if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) && parseFloat(tz) >= parseFloat(dealMin) && parseFloat(tz) <= parseFloat(balanceMoney) ){
                    // dealMoney = tz;
                    // sy = buildEarnin(dealID,dealMoney);
                    // $sy.val(sy);
                    return;
                }else{
                    $sy.val(0);
                    $("#balance-invest .money-input-error").html('请输入正确资金,并且不小于'+dealMin+'元,不大于余额'+balanceMoney+'元');
                    formSign = false;
                    return;
                }
            });

            function buildEarnin(id,money){
                var date = deals[id].days;
                var daily = deals[id].daily;
                var earning = ( money / 10000 * daily ) * date;
                return  earning.toFixed(3);
            }

            balanceInvestModal = new jBox('Modal',{
                title : '我要理财',
                content: $("#balance-invest"),
                animation : 'pulse',
                height:500,
                overlay : true,
                closeOnEsc : false,
                closeOnClick : false,
                closeButton: 'title',
                onOpen:function(){
                    $("#balance-invest .binvest-deal-title").html(dealTitle);
                    $("#balance-invest .binvest-deal-rate").html(dealRate);
                    $("#balance-invest .binvest-money-input").val(dealMoney);
                    $("#balance-invest .binvest-expect-input").val(buildEarnin(dealID,dealMoney));
                    $("#balance-invest .binvest-money").html(dealMoney);
                    $("#balance-invest .binvest-earnings").html(buildEarnin(dealID,dealMoney));
                    $("#balance-invest .binvest-balance").html(balanceMoney);
                    // submitSuccess = false;
                },
                onClose:function(){
                    formSign = false;
                    $("#balance-invest #binvest-step3,#balance-invest #binvest-step2").hide();
                    $("#balance-invest #binvest-step1").show();
                    $("#balance-invest .binvest-submit").removeClass('disabled');
                }
            });

            $("#balance-invest .next-step02").on('click',function(){
                var tz = $("#balance-invest .binvest-money-input").val();
                var $sy = $("#balance-invest .binvest-expect-input");
                formSign = true;
                if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) && parseFloat(tz) >= parseFloat(dealMin) && parseFloat(tz) <= parseFloat(balanceMoney) ){
                    dealMoney = tz;
                    dealEarning = buildEarnin(dealID,dealMoney);
                }else{
                    $sy.val(0);
                    $("#balance-invest .money-input-error").html('请输入正确资金,并且不小于'+dealMin+'元,不大于余额'+balanceMoney+'元');
                    formSign = false;
                }
                if( $.trim($("#balance-invest .pass-input").val()) == '' ){
                    $("#balance-invest .pass-input-error").html('请输入支付密码');
                    formSign = false;
                }

                if( $("#balance-invest .agree-check").prop('checked') == false ){
                    $("#balance-invest .agree-error").show();
                    formSign = false;
                }
                if( formSign ){
                    $("#balance-invest #binvest-step1").hide();
                    $("#balance-invest .binvest-money").html(dealMoney);
                    $("#balance-invest .binvest-earnings").html(dealEarning);                
                    $("#balance-invest #binvest-step2").show();
                }
            });

            $("#balance-invest .binvest-submit").on('click',function(){
                if( formSign && ! $(this).hasClass("disabled") ){
                    $(this).addClass('disabled');
                    $.ajax({
                        url:"{{ url('invest/doinvest') }}",
                        type:'post',
                        dataType:'json',
                        data:{_token:'{{ csrf_token()}}',money:dealMoney,paypass:$("#balance-invest .pass-input").val(),id:dealID},
                        success:function(data){
                            if( data.code == 1 ){
                                $("#balance-invest #binvest-step2").hide();
                                $("#balance-invest #binvest-step3").show();
                                setTimeout("balanceInvestModal.close()",5000);
                            }else if( data.code == 2 ){
                                balanceLessAlert.open();
                                balanceInvestModal.close();
                            }else if( data.code == 3 ){
                                paypassErrorAlert.open();
                                $("#balance-invest #binvest-step2").hide();
                                $("#balance-invest #binvest-step1").show();
                            }else if( data.code == 4 ){
                                balanceInvestModal.close();
                                dealErrorAlert.open();
                            }else if( data.code == 5 ){
                                balanceInvestModal.close();
                                noPaypassAlert.open();
                            }else if( data.code == 6 ){
                                balanceInvestModal.close();
                                notSignAlert.open();
                            }
                        },
                        error:function(){
                            balanceInvestModal.close();
                            networkErrorAlert.open();
                            return;
                        }
                    });
                }
            });

            $("#balance-invest .agree-check").click(function(){
                if($(this).prop('checked')){
                    $("#balance-invest .agree-error").hide();
                }
            });

            posInvestModal = new jBox('Modal',{
                title : '我要理财',
                content: $("#pos-invest"),
                animation : 'pulse',
                height:500,
                overlay : true,
                closeOnEsc : false,
                closeOnClick : false,
                closeButton: 'title',
                onOpen:function(){
                    $("#pos-invest .deal-id").val(dealID);
                    $("#pos-invest .pinvest-deal-title").html(dealTitle);
                    $("#pos-invest .pinvest-deal-rate").html(dealRate);
                    $("#pos-invest .pinvest-money-input").val(dealMoney);
                    $("#pos-invest .pinvest-expect-input").val(buildEarnin(dealID,dealMoney));
                    $("#pos-invest .pinvest-money").html(dealMoney);
                    $("#pos-invest .pinvest-earnings").html(buildEarnin(dealID,dealMoney));
                    $("#pos-invest .pinvest-balance").html(balanceMoney);
                    // submitSuccess = false;
                },
                onClose:function(){
                    formSign = false;
                    $("#pos-invest #pinvest-step3,#pos-invest #pinvest-step2").hide();
                    $("#pos-invest #pinvest-step1").show();
                    $("#pos-invest .pinvest-submit").removeClass('disabled');
                }
            });
            
            $("#pos-invest .pinvest-money-input").on('keyup',function(){
                var tz = $(this).val();
                var $sy = $("#pos-invest .pinvest-expect-input");
                var sy = '';
                if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) && parseFloat(tz) >= parseFloat(dealMin) ){
                    dealMoney = tz;
                    sy = buildEarnin(dealID,dealMoney);
                    $sy.val(sy);
                }else{
                    $sy.val(0);
                    $("#pos-invest .money-input-error").html('请输入正确资金,并且不小于'+dealMin+'元');
                    formSign = false;
                    return;
                }
            });

            $("#pos-invest .pinvest-money-input").on('blur',function(){
                var tz = $(this).val();
                var $sy = $("#pos-invest .pinvest-expect-input");
                // var sy = '';
                if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) && parseFloat(tz) >= parseFloat(dealMin) ){
                    // dealMoney = tz;
                    // sy = buildEarnin(dealID,dealMoney);
                    // $sy.val(sy);
                    return;
                }else{
                    $sy.val(0);
                    $("#pos-invest .money-input-error").html('请输入正确资金,并且不小于'+dealMin+'元');
                    formSign = false;
                    return;
                }
            });

            $("#pos-invest .next-step02").on('click',function(){
                var tz = $("#pos-invest .pinvest-money-input").val();
                var $sy = $("#pos-invest .pinvest-expect-input");
                formSign = true;
                if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) && parseFloat(tz) >= parseFloat(dealMin) ){
                    dealMoney = tz;
                    dealEarning = buildEarnin(dealID,dealMoney);
                }else{
                    $sy.val(0);
                    $("#pos-invest .money-input-error").html('请输入正确资金,并且不小于'+dealMin+'元');
                    formSign = false;
                }
                if( $.trim($("#pos-invest .pass-input").val()) == '' ){
                    $("#pos-invest .pass-input-error").html('请输入支付密码');
                    formSign = false;
                }

                if( $("#pos-invest .agree-check").prop('checked') == false ){
                    $("#pos-invest .agree-error").show();
                    formSign = false;
                }

                if( $.trim($("#pos-invest .pinvest-posno-input").val()) == '' ){
                    $("#pos-invest .posno-input-error").html('请输入POS单号');
                    formSign = false;
                }

                if( $.trim($("#pos-invest .pinvest-pospic-input").val()) == '' ){
                    $("#pos-invest .pospic-input-error").html('请选择POS单照片');
                    formSign = false;
                }

                var file = $("#pos-invest .pinvest-pospic-input")[0].files[0];
                var size = file.size / 1024;
                var filetype = file.type;
                console.log(filetype);
                if( size > 500 ){
                    $("#pos-invest .pospic-input-error").html('图片不能大于500K');
                    formSign = false;
                }

                if( filetype != 'image/jpeg' && filetype != 'image/png' && filetype != 'image/jpg' ){
                    $("#pos-invest .pospic-input-error").html('图片格式不正确, 只能jpeg,jpg,png');
                    formSign = false;
                }

                if( formSign ){
                    $("#pos-invest #pinvest-step1").hide();
                    $("#pos-invest .pinvest-money").html(dealMoney);
                    $("#pos-invest .pinvest-earnings").html(dealEarning);                
                    $("#pos-invest #pinvest-step2").show();
                }
            });
            $("#pos-invest .pinvest-submit").on('click',function(){
                $("#pos-invest-form").submit();
            });
            // $("#pos-invest .pinvest-submit").on('click',function(){
            //     if( formSign && ! $(this).hasClass("disabled") ){
            //         $(this).addClass('disabled');
            //         $.ajax({
            //             url:"{{ url('invest/posinvest') }}",
            //             type:'post',
            //             dataType:'json',
            //             data:{_token:'{{ csrf_token()}}',money:dealMoney,paypass:$("#pos-invest .pass-input").val(),id:dealID,posno:$("#pos-invest .pinvest-posno-input").val(),pospic:$("#pos-invest .pinvest-pospic-input")[0].files[0]},
            //             enctype: 'multipart/form-data',
            //             // contentType: false,
            //             success:function(data){
            //                 if( data.code == 1 ){
            //                     $("#pos-invest #pinvest-step2").hide();
            //                     $("#pos-invest #pinvest-step3").show();
            //                     setTimeout("balanceInvestModal.close()",5000);
            //                 }else if( data.code == 2 ){
            //                     balanceLessAlert.open();
            //                     balanceInvestModal.close();
            //                 }else if( data.code == 3 ){
            //                     paypassErrorAlert.open();
            //                     $("#pos-invest #pinvest-step2").hide();
            //                     $("#pos-invest #pinvest-step1").show();
            //                 }else if( data.code == 4 ){
            //                     balanceInvestModal.close();
            //                     dealErrorAlert.open();
            //                 }else if( data.code == 5 ){
            //                     balanceInvestModal.close();
            //                     noPaypassAlert.open();
            //                 }else if( data.code == 6 ){
            //                     balanceInvestModal.close();
            //                     notSignAlert.open();
            //                 }
            //             },
            //             error:function(){
            //                 balanceInvestModal.close();
            //                 networkErrorAlert.open();
            //                 return;
            //             }
            //         });
            //     }
            // });

            $(".agree-check").click(function(){
                if($(this).prop('checked')){
                    $(".agree-error").hide();
                }
            });

            balanceLessAlert = new jBox('Modal',{
                title : '账户余额不足',
                content: $("#balance-less-alert"),
                animation : 'pulse',
                width:500,
                overlay : true,
                closeButton: 'title',
                onOpen:function(){
                    $("#balance-less-alert .balance-money").html(balanceMoney);
                    $("#balance-less-alert .invest-money").html(dealMoney);
                }
            });

            notSignAlert = new jBox('Modal',{
                title : '没有登录',
                content: $("#not-signin-alert"),
                animation : 'pulse',
                width:500,
                overlay : true,
                closeButton: 'title'
            });

            pospicErrorAlert = new jBox('Modal',{
                title : 'POS单格式错误',
                content: $("#pospic-error-alert"),
                animation : 'pulse',
                width:500,
                overlay : true,
                closeButton: 'title'
            });
            networkErrorAlert = new jBox('Modal',{
                title : '网络错误',
                content: $("#network-error-alert"),
                animation : 'pulse',
                width:500,
                overlay : true,
                closeButton: 'title'
            });

            paypassErrorAlert = new jBox('Modal',{
                title : '支付密码错误',
                content: $("#paypass-error-alert"),
                animation : 'pulse',
                width:500,
                overlay : true,
                closeButton: 'title'
            });
            noPaypassAlert = new jBox('Modal',{
                title : '未设置支付密码',
                content: $("#nopaypass-error-alert"),
                animation : 'pulse',
                width:500,
                overlay : true,
                closeButton: 'title'
            });
            dealErrorAlert = new jBox('Modal',{
                title : '无此项目',
                content: $("#deal-error-alert"),
                animation : 'pulse',
                width:500,
                overlay : true,
                closeButton: 'title'
            });

            payChooseAlert = new jBox('Modal',{
                title : '支付方式选择',
                content: $("#paychoose-alert"),
                animation : 'pulse',
                width:500,
                overlay : true,
                closeButton: 'title',
                onOpen:function(){
                    $("#paychoose-alert .balance-money").html(balanceMoney);
                    $("#paychoose-alert .invest-money").html(dealMoney);
                }
            });

            $(".invest-layer").on('click',function(){
                var id = $(this).data('id');
                dealID = id;
                dealTitle = $(this).data('name');
                dealMoney = $("#h_enter_value"+id).val();
                dealEarning = $('#h_ys'+id).text();
                dealMin = $(this).data('startmoney');
                dealRate = $(this).data('borrowinterestrate');
                if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(dealMoney)  && parseFloat(dealMoney) >= parseFloat(dealMin)){
                    $.ajax({
                        url: '{{ url('invest/checkmoney') }}',
                        type:'get',
                        dateType:'json',
                        success:function(data){
                            if( data.code == 1 ){
                                // 余额不足
                                balanceMoney = data.balance;
                                balanceLessAlert.open();
                            }else if(data.code == 2 ){
                                // 未登录
                                notSignAlert.open();
                            }else if(data.code == 3 ){
                                balanceMoney = data.balance;
                                if( parseFloat(dealMoney) > parseFloat(balanceMoney) ){
                                    balanceLessAlert.open();
                                }else{
                                    payChooseAlert.open();
                                }                            
                            }
                        }
                    });
                }else{
                    $("#h_jx_notice"+id).html('请输入投资金额,不小于'+dealMin+'元');
                }
            });
        });
    </script>
@stop