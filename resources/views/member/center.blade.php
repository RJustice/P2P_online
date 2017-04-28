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
                        <i class="i02 @if(auth()->user()->phonepassed) i02s @endif" status="1" title="手机认证"><a href="javascript:;" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                        <i class="i03 @if(auth()->user()->idcardpassed) i03s @endif" status="0" title="实名认证"><a href="{{ route('member.account.authenticate') }}" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                        <i class="i04 @if(auth()->user()->paypassword) i04s @endif" status="0" title="支付密码"><a href="{{ route('member.account.safe') }}" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                        <i class="i05 @if(auth()->user()->bank) i05s @endif" status="0" title="银行卡绑定"><a href="{{ route('member.account.bankcard') }}" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                        <i class="i06 @if(auth()->user()) i06s @endif" status="0" title="个人信息"><a href="{{ route('member.account.basic') }}" style="display:inline-block; width:100%; height:100%; pointer:curso"></a></i>
                    </span>
                </p>
            </div>
        </div>
        <div class="pwinr">
            <div class="pre-paid">
                <p class="p-btn">
                    {{-- <a href="" class="a-btn01">充值</a> --}}
                    <a href="{{ route('member.fund.carry') }}" class="a-btn02">提现</a>
                    <a href="{{ route('member.fund.redeem') }}" class="a-btn03">赎回</a>
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
                <p class="acount-num">{{ number_format(auth()->user()->can_money,2) }}</p>
                <span style="display: none;" class="bubble">
                            <label class="text">账户内投资人可自由支配的资金</label>
                            <label class="arrow"></label>
                        </span>
            </li>
            {{-- <li>
                <p class="income-name">冻结资金<em>（元）</em><i></i></p>
                <p class="acount-num">{{ number_format(auth()->user()->lock_money,2) }}</p>
                <span style="display: none;" class="bubble">
                            <label class="text">待收本金+提现中冻结金额</label>
                            <label class="arrow"></label>
                        </span>
            </li> --}}
            <li>
                <p class="income-name">待收收益<em>（元）</em><i></i></p>
                <p class="acount-num">{{ number_format(auth()->user()->waiting_returns,2) }}</p>
                <span style="display: none;" class="bubble">
                            <label class="text">所有理财产品截止昨天的未到期收益</label>
                            <label class="arrow"></label>
                        </span>
            </li>
            <li>
                <p class="income-name">累计收益<em>（元）</em><i></i></p>
                <p class="acount-num">{{ number_format($data['leiji'],2) }}</p>
                <span style="display: none;" class="bubble">
                            <label class="text">所有理财产品截止当日0点的已获收益</label>
                            <label class="arrow"></label>
                        </span>
            </li>
        </ul>
    </div>
    <div class="pre-data clearfix">
        <div id="chart" class="chart"></div>
        <div class="data-show">
            <ul>
                <li>已投金额（元）<i></i>：<em style="font-size:12px;">{{ number_format($data['ready']) }}</em><span style="display:none;" class="bubble"><label class="text">投资人在农发众诚所有的投资金额</label><label class="arrow"></label></span></li>
                <li>已获收益（元）<i></i>：<em style="font-size:12px;">{{ number_format($data['yihuo']) }}</em><span style="display:none;" class="bubble"><label class="text">投资人在农发众诚所有的已获收益</label><label class="arrow"></label></span></li>
                <li>待收本金（元）<i></i>：<em style="font-size:12px;">{{ number_format($data['benjin']) }}</em><span style="display:none;" class="bubble"><label class="text">投资人在农发众诚所有的待收本金</label><label class="arrow"></label></span></li>
                <li>冻结资金（元）<i></i>：<em style="font-size:12px;">{{ number_format(auth()->user()->lock_money) }}</em><span style="display:none;" class="bubble"><label class="text">投资人在农发众诚所有的冻结资金</label><label class="arrow"></label></span></li>
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
                        <p class="p-name clearfix"><span>农发众诚</span><a href="javscript:;">180T 月回息 </a> </p>
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
                            <div class="divstyle divstyle03"> <a href="{{ url('/invest') }}" class="a-btn">立即投资<i></i></a> </div>
                        </div>
                    </li>
        </ul>
    </div>
</div>
@stop

@section('js')
<script src="http://code.highcharts.com/highcharts.js"></script>
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


        $("#chart").highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '投资与收益'
            },
            xAxis: {
                categories: [
                    '1月',
                    '2月',
                    '3月',
                    '4月',
                    '5月',
                    '6月',
                    '7月',
                    '8月',
                    '9月',
                    '10月',
                    '11月',
                    '12月',
                ]
            },
            yAxis: [{
                min: 0,
                title: {
                    text: '投资(元)'
                }
            },{
                title: {
                    text: '收益(元)'
                },
                opposite: true
            }],
            plotOptions: {
                column: {
                    grouping: false,
                    shadow: false,
                    borderWidth: 0
                }
            },
            series: [{
                name: '投资',
                color: 'rgba(165,170,217,1)',
                data: [{{ implode(',',$data['touzi']) }}],
                pointPadding: 0.4,
                pointPlacement:-0.1
            },{
                name: '收益',
                color: 'rgba(248,161,63,1)',
                data: [{{ implode(',',$data['shouyi']) }}],
                pointPadding: 0.4,
                pointPlacement:0.1,
                yAxis: 1
            }],
            credits: {
                enabled: false
            }
        });
    });
</script>
@stop