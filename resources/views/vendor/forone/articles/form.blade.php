@section('css')
{!! UEditor::css() !!}
@stop
@inject('category','App\Category')
{!! Form::form_text('title','文章标题','请输入文章标题') !!}
{!! Form::form_select('categoryid','文章分类',\App\Category::getCategoriesOptions()) !!}
{!! UEditor::content($data->content,['name'=>'content','class'=>'form-group col-sm-12']) !!}
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