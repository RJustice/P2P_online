@if(!isset($edit))
{!! Form::igroup_text('name','系统名称','请输入角色系统名称') !!}
@endif
{!! Form::igroup_text('display_name','显示名称','请输入角色显示名称') !!}
{!! Form::igroup_text('description','角色描述','请输入角色描述') !!}

@section('js')
    @parent
@stop