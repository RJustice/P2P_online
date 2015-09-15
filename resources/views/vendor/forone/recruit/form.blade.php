@section('css')
{!! UEditor::css() !!}
@stop
@inject('category','App\Category')
{!! Form::form_text('title','招聘职位','招聘职位') !!}
{!! Form::form_text('alias','缩略名') !!}
{!! UEditor::content($data->content,['name'=>'content','class'=>'form-group col-sm-12']) !!}
{!! Form::form_radio('published','即刻发布',[
    [1,'是',true],
    [0,'否']
],0.5) !!}
{!! Form::form_text('ordering','排序','数值越大越靠前,最大255,默认不填') !!}
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