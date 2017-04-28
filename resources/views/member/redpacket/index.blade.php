@extends("_layouts.center")

@section('content')
<div class="list-title clearfix">
    <div class="{{ $status ? '' : 'cur' }}">
        <a href="{{ route('member.redpacket') }}">未使用的红包</a>
    </div>
    <div class="{{ $status == 'used' ? 'cur' : '' }}">
        <a href="{{ route('member.redpacket',['status'=>'used']) }}">已使用的红包</a>
    </div>
    <div class="{{ $status == 'exp'? 'cur' : '' }}">
        <a href="{{ route('member.redpacket',['status'=>'exp']) }}">已过期的红包</a>
    </div>
</div>
@stop

@section('js')
@stop