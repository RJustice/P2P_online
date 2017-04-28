@extends('forone::layouts.master')
@section('css')
<style type="text/css">
span.labelx{font-size:14px;font-weight: 600;text-align:right;color:#000;display: inline-block;}
span.price{font-size:14px;font-weight: 600;color:#ff5a13;letter-spacing: 1px;}
</style>
@stop
@section('main')
<div class="row">
    <div class="col-sm-12">
        {!! Form::ipanel_start('查看 : '.$data->order_sn.'') !!}
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    {{-- {!! Form::ipanel_start('客户信息') !!} --}}
                    <h4>客户信息</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="labelx col-sm-3">姓名：</span>{{ $data->member->name }}&nbsp;&nbsp;&nbsp;({{ App\User::getSex($data->member->sex) }})&nbsp;
                        </li>
                        <li class="list-group-item">
                            <span class="labelx col-sm-3">电话：</span>{{ $data->member->phone }}&nbsp;
                        </li>                        
                        <li class="list-group-item">
                            <span class="labelx col-sm-3">区域：</span>{{ $data->member->formatRegion() }}&nbsp;
                        </li>
                        <li class="list-group-item">
                            <span class="labelx col-sm-3">住址：</span>{{ $data->member->address }}&nbsp;
                        </li>
                        <li class="list-group-item">
                            <span class="labelx col-sm-3">身份证：</span>{{ $data->member->idno }}&nbsp;
                        </li>
                        <li class="list-group-item">
                            <span class="labelx col-sm-3">邮箱：</span>{{ $data->member->email }}&nbsp;
                        </li>
                        <li class="list-group-item">
                            <span class="labelx col-sm-3">注册时间：</span>{{ $data->member->created_at->format('Y-m-d') }}&nbsp;
                        </li>
                        <li class="list-group-item">
                            <span class="labelx col-sm-3">注册来源：</span>{{ App\User::getRefererTitle($data->member->referer) }}&nbsp;
                        </li>
                    </ul>
                    {{-- {!! Form::ipanel_end() !!} --}}
                </div>                
                <div class="col-md-6 col-sm-12">
                    {{-- {!! Form::ipanel_start('客户的销售经理') !!} --}}
                    <h4>客户的销售经理</h4>
                    @if( $data->member->salesManager )
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="labelx">姓名：</span>{{ $data->member->salesManager->name }}&nbsp;
                            </li>
                            <li class="list-group-item">
                                <span class="labelx">电话：</span>{{ $data->member->salesManager->phone }}&nbsp;
                            </li>                        
                            <li class="list-group-item">
                                <span class="labelx">区域：</span>{{ $data->member->salesManager->formatRegion() }}&nbsp;
                            </li>
                            <li class="list-group-item">
                                <span class="labelx">分公司：</span>{{ $data->member->salesManager->company->name }}&nbsp;
                            </li>
                            <li class="list-group-item">
                                <span class="labelx">邮箱：</span>{{ $data->member->salesManager->email }}&nbsp;
                            </li>
                        </ul>
                    @else
                        {!! Form::open(['route'=>'admin.members.get-add-ref','class'=>'form-horizontal']) !!}
                        {!! Form::iform_select('sales_manager','选择销售',App\User::getSalesManagers(true),1) !!}
                        {!! Form::ihidden_input('uid',$data->member->getKey()) !!}
                        <button value="分配" class="btn btn-success btn-block">分配</button>
                        {!! Form::close() !!}
                    @endif
                    {{-- {!! Form::ipanel_end() !!} --}}
                </div>
            </div>
        {!! Form::ipanel_end() !!}
    </div>
    <div class="col-sm-12">
    {!! Form::ipanel_start('订单信息' . '&nbsp;&nbsp;&nbsp;&nbsp;---&nbsp;&nbsp;&nbsp;&nbsp;'. App\DealOrder::getOrderTypeTitle($data->type) .'<span style="float:right;margin-right:30px;">创建时间：'.$data->created_at->format('Y-m-d H:i').'</span>') !!}
            <div class="row">
                <div class="col-sm-12">
                    <ul class="list-group">
                        <li class="list-group-item"><span class="labelx col-sm-3">订单编号：</span>{{ $data->order_sn }}</li>
                        <li class="list-group-item"><span class="labelx col-sm-3">订单金额：</span><span class="price">{{ number_format($data->total_price,2) }}</span></li>
                        @if( in_array($data->type,[App\DealOrder::TYPE_OFFLINE_ORDER,App\DealOrder::TYPE_ONLINE_ORDER]))
                        <li class="list-group-item list-group-item-info">
                            <span class="labelx col-sm-3">理财名称：</span><a href="{{ route('admin.deals.show',['id'=>$data->deal_id]) }}" title="查看理财项目">{{ $data->deal_title }}</a>
                        </li>
                        <li class="list-group-item list-group-item-info">
                            <span class="labelx col-sm-3">预期年收益：</span>{{ $data->deal_rate }}
                        </li>
                        <li class="list-group-item list-group-item-info">
                            <span class="labelx col-sm-3">开始时间：</span>{{ $data->create_date }}
                        </li>
                        <li class="list-group-item list-group-item-info">
                            <span class="labelx col-sm-3">结束时间：</span>{{ $data->finish_date }} @if( strtotime($data->finish_date) - time() <= 5 * 24 * 60 * 60  ) <span class="label label-warning">即将到期</span> @endif
                        </li>
                        <li class="list-group-item list-group-item-info">
                            <span class="labelx col-sm-3">备注：</span>{{ $data->admin_meno }}
                        </li>
                        @endif
                    </ul>
                </div>
                @if( $data->proofs )
                <?php $proofs = json_decode($data->proofs->proofs); ?>
                <div class="col-sm-12">
                    <h4>凭证</h4>
                    <div class="row">
                        @foreach($proofs as $proof)
                        <div class="col-sm-12 col-md-3">
                            <a href="{{ route('proof',['filename'=>implode('_',explode('/',$proof)),'size'=>'full']) }}" target="_blank" class="thumbnail">
                                <img src="{{ route('proof',['filename'=>implode('_',explode('/',$proof)),'size'=>'w350']) }}" alt="">
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        {!! Form::ipanel_end() !!}
    </div>
</div>
@stop