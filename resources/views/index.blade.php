@extends('_layouts.default')
@section('main_ad')
<div id="main-adv-box" class="main-adv-box f-l">
    <div id="main-adv-img" class="main-adv-img">
        <span rel="1"><img src="/images/b1.jpg" alt="" style="display:none"></span>
        <span rel="2"><img src="/images/b2.jpg" alt="" style="display:none"></span>
        <span rel="3"><img src="/images/b4.jpg" alt="" style="display:none"></span>
    </div>
    <div id="main-adv-ctl" class="main-adv-ctl">
        <ul>
            <li rel="1">1</li>
            <li rel="2">2</li>
            <li rel="3">3</li>
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
                            168,562,000
                        </div>
                    </div>
                </div>
                <div>
                    <div class="login-btn" style="display: inline-block;width: 113px;height: 42px;background: none repeat scroll 0% 0% #209DF8;line-height: 42px;color: #FFF;text-align: center;"><a href="{{ url('member/auth/login') }}" style="color:#fff;">用户登录</a></div>
                    <div class="reg-btn" style="display: inline-block;width: 113px;height: 42px;background: none repeat scroll 0% 0% #ff972c;line-height: 42px;color: #FFF;text-align: center;"><a href="{{ url('member/auto/register') }}" style="color:#fff;">免费注册</a></div>
                </div>
                <!--<div style="font-size:18px;line-height:48px;font-weight:600;text-align:center;">投资热线: 400-6090 290</div>-->
            </div>
        </div>
        <div class="proj clearfix">
            <div class="top-item tbtj-project clearfix">
                <div class="pic">
                    <a href="javascript:;"><img src="/images/nfb.png" alt=""></a>
                </div>
                <div class="info">
                    <h3><a href="javascript:;">农富宝180T</a></h3>
                    <ul>
                        <li>还款方式: 到期返本付息</li>
                        <li>起投资金: 5万元起投</li>
                        <li class="f-l">
                            项目期限: <span class="orange">180</span> 天
                        </li>
                        <li class="f-l">
                            项目特点:  6个月短期投入实现较高收益,获取较高预期年收益.
                            <!-- <div class="progress-bg">
                                <span class="progress-b" style="width:86%">&nbsp;</span>
                            </div>
                            <span class="orange">86%</span> -->
                        </li>
                        <li class="f-l">
                            预期年化收益率: <span style="font-size:50px;line-height:60px;color:#f88b2c">11%</span>
                        </li>
                    </ul>
                    <!-- <div class="f-l">
                        <a class="btn" href="javascript:;">立即购买</a>
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
                            <span class="span-sty span-sty-sp">农富宝45T</span><a class="a-title" href="javascript:;">45天短期投入实现较高收益,获取较高预期年收益</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>6<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>45<i>天</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:28.44%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;">可投： 3578 万元  /  总额：5000 万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>5万</span>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：到期返本付息&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                            <input maxlength="11" id="h_enter_value2" class="money-input h_enter_value" type="text" data-id="2" data-date="45" data-nsy="0.06"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice2"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys2"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="{{ url('/invest') }}" class="h_jx_payment a-btnop invest-btn" style="width:218px;">我要投资<i></i></a>
                                        </p>
                                        <!--<p style="height:30px;line-height:16px;overflow:hidden;font-size:12px;color:#f00;">* 计算所得为预计到期收益<br />具体请咨询400-6090 290</p>--> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty">农富宝90T  月回息</span><a class="a-title" href="javascript:;">3个月短期投入实现较高收益,每月回收利息,本金继续借出</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>9.5<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>3<i>月</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:48.4%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;">可投： 2580 万元  /  总额：5000 万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>5万</span>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：按月付息,到期返本&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                            <input maxlength="11" id="h_enter_value3" class="money-input h_enter_value" type="text" data-id="3" data-date="90" data-nsy="0.095"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice3"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys3"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="{{ url('/invest') }}" class="h_jx_payment a-btnop invest-btn" style="width:218px;">我要投资<i></i></a>
                                        </p>
                                        <!--<p style="height:30px;line-height:16px;overflow:hidden;font-size:12px;color:#f00;">* 计算所得为预计到期收益<br />具体请咨询400-6090 290</p>--> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty span-sty-sp">农富宝90T</span><a class="a-title" href="javascript:;">3个月短期投入实现较高收益,获取较高预期年收益</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>10<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>3<i>月</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:26%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;">可投： 3700 万元  /  总额：5000 万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>5万</span>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：到期返本付息&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                            <input maxlength="11" id="h_enter_value4" class="money-input h_enter_value" type="text" data-id="4" data-date="90" data-nsy="0.1"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice4"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys4"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="{{ url('/invest') }}" class="h_jx_payment a-btnop invest-btn" style="width:218px;">我要投资<i></i></a>
                                        </p>
                                        <!--<p style="height:30px;line-height:16px;overflow:hidden;font-size:12px;color:#f00;">* 计算所得为预计到期收益<br />具体请咨询400-6090 290</p>--> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty">农富宝180T 月回息</span><a class="a-title" href="javascript:;">6个月短期投入实现较高收益,每月回收利息,本金继续借出</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>10.5<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>6<i>月</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:42.8%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;">可投： 2860 万元  /  总额：5000 万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>5万</span>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：按月付息，到期返本&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                            <input maxlength="11" id="h_enter_value5" class="money-input h_enter_value" type="text" data-id="5" data-date="180" data-nsy="0.105"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice5"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys5"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="{{ url('/invest') }}" class="h_jx_payment a-btnop invest-btn" style="width:218px;">我要投资<i></i></a>
                                        </p>
                                        <!--<p style="height:30px;line-height:16px;overflow:hidden;font-size:12px;color:#f00;">* 计算所得为预计到期收益<br />具体请咨询400-6090 290</p>--> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty">农富宝365T 月回息</span><a class="a-title" href="javascript:;">通过循环出借方式,每月回收利息,本金继续借出</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>12.5<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>1<i>年</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:44.67%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;">可投： 1660 万元  /  总额：3000 万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>5万</span>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：按月付息，到期返本&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                            <input maxlength="11" id="h_enter_value7" class="money-input h_enter_value" type="text" data-id="7" data-date="365" data-nsy="0.125"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice7"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys7"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="{{ url('/invest') }}" class="h_jx_payment a-btnop invest-btn" style="width:218px;">我要投资<i></i></a>
                                        </p>
                                        <!--<p style="height:30px;line-height:16px;overflow:hidden;font-size:12px;color:#f00;">* 计算所得为预计到期收益<br />具体请咨询400-6090 290</p>--> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty span-sty-sp">农富宝365T</span><a class="a-title" href="javascript:;">通过循环出借方式,获取较高预期年收益</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>13<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>1<i>年</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:36.67%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;">可投： 1900 万元  /  总额：3000 万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>5万</span>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：到期返本付息&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                            <input maxlength="11" id="h_enter_value8" class="money-input h_enter_value" type="text" data-id="8" data-date="365" data-nsy="0.13"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice8"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys8"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="{{ url('/invest') }}" class="h_jx_payment a-btnop invest-btn" style="width:218px;">我要投资<i></i></a>
                                        </p>
                                        <!--<p style="height:30px;line-height:16px;overflow:hidden;font-size:12px;color:#f00;">* 计算所得为预计到期收益<br />具体请咨询400-6090 290</p>-->                              
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty">农富宝365T(50万起) 月回息</span><a class="a-title" href="javascript:;">通过循环出借方式,每月回收利息,本金继续借出</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>14.4<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>1<i>年</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:38%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;">可投： 4960 万元  /  总额：8000 万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>50万<spanm>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：按月付息，到期返本&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                            <input maxlength="11" id="h_enter_value1" class="money-input h_enter_value" type="text" data-id="1" data-date="365" data-nsy="0.144"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice1"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys1"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="{{ url('/invest') }}" class="h_jx_payment a-btnop invest-btn" style="width:218px;">我要投资<i></i></a>
                                        </p>
                                        <!--<p style="height:30px;line-height:16px;overflow:hidden;font-size:12px;color:#f00;">* 计算所得为预计到期收益<br />具体请咨询400-6090 290</p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>                
                <li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty span-sty-sp">农富宝365T(50万起）</span><a class="a-title" href="javascript:;">通过循环出借方式,获取较高预期年收益</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>15<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>1<i>年</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:14.5%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;line-height:40px;color:#999;font-size:16px;">可投： 6840 万元  /  总额：8000 万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>50万<spanm>元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;反息方式：到期返本付息&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
                                            <input maxlength="11" id="h_enter_value10" class="money-input h_enter_value" type="text" data-id="10" data-date="365" data-nsy="0.15"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice1"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys10"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="{{ url('/invest') }}" class="h_jx_payment a-btnop invest-btn" style="width:218px;">我要投资<i></i></a>
                                        </p>
                                        <!--<p style="height:30px;line-height:16px;overflow:hidden;font-size:12px;color:#f00;">* 计算所得为预计到期收益<br />具体请咨询400-6090 290</p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!--<li class="past">
                    <div class="treetop-left">
                        <h2>
                            <span class="span-sty">众诚财富</span><a class="a-title" href="javascript:;">融资租赁债权转让项目第504期B</a>
                        </h2>
                        <div class="project-info">
                            <div class="m-tp clearfix">
                                <div class="describe describe1">
                                <span>13<i>%</i></span>
                                <br />
                                预期年化收益率
                                </div>
                                <div class="describe describe2">
                                    <span>30<i>天</i></span>
                                    <br />
                                    投资周期
                                </div>
                                <div class="divstyle divstyle03 supportcss3">
                                    <p class="p-progress-bar clearfix">
                                        <span class="out-progress-bar clearfix">
                                            <span class="in-progress-bar" style="width:29.41%"></span>
                                        </span>
                                    </p>
                                    <p style="width:300px;overflow:hidden;height:40px;line-height:20px;">可投：1764.8万元  /  总额：2500万元</p>
                                </div>
                            </div>
                            <div class="tp-pattern">
                                起投金额：<span>1</espan元&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;付息方式：按月&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;赎回方式：T+10， 投资满30天即可申请赎回，赎回期内同等计息
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
                                            <input maxlength="11" id="h_enter_value1707" class="money-input h_enter_value" type="text"><span class="text">元</span>
                                            <span class="error h_jx_notice" id="h_jx_notice1707"></span>
                                        </p>
                                        <p class="p-in clearfix">
                                            <label>预期收益：</label>
                                            <span class="span-wid h_ys" id="h_ys1707"></span>
                                            <span class="text">元</span>
                                        </p>
                                        <p class="invest-btn p-btn clearfix">
                                            <a href="javascript:;" class="h_jx_payment a-btnop invest-btn" style="width:218px;">计算到期收益<i></i></a>
                                        </p>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>-->
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
                <li><a target="_blank" href="#">互联网金融迎大考  农发众诚成创新样本<img src="/images/new.png"><i></i></a><span>09/05</span></li>
                <li><a target="_blank" href="#">农发众诚：顺应总体思路，宏观要稳，微观要活<img src="/images/new.png"><i></i></a><span>09/05</span></li>
                <li><a target="_blank" href="#">互联网金融必须加速    农发众诚不断进取<img src="/images/new.png"><i></i></a><span>09/05</span></li>
                <li><a target="_blank" href="#">监管加速行业规范    催生合格投资者<img src="/images/new.png"><i></i></a><span>09/03</span></li>
            </ul>
            <ul style="display: none;" class="new-cntent">
                <li><a target="_blank" href="#">第二届816互联网金融峰会“破局·破茧·破冰...<img src="/images/new.png"><i></i></a><span>09/05</span></li>
                <li><a target="_blank" href="#">大数据顶层设计打造经济新引擎<img src="/images/new.png"><i></i></a><span>09/05</span></li>
                <li><a target="_blank" href="#">上市银行晒“中考”成绩单 不良贷上升成资产质...<img src="/images/new.png"><i></i></a><span>09/05</span></li>
                <li><a target="_blank" href="#">商务部：7月全国进出口2.12万亿元 同比下...<img src="/images/new.png"><i></i></a><span>09/05</span></li>
            </ul>
        </div>
    </div>
</div>
@stop


@section('js')
<script type="text/javascript" src="/js/main_adv.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".new-title li:not(.news-more)").click(function() {
            var e = $(this).index();
            $(".new-title li").removeClass("selected"), $(this).addClass("selected"), $(".iarrow").hide(), $(this).children(".iarrow").show(), $(".news-more").hide(), $(e == 0 ? "#news_company" : "#news_industry").show(), $(".new-cntent").hide(), $(".new-cntent").eq(e).show()
        });

        $(".money-input").on('keyup',function(){
            var id = $(this).data('id');
            var date = parseInt($(this).data('date'));
            var nsy = parseFloat($(this).data('nsy'));
            var tz = $(this).val();
            var $sy = $("#h_ys"+id);
            var sy = '';
            if( /^([1-9]\d*|0)(\.\d*[1-9])?$/.test(tz) ){
                // tz = parseFloat(tz);
                sy = ( tz * nsy ) * ( date / 365 );
                $sy.text(sy.toFixed(3));
            }else{
                $sy.text(0);
                return;
            }
        });
    });
</script>
@stop