{!! Form::iform_text('phone','手机号码','请输入手机号码',1) !!}
{!! Form::iform_text('name','姓名','请输入真实姓名',1) !!}
{!! Form::iform_select('company_id','所属',\App\Company::getCompanyOption(true),1) !!}
{!! Form::iform_text('email','Email','请输入Email地址',1) !!}
{!! Form::iform_password('password','密码','请输入密码',1) !!}
{!! Form::iform_radio('is_deleted','禁用',[[0,'是'],[1,'否',true]],1) !!}
{!! Form::iform_text('idno','身份证号','请输入正确身份证号码',1) !!}
{!! Form::iform_radio('sex','性别',[[1,'男'],[0,'女']],1) !!}
{{-- @inject('region','App\Region') --}}
{!! Form::iform_select('province_id','省份',[],1/3) !!}
{!! Form::iform_select('city_id','市',[],1/3) !!}
{!! Form::iform_select('county_id','区域',[],1/3) !!}

{!! Form::iform_text('address','地址','请输入地址',1) !!}

{{-- @if (str_is('admin.admins.create', Route::current()->getName())) --}}
    {{-- {!! Form::igroup_password('password','密码','请输入密码',1) !!} --}}
{{-- @endif --}}

@section('js')
    @parent
    @include('common.regionjs')
@stop