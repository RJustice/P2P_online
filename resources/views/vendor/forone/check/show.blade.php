@extends('forone::layouts.master')
@section('main')
<div class="row">
    <div class="col-sm-12">
        {!! Form::ipanel_start('查看 : '.$data->order_sn) !!}
        @if($data->status == App\DealOrder::STATUS_PENDING)
        <div class="alert alert-info text-center">
            <div class="row">
                <div class="col-sm-12">
                    {!! Form::model($data,['method'=>'PUT','route'=>['admin.'.$uri.'.update',$data->order_sn],'class'=>'form-horizontal','id'=>'check-form']) !!}
                        {!! Form::iform_text('memo','备注','请输入备注或者理由',1) !!}
                        {!! Form::ihidden_input('id',$data->getKey()) !!}
                        {!! Form::ihidden_input('status') !!}
                        <div class="row">
                            <div class="col-sm-12 text-center"><a href="javascript:;" class="btn btn-success pass">通过</a>&nbsp;&nbsp;<a href="javascript:;" class="btn btn-danger not-pass">不通过</a></div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @elseif($data->status == App\DealOrder::STATUS_NOT_PASSED)
        <div class="alert alert-danger text-center">
            <h5>该条操作已经由 {{ $data->whoConfirm->name}} 审核,但是没有通过!</h5>
        </div>
        @elseif($data->status == App\DealOrder::STATUS_PASSED)
        <div class="alert alert-success text-center">
            <h5>该条操作已经由 {{ $data->whoConfirm->name}} 审核通过</h5>
        </div>
        @endif
        <ul class="list-group col-md-6 col-sm-12">
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Morbi leo risus</li>
          <li class="list-group-item">Porta ac consectetur ac</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
        <ul class="list-group col-md-6 col-sm-12">
          <li class="list-group-item">Cras justo odio</li>
          <li class="list-group-item">Dapibus ac facilisis in</li>
          <li class="list-group-item">Morbi leo risus</li>
          <li class="list-group-item">Porta ac consectetur ac</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
        {!! Form::ipanel_end() !!}
    </div>
</div>
@stop

@section('js')
    @parent
    <script type="text/javascript">
    $(function(){
        $('.pass').on('click',function(){
            $("input:hidden[name=status]").val( {{ App\DealOrder::STATUS_PASSED }} );
            $('#check-form').submit();
        });

        $('.not-pass').on('click',function(){
            $("input:hidden[name=status]").val( {{ App\DealOrder::STATUS_NOT_PASSED }} );
            $('#check-form').submit();
        });
    });
    </script>
@stop