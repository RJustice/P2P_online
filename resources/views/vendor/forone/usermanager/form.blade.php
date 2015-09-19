{!! Form::iform_text('phone','手机号码','请输入手机号码',1) !!}
{!! Form::iform_text('name','姓名','请输入真实姓名',1) !!}
{!! Form::iform_text('email','Email','请输入Email地址',1) !!}
@if( ! str_is('admin.users.edit', Route::current()->getName()) )
{!! Form::iform_password('password','密码','请输入密码',1) !!}
@endif
{!! Form::iform_radio('is_delete','禁用',[[0,'是'],[1,'否',true]],1) !!}
{!! Form::iform_text('idno','身份证号','请输入正确身份证号码',1) !!}
{!! Form::iform_radio('sex','性别',[[1,'男'],[0,'女']],1) !!}
{{-- @inject('region','App\Region') --}}
{!! Form::iform_select('province_id','省份',[],1/3) !!}
{!! Form::iform_select('city_id','市',[],1/3) !!}
{!! Form::iform_select('county_id','区域',[],1/3) !!}

{!! Form::iform_text('address','地址','请输入地址',1) !!}

{{-- @inject('userModel','App\User'); --}}
@if(Auth::user()->can(['admin']))
{!! Form::iform_select('sales_manager','指定销售经理',array_merge([['label'=>'请选择','value'=>0]],\App\User::getSalesManagers(true)),1) !!}
@endif
{{-- @if (str_is('admin.admins.create', Route::current()->getName())) --}}
    {{-- {!! Form::igroup_password('password','密码','请输入密码',1) !!} --}}
{{-- @endif --}}

@section('js')
    @parent
    <script type="text/javascript" src="/js/region.js"></script>
    <script type="text/javascript">
    @if (str_is('admin.users.edit', Route::current()->getName()))
        var provinceSelected = {{ ! $data->province_id ? 16 : $data->province_id }};
        var citySelected = {{ ! $data->city_id ? 223 : $data->city_id }};
        var countySelected ={{ ! $data->county_id ? 1883 : $data->county_id }};
        var initProvinceData = regionConf.r1.c;
        var initCityData = initProvinceData['r'+provinceSelected].c;
        var initCountyData = initCityData['r'+citySelected].c;
    @else
        var provinceSelected = citySelected = countySelected =0
        var initProvinceData = initCityData = initCountyData = {};
    @endif

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
                citySelect.html(initCitySelect(initCityData));
                countySelect.html(initCountySelect(initCountyData));
            }else{
                var r = "r"+v;
                city = regionConf.r1.c[r].c;
                citySelect.html(initCitySelect(regionConf.r1.c[r].c));
                countySelect.html(initCountySelect(initCountyData));
            }
        });

        citySelect.on('change',function(){
            var v = $(this).val();
            if( v == 0 ){
                countySelect.html(initCountySelect(initCountyData));
            }else{
                var r = "r"+v;
                countySelect.html(initCountySelect(city[r].c));
            }
        });
    });
    </script>
@stop