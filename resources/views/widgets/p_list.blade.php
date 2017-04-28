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
<div class="treetop">
    <div id="pl-home-projectlist" class="box">
        <ul class="fly-somplifred">
            @foreach( $deals as $deal )
            <li class="past">
                <div class="treetop-left">
                    <h2>
                    <span class="span-sty span-sty-sp"><i class="sty-icon"><img src="/images/sty01.png" alt=""></i>{{ $deal->title }}</span><a class="a-title" href="javascript:;">{{ $deal->intro_info }}</a>
                    </h2>
                    <div class="project-info">
                        <div class="m-tp clearfix">
                            <div class="describe describe1">
                            <span>{{ $deal->rate }}<i>%</i></span>
                            <br />
                            预期年化收益率
                            </div>
                            <div class="describe describe2">
                                <span>{{ $deal->repay_time }}<i>天</i></span>
                                <br />
                                投资周期
                            </div>
                            <div class="divstyle divstyle03 supportcss3">
                                <p class="p-progress-bar clearfix">
                                    <span class="out-progress-bar clearfix">
                                        <span class="in-progress-bar" id="pj{{ $deal->getKey()}}-progress" style="width:{{ $deal->load_money > $deal->borrow_amount ? 100 : number_format($deal->load_money / $deal->borrow_amount * 100,2) }}%" ></span>
                                    </span>
                                </p>
                                <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;" id="pj{{ $deal->getKey() }}">
                                @if( $deal->load_money < $deal->borrow_amount)
                                已投： <span class="pj-has">{{ $deal->load_money > $deal->borrow_amount ? floor($deal->borrow_amount / 10000 ) : floor($deal->load_money / 10000 ) }}</span> 万元  /  总额：{{ floor( $deal->borrow_amount / 10000 ) }} 万元
                                @else
                                该项目已经完成投资，期待下期
                                @endif
                                </p>
                            </div>
                        </div>
                        <div class="tp-pattern">
                            起投金额：<span>{{ $deal->min_loan_money }}</span>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：{{ \App\Deal::getLoanTypeTitle($deal->loan_type) }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ $deal->exp_link }}" target="_blank" style="background: #ff8213 none repeat scroll 0 0;border: 1px solid #f7f7f7;border-radius: 5px;color: #fff;display: block;font-size: 14px;height: 27px;line-height: 27px;text-align: center;transition: all 0.8s ease 0s;width: 140px;display:inline-block;">查看说明</a>
                        </div>
                    </div>
                </div>
                <div class="treetop-right-outer">
                    <div class="treetop-right-inner">
                        <div class="treetop-right">
                            <div style="height: 16px;">&nbsp;</div>
                            <div class="tab-wrap">
                                <div class="tab-switch">
                                    <p class="p-in clearfix">
                                        <label>输入金额：</label>
                                        <input maxlength="11" id="h_enter_value{{ $deal->getKey() }}" class="money-input h_enter_value" type="text" data-id="{{ $deal->getKey() }}"><span class="text">元</span>
                                        <span class="error h_jx_notice" id="h_jx_notice{{ $deal->getKey() }}"></span>
                                    </p>
                                    <p class="p-in clearfix">
                                        <label>预期收益：</label>
                                        <span class="span-wid h_ys" id="h_ys{{ $deal->getKey() }}"></span>
                                        <span class="text">元</span>
                                    </p>
                                    <p class="invest-btnx p-btn clearfix">
                                        <a href="javascript:;" class="h_jx_payment a-btnop invest-layer" style="width:218px;" data-name="{{ $deal->title }}" data-tzqx="{{ floor( $deal->repay_time / 30 ) }}" data-borrowinterestrate="{{ $deal->rate }}" data-startmoney="{{ $deal->min_loan_money }}" data-borrowmin="0" data-borrowmax="" data-model="ewealth" data-need="" data-ishetong="1" data-pass="0" data-id="{{ $deal->getKey() }}" id="h_jx_payment{{ $deal->getKey() }}">我要投资</a>
                                    </p> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
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
<div id="dealload-error-alert" class="layer">
    <p>投资金额超过本项目最后可投金额，请重新填写金额. (@﹏@)~  </p>
</div>
@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/jBox.min.js') }}"></script>
    <script type="text/javascript">
    var balanceInvestModal,posInvestModal,balanceLessAlert,notSignAlert,payChooseAlert,networkErrorAlert,paypassErrorAlert,dealErrorAlert,noPaypassAlert,pospicErrorAlert,dealloadErrorAlert;
    var dealTitle,dealMoney,dealEarning,balanceMoney,dealMin,dealRate,dealID;
    var formSign,submitSuccess = false;
    var deals = {
            @foreach($deals as $jsk=>$jsd)
            {{ $jsd->getKey() }}:{daily:{{ $jsd->daily_returns}},days:{{ $jsd->repay_time}},min:{{ $jsd->min_loan_money }},total:{{ $jsd->borrow_amount }},load:{{ $jsd->load_money > $jsd->borrow_amount ? $jsd->borrow_amount : $jsd->load_money }}}@if($jsk!=count($deals)) , @endif
            @endforeach
        };
    $(function(){        
        $(".money-input").on('keyup',function(){
            var id = $(this).data('id');
            var min = deals[id].min;
            var total = deals[id].total;
            var load = deals[id].load;
            var date = deals[id].days;
            var daily = deals[id].daily;
            var tz = $(this).val();
            var $sy = $("#h_ys"+id);
            var sy = '';
            if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) ){
                if( tz >= ( total - load ) ){
                    tz = total - load;
                    $(this).val(tz);
                }
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
            $(this).select();
        });

        $("#balance-invest .binvest-money-input").on('keyup',function(){
            var tz = $(this).val();
            var $sy = $("#balance-invest .binvest-expect-input");
            var sy = '';
            var min = deals[dealID].min;
            var total = deals[dealID].total;
            var load = deals[dealID].load;
            if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) && parseFloat(tz) >= parseFloat(dealMin) && parseFloat(tz) <= parseFloat(balanceMoney) ){
                if( tz >= ( total - load ) ){
                    tz = total - load;
                    $(this).val(tz);
                }
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

        function buildLoadMoney(id){
            var load = deals[id].load;
            var total = deals[id].total;
            if( load >= total ){
                $("#pj"+id).text("该项目已经完成投资，期待下期");
            }
            $("#pj"+id).find('.pj-has').text(Math.ceil(load/10000));
            var w = load / total * 100;
            $("#pj"+id+"-progress").css({width:w.toFixed(2)+"%"});
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
                        }else if( data.code == 7 ){
                            balanceInvestModal.close();
                            dealloadErrorAlert.open();
                            deals[dealID].load = parseFloat(data.can);
                            buildLoadMoney(dealID);
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
            var min = deals[dealID].min;
            var total = deals[dealID].total;
            var load = deals[dealID].load;
            if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) && parseFloat(tz) >= parseFloat(dealMin) ){
                if( tz >= ( total - load ) ){
                    tz = total - load;
                    $(this).val(tz);
                }
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

        dealloadErrorAlert = new jBox('Modal',{
            title : '超出项目可投',
            content: $("#dealload-error-alert"),
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