@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="{{ route('member.fund.carry') }}">提现</a>
    </div>
</div>
<div id="no-bankcard" class="layer">
    <p>您还没有绑定银行卡,无法进行提现.</p>
    <p><a href="{{ route('member.account.bankcard') }}" class="a-btn">去绑定</a></p>
</div>
@stop

@section('js')
    <script type="text/javascript">
    $(function(){
        var modal = new jBox('Modal',{
            title : '未绑定银行卡',
            content: $("#no-bankcard"),
            overlay : true,
            closeOnEsc : false,
            closeOnClick : false,            
            closeButton: 'title',
            onCloseComplete:function(){
                window.location.href = '{{ route('member') }}';
            }
        });
        modal.open();
    });
    </script>
@stop