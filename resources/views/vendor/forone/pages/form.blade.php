@section('css')
{!! UEditor::css() !!}
@stop
@inject('category','App\Category')
{!! Form::iform_text('title','文章标题','请输入文章标题') !!}
{!! Form::iform_text('alias','缩略名') !!}
{!! UEditor::content($data->content,['name'=>'content','class'=>'form-group col-sm-12']) !!}
{!! Form::iform_radio('published','即刻发布',[
    [1,'是',true],
    [0,'否']
],0.5) !!}
{!! Form::iform_text('ordering','排序','数值越大越靠前,最大255,默认不填') !!}
{!! Form::iform_text('out_link','外链','填写外链,会自动连接到媒体报道的链接内容! 如无,请勿填写!',1) !!}
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