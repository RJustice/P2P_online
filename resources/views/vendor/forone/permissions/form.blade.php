@if(!isset($edit))
{!! Form::igroup_text('name','系统名称','请输入权限系统名称') !!}
@endif
{!! Form::igroup_text('display_name','显示名称','请输入权限显示名称') !!}
{!! Form::igroup_text('description','权限描述','请输入权限描述') !!}

@section('js')
    @parent
@stop