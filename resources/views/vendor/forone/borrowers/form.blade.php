@section('css')
@stop
{!! Form::iform_text('name','姓名','请输入姓名',1) !!}
{!! Form::iform_text('idno','身份证号','请输入身份证号',1) !!}
{!! Form::iform_text('loan','借款金额','请输入借款金额',1) !!}
{!! Form::iform_date('repay_start','还款时间','',1) !!}
{!! Form::iform_date('repay_end','结束时间','',1) !!}
{!! Form::iform_text('periods','期数','请输入期数',1) !!}
{!! Form::iform_select('use','用途',[['label'=>'资金周转','value'=>'资金周转'],['label'=>'投资创业','value'=>'投资创业'],['label'=>'汽车消费','value'=>'汽车消费'],['label'=>'购房借款','value'=>'购房借款'],['label'=>'装修借款','value'=>'装修借款']],1) !!}