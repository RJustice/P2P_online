
{!! Form::group_text('username','用户名','请输入用户名,登陆使用!',1) !!}
{!! Form::group_text('name','真实名字','请输入真实名字',1) !!}
{!! Form::group_text('email','邮箱','请输入邮箱',1) !!}
{!! Form::group_text('phone','手机','请输入手机号码',1) !!}
{!! Form::group_radio('state','禁用',[[0,'是'],[1,'否',true]],1) !!}
@if (str_is('admin.admins.create', Route::current()->getName()))
    {!! Form::group_password('password','密码','请输入密码',1) !!}
@endif

@section('js')
    @parent
@stop