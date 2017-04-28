@section('css')
    @parent
{!! UEditor::css() !!}
@stop
{!! Form::iform_text('titlecolor','标题颜色','',1) !!}
{!! Form::iform_text('deal_sn','理财编号','请输入编号,用户电子合同,不得重复',1) !!}
{!! Form::iform_text('title','理财项目名称','请输入项目名称',1) !!}
{!! Form::iform_text('sub_title','短标题','用户短信或邮件通知',1) !!}

{!! Form::iform_text('repay_time','期限','请输入期限,单位: 天数',1) !!}
{!! Form::iform_text('rate','预期年化收益率','请输入年化收益率,单位: %',1) !!}
{!! Form::iform_select('loan_type','还款方式',\App\Deal::getLoanTypeOption(true),1) !!}
{!! Form::iform_text('min_loan_money','最低投资金额','请输入最低投资金额,单位: 元',1) !!}
{!! Form::iform_text('max_loan_money','最高投资金额','请输入最高投资金额,单位: 元. 0表示不限制',1) !!}
{!! Form::iform_radio('is_effect','状态',[[1,'有效',true],[0,'失效']],1) !!}
{!! Form::iform_text('sort','排序','大 > 小',1) !!}

{!! UEditor::content($data->content,['name'=>'description','class'=>'form-group col-sm-12']) !!}

{{-- {!! Form::ifile('icon') !!} --}}
{!! Form::iform_radio('is_hot','设为热门',[[1,'是'],[0,'否']]) !!}
{!! Form::iform_radio('is_best','设为最佳',[[1,'是'],[0,'否']]) !!}
{!! Form::iform_radio('is_rec','设为推荐',[[1,'是'],[0,'否']]) !!}
{!! Form::iform_text('borrow_amount','可投资总额','仅用于首页项目展示',1) !!}
{!! Form::iform_text('load_money','已获多少','仅用于首页项目展示',1) !!}
{!! Form::iform_text('buy_count','投资人数','仅用于首页项目展示',1) !!}
{!! Form::iform_area('intro_info','简短描述','仅用于首页项目展示',1) !!}
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