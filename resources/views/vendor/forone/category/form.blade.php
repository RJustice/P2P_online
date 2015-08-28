@if(!isset($edit))
{!! Form::group_text('alias','系统名称','请输入系统显示名称') !!}
@endif
{!! Form::group_text('name','显示名称','请输入分类名称') !!}
{!! Form::group_text('description','分类描述','请输入系统描述') !!}
@section('js')
    @parent
@stop