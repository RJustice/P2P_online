{!! Form::form_text('phone','手机号码','请输入手机号码',1) !!}
{!! Form::form_text('name','姓名','请输入真实姓名',1) !!}
{!! Form::form_text('email','Email','请输入Email地址',1) !!}
{!! Form::form_password('password','密码','请输入密码',1) !!}
{!! Form::form_radio('is_delete','禁用',[[0,'是'],[1,'否',true]],1) !!}
{!!Form::form_text('idno','身份证号','请输入正确身份证号码',1) !!}
{{-- @inject('region','App\Region') --}}
{!! Form::form_select('province_id','省',[],0.5) !!}
{!! Form::form_select('city_id','市',[],0.5) !!}

{{-- @if (str_is('admin.admins.create', Route::current()->getName())) --}}
    {{-- {!! Form::group_password('password','密码','请输入密码',1) !!} --}}
{{-- @endif --}}

@section('js')
    @parent
    <script type="text/javascript" src="/js/region.js"></script>
    <script type="text/javascript">
    // var initSelect = {"r":{"i":0,"n":"请选择","c":""}};
    var initSelect = {};
    function initProvinceSelect(data){
        var  o = "<option value=\"0\">请选择</option>";
        for(var k in data){
            o += "<option value="+data[k].i+">"+data[k].n+"</option>";
        }
        return o;
    }

    function initCitySelect(data){
        var  o = "<option value=\"0\">请选择</option>";
        for(var k in data){
            o += "<option value="+data[k].i+">"+data[k].n+"</option>";
        }
        return o;
    }



    $(function(){
        var provinceSelect = $("select[name=province_id]");
        var citySelect = $("select[name=city_id]");
        // console.log(provinceSelect);
        provinceSelect.html(initProvinceSelect(regionConf["r1"].c));
        citySelect.html(initCitySelect(initSelect));
        provinceSelect.on('change',function(){
            var v = $(this).val();
            if( v == 0 ){
                citySelect.html(initCitySelect(initSelect));
            }else{
                var r = "r"+v;
                citySelect.html(initCitySelect(regionConf.r1.c[r].c));
            }
        });
    });
    </script>
@stop