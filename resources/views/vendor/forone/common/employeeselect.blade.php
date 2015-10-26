@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/combo.select.css') }}">
@stop
{!! Form::iform_select('sales_manager','指定销售经理',array_merge([['label'=>'请选择','value'=>0]],\App\User::getSalesManagers(true)),1) !!}
@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/jquery.combo.select.js') }}"></script>
    <script type="text/javascript">
    $(function(){
        $("select[name=sales_manager]").comboSelect();
    });
    </script>
@stop