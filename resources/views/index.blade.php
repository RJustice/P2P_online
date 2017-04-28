@extends('_layouts.default')
@section('main_ad')
<div id="main-adv-box" class="main-adv-box f-l">
    <div id="main-adv-img" class="main-adv-img">
        <span rel="1"><img src="/images/b1.jpg" alt="" style="display:none"></span>
        <span rel="2"><img src="/images/b6.jpg" alt="" style="display:none"></span>
        <span rel="3"><img src="/images/b3.jpg" alt="" style="display:none"></span>
        <span rel="4"><img src="/images/b4.jpg" alt="" style="display:none"></span>
    </div>
    <div id="main-adv-ctl" class="main-adv-ctl">
        <ul>
            <li rel="1">1</li>
            <li rel="2">2</li>
            <li rel="3">3</li>
            <li rel="4">4</li>
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
            <span>农发众诚引进国际最先进的德国IPC技术,通过科学的流程审查和风控流程,严格控制风险,保障出借人资金安全.</span>
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
    <div class="recom-num clearfix">
        <div class="num">
            <div class="num-c">
                <div class="num-content">
                    <div class="reg-num">
                        <div>已在农发众诚投资的用户</div>
                        <div class="rn" id="reg-count">
                            0000
                        </div>
                    </div>
                    <div class="tnum">
                        <div>投资已在农发众诚完成</div>
                        <div class="tn" id="pj-total">
                            000,000,000
                        </div>
                    </div>
                </div>
                <div>
                    <div class="login-btn" style="display: inline-block;width: 113px;height: 42px;background: none repeat scroll 0% 0% #209DF8;line-height: 42px;color: #FFF;text-align: center;"><a href="{{ url('member/auth/login') }}" style="color:#fff;display:block;">用户登录</a></div>
                    <div class="reg-btn" style="display: inline-block;width: 113px;height: 42px;background: none repeat scroll 0% 0% #ff972c;line-height: 42px;color: #FFF;text-align: center;"><a href="{{ url('member/auth/register') }}" style="color:#fff;display:block;">免费注册</a></div>
                </div>
                <!--<div style="font-size:18px;line-height:48px;font-weight:600;text-align:center;">投资热线: 400-6090 290</div>-->
            </div>
        </div>
        <div class="proj clearfix">
            <div class="top-item tbtj-project clearfix">
                <div class="pic">
                    <a href="javascript:;"><img src="/images/nfb.jpg" alt=""></a>
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
    @include('widgets.index_p')
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
                <li id="news_company" class="news-more" style="display: list-item;"><a target="_blank" href="{{ url('articles/c/2') }}">更多</a></li>
                <li style="display: none;" id="news_industry" class="news-more"><a target="_blank" href="{{ url('articles/c/3') }}">更多</a></li>
            </ul>
            <ul class="new-cntent" style="display: block;">
                @foreach($official_news as $onew)
                <li><a target="_blank" href="{{ url('articles',[$onew->id]) }}">{{ str_limit($onew->title,40,'...') }} &nbsp;&nbsp;<img src="/images/new.png"><i></i></a><span>{{ $onew->created_at->format('m/d') }}</span></li>
                @endforeach
            </ul>
            <ul style="display: none;" class="new-cntent">
                @foreach($industry_news as $inew)
                <li><a target="_blank" href="{{ url('articles',[$inew->id]) }}">{{ str_limit($inew->title,40,'...') }} &nbsp;&nbsp;<img src="/images/new.png"><i></i></a><span>{{ $inew->created_at->format('m/d') }}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@stop


@section('js')
<script type="text/javascript" src="/js/main_adv.js"></script>
<script type="text/javascript">
    function updateCount(){
        $.ajax({
            url : '{{ url('count') }}',
            data : {},
            dataType : 'json',
            type : 'get',
            success : function(data){
                var register = data.register;
                var projects = data.projects;
                var total = data.total.toString();
                $("#reg-count").text(register);
                $("#pj-total").text(total.replace(/(\d{1,3})(?=(?:\d{3})+(?!\d))/g,'$1,'));
                for( k in projects ){
                    if( projects[k].c == 'done' ){
                        $("#"+k).text("投资已满,敬请期待下一期!");
                        $("#"+k).css({color:'#5cb85c',fontSize:'18px'});
                    }else{
                        $("#"+k+" span.pj-has").text(projects[k].c);
                    }
                    console.log(typeof projects[k].c);
                    var p = projects[k].c / projects[k].t * 100;
                    $("#"+k+'-progress').animate({width:p.toFixed(2)+"%"});
                }
            }
        });
    }

    $(document).ready(function(){
        updateCount();
        setInterval(updateCount,600000);
        $(".new-title li:not(.news-more)").click(function() {
            var e = $(this).index();
            $(".new-title li").removeClass("selected"), $(this).addClass("selected"), $(".iarrow").hide(), $(this).children(".iarrow").show(), $(".news-more").hide(), $(e == 0 ? "#news_company" : "#news_industry").show(), $(".new-cntent").hide(), $(".new-cntent").eq(e).show()
        });        
    });
</script>
@stop