@extends('_layouts.center')

@section('content')
<div class="list-title clearfix">
    <div class="cur">
        <a href="javascript:;">我的客户</a>
    </div>
</div>
<div id="no-auth" class="layer">
    <p>您不是该客户的推荐人(业务经理人),无权查看该客户的信息.</p>
</div>
@stop

@section('js')
    <script type="text/javascript">
    $(function(){
        var modal = new jBox('Modal',{
            title : '无权查看',
            content: $("#no-auth"),
            overlay : true,
            closeOnEsc : false,
            closeOnClick : false,            
            closeButton: 'title',
            onCloseComplete:function(){
                window.location.href = '{{ route('member.mycustomer.index') }}';
            }
        });
        modal.open();
    });
    </script>
@stop