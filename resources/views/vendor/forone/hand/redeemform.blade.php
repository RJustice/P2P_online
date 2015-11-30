@section('css')
    @parent
@stop
<div class="row">
    <div class="col-sm-12">
        @if( str_is('new',$uid) )
        @include("forone::common.memberselect")
        @else
        <input type="hidden" name="uid" value="{{ $uid }}">
        @endif
        {!! Form::iform_date('create_date','赎回时间','',1) !!}
    </div>
</div>
@section('js')
    @parent
    <script type="text/javascript" src="{{ asset('js/lrz/lrz.bundle.js') }}"></script>
    <script type="text/javascript">
    $(function(){
        function toFixed2 (num) {
            return parseFloat(+num.toFixed(2));
        }

        function deleteImg(){
            $(this).parent().remove();
        }

        $("#proof").on('change',function(){
            var _this = $(this);
            lrz($(this)[0].files[0],{width:1000,quality:0.5})
            .then(function(rst){
                console.log(rst);
                var img = new Image();
                var div,delBtn,input;
                img.src = rst.base64;
                div = $('<div class="col-md-4 col-sm-6"><a href="javascript:;" class="thumbnail"></a></div>');
                delBtn = $('<span class="delimg-btn glyphicon glyphicon-remove"></span>').on('click',deleteImg);
                input = $('<input type="hidden" value="'+rst.base64+'" name="proof[]"/>');
                inputLen = $('<input type="hidden" value="'+rst.base64Len+'" name="proof_len[]"/>');
                div.append(delBtn);
                div.append(input);
                div.append(inputLen);
                div.find('a').append(img);
                $("#proof-preview").append(div);
                return rst;
            })
            .catch(function(err){
                console.log(err);
            });
        });

        $("#recharge-form").submit(function(){
            $(this).find("input#proof").remove();
            // return false;
        });
    });
    </script>
@stop