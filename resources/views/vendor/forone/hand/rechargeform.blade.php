@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('vendor/forone/styles/uploadfile.css') }}">
    <style type="text/css">
    #proof-preview{margin-top:20px;position:relative;}
    #proof-preview .col-md-4,#proof-preview .col-sm-6{margin-bottom:15px;position: relative;}
    #proof-preview .delimg-btn{position: absolute;right:10px;top:-10px;color:#f44336;font-size:35px;border:1px solid #f44336;padding:3px;border-radius: 30px;cursor: pointer;}
    </style>
@stop
<div class="row">
    <div class="col-sm-12">
        @if( str_is('new',$uid) )
        {!! Form::iform_select('uid','选择客户',array_merge([['label'=>'请选择','value'=>0]],\App\User::getMembersOption(true)),1) !!}
        @else
        <input type="hidden" name="uid" value="{{ $uid }}">
        @endif
        {!! Form::iform_text('total_price','充值金额','请输入充值金额',1) !!}
        {!! Form::iform_text('admin_memo','备注','请输入备注内容',1) !!}        
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
    {!! Form::ipanel_start('相关资料上传') !!}
        <div id="prooffiles">
            {!! Form::file('proof',['id'=>'proof','class'=>'proof-input']) !!}
        </div>
        <div id="proof-preview"></div>
    {!! Form::ipanel_end(false) !!}
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