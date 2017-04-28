@section('css')
{!! UEditor::css() !!}
@stop
@inject('category','App\Category')
{!! Form::iform_text('title','项目说明标题','项目说明标题') !!}
{!! Form::iform_text('alias','缩略名') !!}
{!! Form::iform_select('deal_id','对应项目',App\Deal::getDealsOption()) !!}
{!! UEditor::content($data->content,['name'=>'content','class'=>'form-group col-sm-12']) !!}
{!! Form::iform_radio('published','即刻发布',[
    [1,'是',true],
    [0,'否']
],0.5) !!}
{{-- {!! Form::iform_text('ordering','排序','数值越大越靠前,最大255,默认不填') !!} --}}
@section('js')
    @parent
    {!! UEditor::js() !!}
    <script type="text/javascript">
    var ue = UE.getEditor('ueditor');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
    });
    </script>
@stop