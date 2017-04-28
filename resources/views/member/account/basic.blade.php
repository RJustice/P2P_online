@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">基础信息</a>
    </div>
</div>
<div class="tab-box clearfix  basic-info">
    <div style="display:block" class="m-form basic-information bf1" id="basic-table">
        <ul>
            <li class="clearfix">
                <label>用户名</label>
                <span class=" wrap-span">同手机号码</span> <span class="modfiy"><a class="modify" href="javascript:void(0);">修改信息</a></span>
            </li>
            <li class="clearfix">
                <label>手机号码</label>
                <span class=" wrap-span">{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}{{-- <a id="modify-pho" class="blue-color" href="javascript:;">修改</a></span> </li> --}}
            <li class="clearfix">
                <label>真实姓名</label>
                <span class=" wrap-span"><span class=" wrap-span">{{ App\User::hiddenXin(auth()->user()->name) }}</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </li>
            <li class="clearfix">
                <label>身份证号</label>
                <span class=" wrap-span"><span class=" wrap-span">{{ preg_replace('/([0-9]{4})[0-9]{10}([0-9]{4})/i','$1*******$2',auth()->user()->idno) }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </li>
            <li class="clearfix">
                <label>性别</label>
                <span class=" wrap-span">{{ App\User::getSex(auth()->user()->sex) }}</span> </li>
            <li class="clearfix">
                <label>年龄</label>
                <span class=" wrap-span">{{ App\User::getAge(auth()->user()) }}</span>
            </li>
            <li class="clearfix">
                <label>邮箱</label>
                <span class=" wrap-span">{{ auth()->user()->email }}</span>
            </li>
            <li class="clearfix">
                <label>居住地址</label>
                <span class=" wrap-span">{{ auth()->user()->formatRegion() }}--{{ auth()->user()->address }}</span> </li>
            {{-- <li class="clearfix">
                <label>最高学历</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>月收入</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>职业</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>紧急联系人</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>联系人手机</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>与紧急联系人关系</label>
                <span class=" wrap-span"></span>
            </li> --}}
        </ul>
    </div>
    <div style="display:none" class="m-form  basic-information bf2" id="basic-form">
        {!! Form::open(['method'=>'post','route'=>'member.account.basic','id'=>'basic-edit-form']) !!}
        <ul>
            <li class="clearfix">
                <label>用户名</label>
                <span class=" wrap-span">{{ auth()->user()->phone }} (无法修改)</span> <span class="modfiy"><a class="modify" href="javascript:void(0);">取消修改</a></span>
            </li>
            <li class="clearfix">
                <label>手机号码</label>
                <span class=" wrap-span">{{ preg_replace('/([0-9]{3})[0-9]{4}([0-9]{4})/i','$1****$2',auth()->user()->phone) }}{{-- <a id="modify-pho" class="blue-color" href="javascript:;">修改</a></span> </li> --}}
            <li class="clearfix">
                <label>真实姓名</label>
                <span class=" wrap-span"><span class=" wrap-span">{{ App\User::hiddenXin(auth()->user()->name) }}</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </li>
            <li class="clearfix">
                <label>身份证号</label>
                <span class=" wrap-span"><span class=" wrap-span">{{ preg_replace('/([0-9]{4})[0-9]{10}([0-9]{4})/i','$1*******$2',auth()->user()->idno) }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </li>
            <li class="clearfix">
                <label>性别</label>
                <span class=" wrap-span"><label for="sex"><input type="radio" name="sex" id="" value="1" {{ auth()->user()->sex == 1 ? 'checked' : '' }}>男</label><label for="sex"><input type="radio" name="sex" id="" value="0" {{ auth()->user()->sex == 0 ? 'checked' : '' }}>女</label></span> </li>
            <li class="clearfix">
                <label>年龄</label>
                <span class=" wrap-span">{{ App\User::getAge(auth()->user()) }}</span>
            </li>
            <li class="clearfix">
                <label>邮箱</label>
                <span class=" wrap-span"><input type="text" name="email" id="" value="{{ auth()->user()->email }}"></span>
            </li>
            <li class="clearfix">
                <label>居住地址</label>
                <span style="float:left;margin:0 10px;">省：</span>{!! Form::select('province_id',[]) !!}
                <span style="float:left;margin:0 10px;">市：</span>{!! Form::select('city_id',[]) !!}
                <span style="float:left;margin:0 10px;">区/县：</span>{!! Form::select('county_id',[]) !!}
            </li>
            <li class="clearfix">
                <label for="">&nbsp;</label><input type="text" name="address" id="" value="{{ auth()->user()->address }}">
            {{-- <li class="clearfix">
                <label>最高学历</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>月收入</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>职业</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>紧急联系人</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>联系人手机</label>
                <span class=" wrap-span"></span>
            </li>
            <li class="clearfix">
                <label>与紧急联系人关系</label>
                <span class=" wrap-span"></span>
            </li> --}}
            <li><a id="preserve" class="a-btn" href="javascript:;">保存</a></li>
        </ul>
        {!! Form::close() !!}
    </div>
</div>
@stop

@section('js')
    <script type="text/javascript">
    $(function(){

        $(".modify").on('click',function(){
            if( $('#basic-table').is(':hidden') ){
                $("#basic-form").hide();
                $("#basic-table").show();
            }else{
                $("#basic-form").show();
                $("#basic-table").hide();
            }
        });

        $("#preserve").click(function(){
            $("#basic-edit-form").submit();
        });
    });
    </script>
    <script type="text/javascript" src="/js/region.js"></script>
    <script type="text/javascript">
    
    var provinceSelected = {{ ! auth()->user()->province_id ? 16 : auth()->user()->province_id }};
    var citySelected = {{ ! auth()->user()->city_id ? 223 : auth()->user()->city_id }};
    var countySelected ={{ ! auth()->user()->county_id ? 1883 : auth()->user()->county_id }};
    var initProvinceData = regionConf.r1.c;
    var initCityData = initProvinceData['r'+provinceSelected].c;
    var initCountyData = initCityData['r'+citySelected].c;

    function initProvinceSelect(data){
        var  o = "<option value=\"0\">请选择</option>";
        var selected = '';
        for(var k in data){
            selected = '';
            if( data[k].i == provinceSelected ){
                selected = 'selected="selected"';
            }
            o += "<option value="+data[k].i+" "+selected+">"+data[k].n+"</option>";
        }
        return o;
    }

    function initCitySelect(data){
        var  o = "<option value=\"0\">请选择</option>";
        var selected = '';
        for(var k in data){
            selected = '';
            if( data[k].i == citySelected ){
                selected = 'selected="selected"';
            }
            o += "<option value="+data[k].i+" "+selected+">"+data[k].n+"</option>";
        }
        return o;
    }

    function initCountySelect(data){
        var  o = "<option value=\"0\">请选择</option>";
        var selected = '';
        for(var k in data){
            selected = '';
            if( data[k].i == countySelected ){
                selected = 'selected="selected"';
            }
            o += "<option value="+data[k].i+" "+selected+">"+data[k].n+"</option>";
        }
        return o;
    }


    $(function(){
        var provinceSelect = $("select[name=province_id]");
        var citySelect = $("select[name=city_id]");
        var countySelect = $("select[name=county_id]");
        var province,city,county;
        // console.log(provinceSelect);
        provinceSelect.html(initProvinceSelect(initProvinceData));
        citySelect.html(initCitySelect(initCityData));
        countySelect.html(initCountySelect(initCountyData));

        provinceSelect.on('change',function(){
            var v = $(this).val();
            if( v == 0 ){
                citySelect.html(initCitySelect({}));
                countySelect.html(initCountySelect({}));
            }else{
                var r = "r"+v;
                city = regionConf.r1.c[r].c;
                citySelect.html(initCitySelect(regionConf.r1.c[r].c));
                countySelect.html(initCountySelect({}));
            }
        });

        citySelect.on('change',function(){
            var v = $(this).val();
            if( v == 0 ){
                countySelect.html(initCountySelect({}));
            }else{
                var r = "r"+v;
                city = regionConf.r1.c['r'+provinceSelect.val()].c;
                countySelect.html(initCountySelect(city[r].c));
            }
        });
    });
    </script>
@stop