@extends('_layouts.about')
@section('css')
<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main.css" />
<style type="text/css">
.about-box{background: none;}
.about-box .contact-map{background: url(/images/about_dt.gif) no-repeat right top;height:620px;width:100%;}
.about-box .contact-map .address-list{background: #fff;overflow-x: hidden;height:570px;width:550px;float:left;padding:25px 35px;}
.about-box .contact-map .address-list ul{width:100%;overflow: hidden;}
.about-box .contact-map .address-list ul li{width:90%;margin-bottom:25px;height:50px;text-align: left;border-bottom:1px solid #898989;cursor: pointer;}
.about-box .contact-map .address-list ul li p{height:22px;line-height: 25px;width:100%;overflow: hidden;color:#A5A5A5;}
.about-box .contact-map .address-list ul li p.area{color:#D00914;font-weight: 600;}
.about-box .map-wrap{margin-top:20px;width:100%;overflow: hidden;}
.about-box .map-wrap #cmap{width:100%;text-align: center;height:500px;}
.about-box .map-wrap #cmap img{border:none;width:100%;}
</style>
@stop
@section('content')
<div class="about-box clearfix">
    <div class="clearfix">
        <div class="contact-map clearfix">
            <div class="address-list">
                <ul class="clearfix">
                    <li class="" data-lng="116.493446" data-lat="39.938612">
                        <p class="area">总部</p>
                        <p>国兴观湖  朝阳区  东四环北路88号</p>
                    </li>
                    <li class="" data-lng="120.269748" data-lat="32.019893">
                        <p class="area">靖江</p>
                        <p>靖江市人民北路  41号</p>
                    </li>
                    <li class="" data-lng="117.190283" data-lat="34.257879">
                        <p class="area">徐州</p>
                        <p>云龙区  建国东路415号户部商都  14楼</p>
                    </li>
                    <li class="" data-lng="120.038086" data-lat="32.168736">
                        <p class="area">泰兴</p>
                        <p>泰兴中兴大道  195-7</p>
                    </li>
                    <li class="" data-lng="119.95738" data-lat="31.778919">
                        <p class="area">常州</p>
                        <p>延陵西路128号  四层1-10</p>
                    </li>
                </ul>
            </div>
        </div>
        {{-- <div class="map-wrap">
            <div id="cmap">
                
            </div>
        </div> --}}
    </div>
</div>
@stop
@section('js')
{{-- <script src="http://webapi.amap.com/maps?v=1.3&key=62602e254c75cf7fc1b7dad61b10f23f"></script> --}}
<script type="text/javascript">
    $(document).ready(function(){
        // $(".address-list li").on('click',function(){
        //     var d = $(this).data('area');
        //     var src = $("#cmap img").attr('src');
        //     var reg = new RegExp(d+'.jpg');
        //     if( reg.test(src)){
        //         return false;
        //     }
        //     $("#cmap img").attr('src','/images/maps/'+d+'.jpg');
        // });
        // var map = new AMap.Map("cmap", {
        //   resizeEnable: true,
        //   center: [116.493446,39.938612],
        //   zoom: 17
        // });

        // var marker = new AMap.Marker({
        //     icon: new AMap.Icon({
        //         size:new AMap.Size(24,36),
        //         image:"{{ asset('images/map-marker-icon.png') }}",
        //     }),
        //     position:[116.493446,39.938612]
        // });
        // marker.setMap(map);
        // $(".address-list li").on('click',function(){
        //     var lng = $(this).data('lng');
        //     var lat = $(this).data('lat')
        //     map.setZoomAndCenter(17,[lng,lat]);
        //     marker.setPosition([lng,lat]);
        //     map.setFitView();
        //     $("html,body").animate({scrollTop:$("#cmap").offset().top},1000);
        // });
    });
</script>
@stop