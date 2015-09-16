@extends('_layouts.default')
@section('css')

@stop
@section('content')
<div class="about-box clearfix">
    <div class="beadcrumb-nav">
        <div class="wrap clearfix">
            <h2>
                <a href="{{ url('/') }}">首页</a>
                <img src="/images/arrow03.png" alt="">
                <span id="aboutus"><a href="javascript:;">管理团队</a></span>
            </h2>
        </div>
    </div>
    <div class="wrap clearfix com-bg">
        <div class="left-box">
        <ul>
            @foreach ( $pages as $p )
                <li class="@if($p->id == $id) select @endif"><a id="page-{{ $p->id }}" href="{{ empty($p->out_link) ? action('PagesController@show',[$p->id]) : $p->out_link }}">{{ $p->title }}</a><i></i></li>
            @endforeach
            </ul>
        </div>
        <div class="right-box clearfix">
            <div id="content" class="con clearfix">
                <style type="text/css">
                #gltd{}
                #gltd dl{float:left;margin-bottom: 20px;overflow: hidden;padding:10px;}
                #gltd dl:hover{background: #f5f5f5;}
                #gltd dl dt{background: #fff;border:1px solid #d1dfea;box-shadow: 0 0 4px #c0c0c0;display: block;float: left;height: 150px;margin-right: 20px;padding:2px;}
                #gltd dl dt img{height:150px;border:none;}
                #gltd dl dd{float:left;height: 140px;overflow: hidden;width:500px;word-wrap:break-word;}
                #gltd dl dd p.tit{font-size:20px;line-height: 30px;margin-bottom: 10px;color:#ff6c00;border-bottom:1px solid #ddd;}
                #gltd dl dd p.content{line-height: 20px;}
                </style>
                <div class="con-main">
                    <h2>管理团队</h2>
                    <div id="gltd">
                        <dl>
                            <dt><img width="120" height="150" src="/images/gltd/cg.jpg"></dt>
                            <dd>
                                <p class="tit">程刚&nbsp;&nbsp;华东一区区域总监</p>
                                <p class="clearfix">
                                    <span class="fl"></span>
                                    <span class="fr"></span>
                                </p>
                                <p class="connent" class="h150">曾在交通银行任职，1996年加入保险公司，从一线业务做起到总监，每月超额完成销售业绩，全年多次获得销售佳绩，多次获得公司颁发的奖项及奖金。拥有丰富的金融行业从业经验，尤其是在销售领域曾创造了夺目的销售业绩。曾在保险公司担任三级机构负责人。2014年进入三方理财，对团队筹建有非常丰富的经验，有团队合作精神。</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt><img width="120" height="150" src="/images/gltd/lyh.jpg"></dt>
                            <dd>
                                <p class="tit">陆银浩&nbsp;&nbsp;靖江分公司总经理</p>
                                <p class="clearfix">
                                    <span class="fl"></span>
                                    <span class="fr"></span>
                                </p>
                                <p class="connent" class="h150">毕业于中央广播电视大学，财会管理专业，曾就职于中国人民人寿保险股份有限公司，担任银保负责人。2014年加入第三方理财公司工作，对产品销售，团队管理建设有一定的工作经验。</p>
                            </dd>
                        </dl>
                        <dl>
                            <dt><img width="120" height="150" src="/images/gltd/lt.jpg"></dt>
                            <dd>
                                <p class="tit">卢腾&nbsp;&nbsp;徐州分公司总经理</p>
                                <p class="clearfix">
                                    <span class="fl"></span>
                                    <span class="fr"></span>
                                </p>
                                <p class="connent" class="h150">毕业于东北师范大学，投资理财专业。曾先后就职于国内某大型金融保险集团、某创新型寿险公司，从事营销培训及营销管理工作；多次参与金融类企业分支机构的组建工作；2014年加入某知名同业公司，担任培训部主管、城市经理；对新时期家庭财务规划及理财策略拥有独到见解，拥有数百场理财讲座经验。</p>
                            </dd>
                        </dl>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $("#contact li").on('click',function(){
            var d = $(this).data('area');
            var src = $("#cmap img").attr('src');
            var reg = new RegExp(d+'.jpg');
            if( reg.test(src)){
                return false;
            }
            $("#cmap img").attr('src','/images/'+d+'.jpg');
        });
    });
</script>
@stop