@extends('_layouts.default')
@section('main_ad')
<div id="main-adv-box" class="main-adv-box f-l">
    <div id="main-adv-img" class="main-adv-img">
        <span rel="1"><img src="http://p2p.example.com/public/attachment/201410/10/16/54379e5b77e58.jpg" alt="" style="display:none"></span>
        <span rel="2"><img src="http://p2p.example.com/public/attachment/201410/10/16/54379eb932938.jpg" alt="" style="display:none"></span>
    </div>
    <div id="main-adv-ctl" class="main-adv-ctl">
        <ul>
            <li rel="1">1</li>
            <li rel="2">2</li>
        </ul>
    </div>
</div>
<p class="touy"></p>
@stop
@section('content')
<div class="wrap">
    <div class="feature">
        <a class="fea1">
            <i></i>
            <h3>信用审查</h3>
            <span>农发众诚引进国际最先进的德国IPC技术,通过科学的流程审查和风控流程,严格控制风险,保障出借人资金安全</span>
        </a>
        <a class="fea2">
            <i></i>
            <h3>风险分散</h3>
            <span>出借人与借款人签署个人间的借贷合同,出借人将资金分散,出借给多个借款对象,风险得到最大程度的分散</span>
        </a>
        <a class="fea3">
            <i></i>
            <h3>增强认知</h3>
            <span>农发众诚本着对客户负责的态度,从风险理论,如何催收等方面进行加强,有效降低用户资金风险,告知用户资金用途</span>
        </a>
    </div>
    <!-- <div class="total">
        <div class="tal1 t">
            <p>累计投资金额(元)</p>
            <div class="money"><span>11102<em>088</em></span>万</div>
        </div>
        <div class="tal2 t">
            <p>累计创造收益(元)</p>
            <div class="money">150<span><em>.65</em></span>万元</div>
        </div>
        <div class="tal3 t">
            <p>本息保证金(元)</p>
            <div class="money"><span><em></em></span></div>
        </div>
    </div> -->
    <div class="recom-num clearfix">
        <div class="num">
            <div class="num-c">
                <div class="num-content">
                    <div class="reg-num">
                        <div>已在农发众诚投资的用户</div>
                        <div class="rn">
                            4983
                        </div>
                    </div>
                    <div class="tnum">
                        <div>投资已在农发众诚完成</div>
                        <div class="tn">
                            468,562,120
                        </div>
                    </div>
                </div>
                <div>
                    <div class="login-btn" style="display: inline-block;width: 113px;height: 42px;background: none repeat scroll 0% 0% #209DF8;line-height: 42px;color: #FFF;text-align: center;">用户登录</div>
                    <div class="reg-btn" style="display: inline-block;width: 113px;height: 42px;background: none repeat scroll 0% 0% #ff972c;line-height: 42px;color: #FFF;text-align: center;">免费注册</div>
                </div>
            </div>
        </div>
        <div class="proj clearfix">
            <div class="top-item tbtj-project clearfix">
                <div class="pic">
                    <a href="{{ url('projects') }}"><img src="/images/nfb.png" alt=""></a>
                </div>
                <div class="info">
                    <h3><a href="{{ url('projects') }}">农富宝365T(50万起)</a></h3>
                    <ul>
                        <li>还款方式: 到期返本付息</li>
                        <li>起投资金: 50万元起投</li>
                        <li class="f-l">
                            项目期限: <span class="orange">1</span> 年
                        </li>
                        <li class="f-l">
                            项目特点:  通过循环出借方式,获取较高预期年收益.
                            <!-- <div class="progress-bg">
                                <span class="progress-b" style="width:86%">&nbsp;</span>
                            </div>
                            <span class="orange">86%</span> -->
                        </li>
                        <li class="f-l">
                            预期年化收益率: <span style="font-size:50px;line-height:60px;color:#f88b2c">15%</span>
                        </li>
                    </ul>
                    <!-- <div class="f-l">
                        <a class="btn" href="{{ url('projects') }}">立即购买</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="treetop">
        <div id="pl-home-projectlist" class="box">
            <ul class="fly-somplifred">
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty">众诚财富</span><a class="a-title" href="{{ url('projects') }}">融资租赁债权转让项目第504期B</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <em>13<i>%</i></em>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <em>30<i>天</i></em>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:29.41%"></span>
                                        </span>
                                    </p>
                                    <p>可投：1764.8万元  /  总额：2500万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<em>1</em>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;付息方式：按月&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;赎回方式：T+10， 投资满30天即可申请赎回，赎回期内同等计息
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
                                            <input maxlength="11" id="h_enter_value1707" data-id="1707" class="money-input h_enter_value" type="text"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice1707"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys1707">1300.00</span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="javascript:;" id="h_jx_payment1707" class="h_jx_payment a-btnop invest-btn" data-id="1707" data-pass="0" data-ishetong="1" data-model="newdetaildh" data-need="17647822.68" data-borrowmax="" data-borrowmin="0" data-startmoney="1.00" data-borrowinterestrate="13.00" data-tzqx="12" data-name="融资租赁债权转让项目第504期B">立即投资<i></i></a>
                                        </p>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty">众诚财富</span><a class="a-title" href="{{ url('projects') }}">融资租赁债权转让项目第504期B</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <em>13<i>%</i></em>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <em>30<i>天</i></em>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:29.41%"></span>
                                        </span>
                                    </p>
                                    <p>可投：1764.8万元  /  总额：2500万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<em>1</em>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;付息方式：按月&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;赎回方式：T+10， 投资满30天即可申请赎回，赎回期内同等计息
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
                                            <input maxlength="11" id="h_enter_value1707" data-id="1707" class="money-input h_enter_value" type="text"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice1707"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys1707">1300.00</span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="javascript:;" id="h_jx_payment1707" class="h_jx_payment a-btnop invest-btn" data-id="1707" data-pass="0" data-ishetong="1" data-model="newdetaildh" data-need="17647822.68" data-borrowmax="" data-borrowmin="0" data-startmoney="1.00" data-borrowinterestrate="13.00" data-tzqx="12" data-name="融资租赁债权转让项目第504期B">立即投资<i></i></a>
                                        </p>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty">众诚财富</span><a class="a-title" href="{{ url('projects') }}">融资租赁债权转让项目第504期B</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <em>13<i>%</i></em>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <em>30<i>天</i></em>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:29.41%"></span>
                                        </span>
                                    </p>
                                    <p>可投：1764.8万元  /  总额：2500万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<em>1</em>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;付息方式：按月&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;赎回方式：T+10， 投资满30天即可申请赎回，赎回期内同等计息
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
                                            <input maxlength="11" id="h_enter_value1707" data-id="1707" class="money-input h_enter_value" type="text"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice1707"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys1707">1300.00</span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="javascript:;" id="h_jx_payment1707" class="h_jx_payment a-btnop invest-btn" data-id="1707" data-pass="0" data-ishetong="1" data-model="newdetaildh" data-need="17647822.68" data-borrowmax="" data-borrowmin="0" data-startmoney="1.00" data-borrowinterestrate="13.00" data-tzqx="12" data-name="融资租赁债权转让项目第504期B">立即投资<i></i></a>
                                        </p>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="wrap">
        <div class="new-box">
            <ul class="new-title">
                <li class="selected">
                    公司新闻
                <i style="display: block;" class="iarrow"></i>
                </li>
                <li class="">
                    行业新闻
                <i style="display: none;" class="iarrow"></i>
                </li>
                <li id="news_company" class="news-more" style="display: list-item;"><a target="_blank" href="#">更多</a></li>
                <li style="display: none;" id="news_industry" class="news-more"><a target="_blank" href="#">更多</a></li>
            </ul>
            <ul class="new-cntent" style="display: block;">
                <li><a target="_blank" href="#">互联网金融迎大考  e租宝成创新样本<img src="/images/new.png"><i></i></a><span>08/21</span></li>
                <li><a target="_blank" href="#">e租宝：顺应总体思路，宏观要稳，微观要活<img src="/images/new.png"><i></i></a><span>08/21</span></li>
                <li><a target="_blank" href="#">互联网金融必须加速    e租宝不断进取<img src="/images/new.png"><i></i></a><span>08/21</span></li>
                <li><a target="_blank" href="#">监管加速行业规范    催生合格投资者<img src="/images/new.png"><i></i></a><span>08/20</span></li>
            </ul>
            <ul style="display: none;" class="new-cntent">
                <li><a target="_blank" href="#">第二届816互联网金融峰会“破局·破茧·破冰...<img src="/images/new.png"><i></i></a><span>08/21</span></li>
                <li><a target="_blank" href="#">大数据顶层设计打造经济新引擎<img src="/images/new.png"><i></i></a><span>08/21</span></li>
                <li><a target="_blank" href="#">上市银行晒“中考”成绩单 不良贷上升成资产质...<img src="/images/new.png"><i></i></a><span>08/21</span></li>
                <li><a target="_blank" href="#">商务部：7月全国进出口2.12万亿元 同比下...<img src="/images/new.png"><i></i></a><span>08/21</span></li>
            </ul>
        </div>
    </div>
</div>
@stop


@section('js')
<script type="text/javascript" src="/js/main_adv.js"></script>
<script type="text/javascript">
    $(".new-title li:not(.news-more)").click(function() {
        var e = $(this).index();
        $(".new-title li").removeClass("selected"), $(this).addClass("selected"), $(".iarrow").hide(), $(this).children(".iarrow").show(), $(".news-more").hide(), $(e == 0 ? "#news_company" : "#news_industry").show(), $(".new-cntent").hide(), $(".new-cntent").eq(e).show()
    })
</script>
@stop