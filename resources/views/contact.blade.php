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
                <span id="aboutus"><a href="javascript:;">联系我们</a></span>
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
                #contact{}
                #contact .company{margin:18px 0;width:100%;}
                #contact .company ul{width:100%;overflow: hidden;}
                #contact .company ul li{width:45%;margin-bottom:5px;height:48px;text-align: left;border-bottom:1px solid #898989;cursor: pointer;}
                #contact .company ul li p{height:20px;line-height: 24px;width:100%;overflow: hidden;color:#A5A5A5;}
                #contact .company ul li p.area{color:#D00914;font-weight: 600;}
                #contact .company-map{margin-top:20px;width:100%;height:320px;}
                #contact .company-map #cmap{width:100%;height:320px;text-align: center;}
                #contact .company-mao #cmap img{border:none;width:100%;height:320px;}
                </style>
                <div class="con-main">
                    <h2>联系我们</h2>
                    <div id="contact">
                        <div class="company">
                            <ul class="clearfix">
                                <li class="f-l" data-area="bj">
                                    <p class="area">总部</p>
                                    <p>国兴观湖  朝阳区  东四环北路88号甲六号楼2层201</p>
                                </li>
                                <li class="f-r" data-area="jj">
                                    <p class="area">靖江</p>
                                    <p>台州市  靖江市人民北路  41号</p>
                                </li>
                                <li class="f-l" data-area="xz">
                                    <p class="area">徐州</p>
                                    <p>云龙区  建国东路415号户部商都  14楼</p>
                                </li>
                                <li class="f-r" data-area="tx">
                                    <p class="area">泰兴</p>
                                    <p>泰兴中兴大道  195-7</p>
                                </li>
                                <li class="f-l" data-area="jj">
                                    <p class="area">泰州</p>
                                    <p>泰州市  靖江市人民北路41号  五楼</p>
                                </li>
                                <li class="f-r" data-area="cz">
                                    <p class="area">常州</p>
                                    <p>延陵西路128号  四层1-10</p>
                                </li>
                            </ul>
                        </div>
                        <div class="company-map">
                            <div id="cmap">
                                <img src="/images/cz.jpg" alt="">
                            </div>
                        </div>
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