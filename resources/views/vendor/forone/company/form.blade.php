@section('css')
@stop
{!! Form::iform_text('name','分公司名','请输入分公司名',1) !!}
{!! Form::iform_radio('status','状态',[[0,'无效'],[1,'有效',true]],1) !!}
{!! Form::iform_select('province_id','省份',[],1/3) !!}
{!! Form::iform_select('city_id','市',[],1/3) !!}
{!! Form::iform_select('county_id','区域',[],1/3) !!}
@section('js')
    @parent
    @include('common.regionjs')
@stop