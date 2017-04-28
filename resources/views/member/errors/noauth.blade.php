@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="{{ route('member.account.authenticate') }}">认证</a>
    </div>
</div>
<div id="no-auth" class="layer">
    <p>您还有身份认证,请先认证才能进一步操作.</p>
    <p><a href="{{ route('member.account.authenticate') }}" class="a-btn">立即认证</a></p>
</div>
@stop

@section('js')
    <script type="text/javascript">
    $(function(){
        var modal = new jBox('Modal',{
            title : '未身份认证',
            content: $("#no-auth"),
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