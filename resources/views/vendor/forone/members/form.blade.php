{!! Form::iform_text('phone','手机号码','请输入手机号码',1) !!}
{!! Form::iform_text('name','姓名','请输入真实姓名',1) !!}
{{-- {!! Form::iform_text('email','Email','请输入Email地址',1) !!} --}}
@if( ! str_is('admin.'.$uri.'.edit', Route::current()->getName()) )
{!! Form::iform_password('password','密码','请输入密码',1) !!}
@endif
{!! Form::iform_radio('is_deleted','禁用',[[1,'是'],[0,'否',true]],1) !!}
{!! Form::iform_text('idno','身份证号','请输入正确身份证号码',1) !!}
{!! Form::iform_radio('sex','性别',[[1,'男',true],[0,'女']],1) !!}
{{-- @inject('region','App\Region') --}}
{!! Form::iform_select('province_id','省份',[],1/3) !!}
{!! Form::iform_select('city_id','市',[],1/3) !!}
{!! Form::iform_select('county_id','区域',[],1/3) !!}

{!! Form::iform_text('address','地址','请输入地址',1) !!}

{{-- @inject('userModel','App\User'); --}}
@if(Auth::user()->can(['admin']) || Auth::user()->hasRole('employee_m') )
@include("forone::common.employeeselect")
{!! Form::iform_radio('type','是否为员工',[[App\User::TYPE_MEMBER,'否',true],[App\User::TYPE_EMPLOYEE,'是']],1) !!}
@endif
{{-- @if (str_is('admin.admins.create', Route::current()->getName())) --}}
    {{-- {!! Form::igroup_password('password','密码','请输入密码',1) !!} --}}
{{-- @endif --}}

@section('js')
    @parent
    @include('common.regionjs')
@stop