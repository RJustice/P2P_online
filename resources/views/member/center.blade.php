@extends('_layouts.center')
@section('css')
@stop

@section('content')
<div class="personal-panel">
    <div class="pre-data clearfix">
        <div class="pwinl">
            <div id="headupload" class="personal-head">
                <img src="/images/noavatar_big.gif" alt="">
            </div>
            <div class="personal-inf">
                <p class="inf-name">你好, {{ auth()->user()->name }}</p>
                <p class="inf-grade">
                    <span>                         
                        <i class="i02 i02s" status="1" title="手机认证"><a href="/user/account/safeinfo" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                        <i class="i03" status="0" title="实名认证"><a href="/user/account/realnameauth" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                        <i class="i04" status="0" title="支付密码"><a href="/user/account/safeinfo" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                        <i class="i05" status="0" title="银行卡绑定"><a href="/user/account/bankcardauth" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                        <i class="i06" status="0" title="个人信息"><a href="/user/account/basic" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                    </span>
                </p>
            </div>
        </div>
        <div class="pwinr">
            <div class="pre-paid">
                <p class="p-btn">
                    <a href="" class="a-btn01">充值</a>
                    <a href="" class="a-btn02">提现</a>
                    {{-- <a href="" class="a-btn03">赎回</a> --}}
                </p>
            </div>
        </div>
    </div>
    <div class="pre-money">
        <ul>
            <li>
                <p class="income-name">账户资产<em>（元）</em><i></i></p>
                <p class="acount-num">{{ number_format(auth()->user()->money,2) }}</p>
                <span style="display: none;" class="bubble">
                            <label class="text">账户余额 + 待收本金 + 提现中冻结金额</label>
                            <label class="arrow"></label>
                        </span>
            </li>
            <li>
                <p class="income-name">账户余额<em>（元）</em><i></i></p>
                <p class="acount-num">{{ number_format(auth()->user()->money,2) }}</p>
                <span style="display: none;" class="bubble">
                            <label class="text">账户余额 + 待收本金 + 提现中冻结金额</label>
                            <label class="arrow"></label>
                        </span>
            </li>
            <li>
                <p class="income-name">冻结资金<em>（元）</em><i></i></p>
                <p class="acount-num">{{ number_format(auth()->user()->money,2) }}</p>
                <span style="display: none;" class="bubble">
                            <label class="text">账户余额 + 待收本金 + 提现中冻结金额</label>
                            <label class="arrow"></label>
                        </span>
            </li>
            <li>
                <p class="income-name">待收收益<em>（元）</em><i></i></p>
                <p class="acount-num">{{ number_format(auth()->user()->money,2) }}</p>
                <span style="display: none;" class="bubble">
                            <label class="text">账户余额 + 待收本金 + 提现中冻结金额</label>
                            <label class="arrow"></label>
                        </span>
            </li>
        </ul>
    </div>
    <div class="pre-data clearfix">
        <div id="chart" class="chart"></div>
        <div class="data-show">
            <ul>
                <li>已投金额（元）<i></i>：<em style="font-size:12px;">0.00</em><span style="display:none;" class="bubble"><label class="text">投资人在农发众诚所有的投资金额</label><label class="arrow"></label></span></li>
                <li>已获收益（元）<i></i>：<em style="font-size:12px;">0.00</em><span style="display:none;" class="bubble"><label class="text">投资人在农发众诚所有的投资金额</label><label class="arrow"></label></span></li>
                <li>待收本金（元）<i></i>：<em style="font-size:12px;">0.00</em><span style="display:none;" class="bubble"><label class="text">投资人在农发众诚所有的投资金额</label><label class="arrow"></label></span></li>
                <li>冻结资金（元）<i></i>：<em style="font-size:12px;">0.00</em><span style="display:none;" class="bubble"><label class="text">投资人在农发众诚所有的投资金额</label><label class="arrow"></label></span></li>
            </ul>
        </div>
    </div>
    <div class="pre-banner">
        <img src="" alt="">
    </div>
    <div class="pre-deal-list">
        <p class="recommendation">
            <label>为您推荐</label>
            <span id="datashow">作为一名专业投资人，您的资产配置还可以更完善。</span>
        </p>
        <ul class="clearfix">
            <li>
                        <p class="p-name clearfix"><span>农发众诚</span><a href="/invest/2253.html">180T 月回息 </a> </p>
                        <div class="dllustration clearfix">
                            <div class="divstyle divstyle01"> <em>12.00<i>%</i></em><br>
                                <label>预期年化收益率</label>
                            </div>
                            <div class="divstyle divstyle02">
                                <p class="p-details clearfix">
                                    <span>到期时间：2016-09-26 </span>
                                    <span> 融资总额：2500万元</span>
                                </p>
                                <p class="p-details clearfix">
                                    <span>投资期限：40-365<i>天</i></span>
                                    <span>可融资额：724.2万元</span>
                                </p>
                                <p class="p-progress-bar clearfix"> 
                                    <span class="out-progress-bar clearfix"> 
                                        <span class="in-progress-bar" style="width:71.03%"> </span> 
                                    </span> 
                                </p>
                            </div>
                            <div class="divstyle divstyle03"> <a href="/invest/2253.html" class="a-btn">立即投资<i></i></a> </div>
                        </div>
                    </li>
        </ul>
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
    $(function(){
        $('.income-name i').hover(function(){
            $(this).parent().siblings('.bubble').show();
        },function(){
            $(this).parent().siblings('.bubble').hide();
        });

        $('.data-show i').hover(function(){
            $(this).siblings('.bubble').show();
        },function(){
            $(this).siblings('.bubble').hide();
        });
    });
</script>
@stop