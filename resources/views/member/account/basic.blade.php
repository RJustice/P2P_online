@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">基础信息</a>
    </div>
</div>
<div class="tab-box clearfix  basic-info">
    <div style="display:block" class="m-form basic-information bf1">
        <ul>
            <li class="clearfix">
                <label>用户名</label>
                <span class=" wrap-span">同手机号码</span> <span class="modfiy">{{-- <a id="modify" href="javascript:void(0);">修改信息</a> --}}</span>
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
                <span class=" wrap-span">{{ App\User::getAge(auth()->user()->byear) }}岁</span>
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
    <div style="display:none" class="m-form  basic-information bf2">
        <ul>
            <li class="clearfix">
                <label>用户名</label>
                <span class=" wrap-span">RJustice</span> </li>
            <li class="clearfix">
                <label>手机号码</label>
                <span class=" wrap-span">137****1803<a id="modifypho" class="blue-color" href="javascript:;">修改</a></span> </li>
           <li class="clearfix">
                <label>真实姓名</label>
                <span class=" wrap-span">
                                                <span class=" wrap-span">*雯雯</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                           </span>
            </li>
            <li class="clearfix">
                <label>身份证号</label>
                <span class=" wrap-span">
                                                <span class=" wrap-span">37028********80045</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                            </span>
            </li>
            <li class="clearfix">
                <label>性别</label>
                <span class=" wrap-span">
                                                <label>
                        <input type="radio" value="男" placeholder="" name="sex"> 男
                    </label>
                    <label>
                        <input type="radio" value="女" placeholder="" name="sex"> 女
                    </label>                            </span>
                <span class="error sex"></span>
            </li>
            <li class="clearfix">
                <label>年龄</label>
                <input type="text" onkeyup="value=this.value.replace(/[^0-9]/g,'');value=this.value.substr(0,3);" value="0" placeholder="" id="age" name="age">
                <strong class="unit">岁</strong>
                <span class="error age"></span>
            </li>
            <li class="clearfix">
                <label>邮箱</label>
                <input type="text" value="" placeholder="" id="user_email" name="user_email">
                <span class="error user_email"></span>
            </li>
            <li class="clearfix">
                <label>当前居住城市</label>
                <div class="fl div-select">
                    <select id="province_now" name="province_now"><option value="0" selected="selected">请选择省份</option>
<option value="2">北京</option>
<option value="3">安徽</option>
<option value="4">福建</option>
<option value="5">甘肃</option>
<option value="6">广东</option>
<option value="7">广西</option>
<option value="8">贵州</option>
<option value="9">海南</option>
<option value="10">河北</option>
<option value="11">河南</option>
<option value="12">黑龙江</option>
<option value="13">湖北</option>
<option value="14">湖南</option>
<option value="15">吉林</option>
<option value="16">江苏</option>
<option value="17">江西</option>
<option value="18">辽宁</option>
<option value="19">内蒙古</option>
<option value="20">宁夏</option>
<option value="21">青海</option>
<option value="22">山东</option>
<option value="23">山西</option>
<option value="24">陕西</option>
<option value="25">上海</option>
<option value="26">四川</option>
<option value="27">天津</option>
<option value="28">西藏</option>
<option value="29">新疆</option>
<option value="30">云南</option>
<option value="31">浙江</option>
<option value="32">重庆</option>
<option value="33">香港</option>
<option value="34">澳门</option>
<option value="35">台湾</option></select>
                    <span class="span-instructions">（省/直辖市）</span> </div>
                <div class="fl div-select">
                    <select id="city_now" name="city_now"><option value="">--请先选择省份--</option></select>
                    <span class="span-instructions">（市）</span> </div>
                <div class="fl div-select">
                    <select id="area_now" name="area_now"><option value="">--请先选择省份--</option></select>
                    <span class="span-instructions">（区）</span> </div>
            </li>
            <li class="clearfix">
                <label>最高学历</label>
                <span class=" wrap-span">
                                                <label>
                        <input type="radio" valadate-tag="false" value="高中以下" placeholder="" name="education"> 高中以下
                    </label>
                    <label>
                        <input type="radio" value="大专或本科" placeholder="" name="education">大专或本科
                    </label>
                    <label>
                        <input type="radio" value="硕士或硕士以上" placeholder="" name="education">硕士或硕士以上
                    </label>                            </span>
                <span class="error education"></span>
            </li>
            <li class="clearfix">
                <label>月  收  入</label>
                <span class=" wrap-span">
                                                <label><input type="radio" value="5000以下" placeholder="" name="income">5000以下 </label>
                    <label><input type="radio" value="5000-10000" placeholder="" name="income">5000-10000 </label>
                    <label><input type="radio" value="10000-50000" placeholder="" name="income">10000-50000 </label>
                    <label><input type="radio" value="50000以上" placeholder="" name="income">50000以上</label>                            </span>
                <span class="error income"></span>
            </li>
            <li class="clearfix">
                <label>职业</label>
                <input type="text" value="" id="zy" placeholder="" name="zy">
                <span class="error zy"></span>
            </li>
            <li class="clearfix">
                <label>紧急联系人</label>
                <input type="text" value="" id="contact1" placeholder="" name="contact1">
                <span class="error contact1"></span>
            </li>
            <li class="clearfix">
                <label>联系人手机</label>
                <input type="text" value="" id="contact1_tel" placeholder="" name="contact1_tel">
                <span class="error telerror"></span>
            </li>
            <li class="clearfix">
                <label>与紧急联系人关系</label>
                <select id="contact1_re" name="contact1_re">
                    <option value="">请选择</option>
                                                <option value="配偶">配偶</option>
                    <option value="父亲">父亲</option>
                    <option value="母亲">母亲</option>
                    <option value="子女">子女</option>
                    <option value="朋友">朋友</option>
                    <option value="其他">其他</option>                            </select>
            </li>
            <li><a id="preserve" class="a-btn" href="javascript:;">保存</a></li>
        </ul>
    </div>
</div>
@stop

@section('js')
@stop