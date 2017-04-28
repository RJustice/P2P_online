@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="{{ route('member.fund.carry') }}">赎回</a>
    </div>
</div>
<div id="no-bankcard" class="layer">
    <p>您没有可以赎回的理财产品.</p>
    <p><a href="{{ url('invest') }}" class="a-btn">去理财</a></p>
</div>
@stop

@section('js')
    <script type="text/javascript">
    $(function(){
        var modal = new jBox('Modal',{
            title : '无可赎回理财产品',
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