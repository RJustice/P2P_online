$(function(){
        function Arabia_to_Chinese(Num) {
          for (i = Num.length - 1; i >= 0; i--) {
              Num = Num.replace(",", "");
              Num = Num.replace(" ", "");
          }
          Num = Num.replace("￥", "");
          if (isNaN(Num)) {
              return;
          }

          part = String(Num).split(".");
          newchar = "";

          for (i = part[0].length - 1; i >= 0; i--) {
              if (part[0].length > 10) {
                  return "";
              }
              tmpnewchar = ""
              perchar = part[0].charAt(i);
              switch (perchar) {
                  case "0": tmpnewchar = "零" + tmpnewchar; break;
                  case "1": tmpnewchar = "壹" + tmpnewchar; break;
                  case "2": tmpnewchar = "贰" + tmpnewchar; break;
                  case "3": tmpnewchar = "叁" + tmpnewchar; break;
                  case "4": tmpnewchar = "肆" + tmpnewchar; break;
                  case "5": tmpnewchar = "伍" + tmpnewchar; break;
                  case "6": tmpnewchar = "陆" + tmpnewchar; break;
                  case "7": tmpnewchar = "柒" + tmpnewchar; break;
                  case "8": tmpnewchar = "捌" + tmpnewchar; break;
                  case "9": tmpnewchar = "玖" + tmpnewchar; break;
              }
              switch (part[0].length - i - 1) {
                  case 0: tmpnewchar = tmpnewchar + "元"; break;
                  case 1: if (perchar != 0) tmpnewchar = tmpnewchar + "拾"; break;
                  case 2: if (perchar != 0) tmpnewchar = tmpnewchar + "佰"; break;
                  case 3: if (perchar != 0) tmpnewchar = tmpnewchar + "仟"; break;
                  case 4: tmpnewchar = tmpnewchar + "万"; break;
                  case 5: if (perchar != 0) tmpnewchar = tmpnewchar + "拾"; break;
                  case 6: if (perchar != 0) tmpnewchar = tmpnewchar + "佰"; break;
                  case 7: if (perchar != 0) tmpnewchar = tmpnewchar + "仟"; break;
                  case 8: tmpnewchar = tmpnewchar + "亿"; break;
                  case 9: tmpnewchar = tmpnewchar + "拾"; break;
              }
              newchar = tmpnewchar + newchar;
          }

          if (Num.indexOf(".") != -1) {

              if (part[1].length > 2) {
                  part[1] = part[1].substr(0, 2);
              }
              for (i = 0; i < part[1].length; i++) {
                  tmpnewchar = ""
                  perchar = part[1].charAt(i)
                  switch (perchar) {
                      case "0": tmpnewchar = "零" + tmpnewchar; break;
                      case "1": tmpnewchar = "壹" + tmpnewchar; break;
                      case "2": tmpnewchar = "贰" + tmpnewchar; break;
                      case "3": tmpnewchar = "叁" + tmpnewchar; break;
                      case "4": tmpnewchar = "肆" + tmpnewchar; break;
                      case "5": tmpnewchar = "伍" + tmpnewchar; break;
                      case "6": tmpnewchar = "陆" + tmpnewchar; break;
                      case "7": tmpnewchar = "柒" + tmpnewchar; break;
                      case "8": tmpnewchar = "捌" + tmpnewchar; break;
                      case "9": tmpnewchar = "玖" + tmpnewchar; break;
                  }
                  if (i == 0) tmpnewchar = tmpnewchar + "角";
                  if (i == 1) tmpnewchar = tmpnewchar + "分";
                  newchar = newchar + tmpnewchar;
              }
          }
          while (newchar.search("零零") != -1)
              newchar = newchar.replace("零零", "零");
          newchar = newchar.replace("亿零万", "亿");
          newchar = newchar.replace("零亿", "亿");
          newchar = newchar.replace("亿万", "亿");
          newchar = newchar.replace("零万", "万");
          newchar = newchar.replace("零元", "元");
          newchar = newchar.replace("零角", "");
          newchar = newchar.replace("零分", "");

          if (newchar.charAt(newchar.length - 1) == "元" || newchar.charAt(newchar.length - 1) == "角")
              newchar = newchar + "整";

          return newchar;
      }

      function showChineseAmount() {
        $(".error:eq(0)").text("");
        var regamount = /^(([1-9]{1}[0-9]{0,})|([0-9]{1,}\.[0-9]{1,2}))$/;
        var reg = new RegExp(regamount);
        var cash = $("#cash").text();
        if((/^\.$/).test($("#J_Deposit").val())){
            $(".error:eq(0)").text("请输入正确的金额，小数点后最多两位数!");
            $(".capital").text("");
            return;
        }
        if($("#J_Deposit").val() > parseFloat(cash.replace(/,/g,""))){
            $(".error:eq(0)").text("提现金额最大为"+cash+"元");
            $(".capital").text("");
            return;
        }
        if( parseFloat($("#J_Deposit").val()) == 0){
            $(".error:eq(0)").text("输入的金额不能为空或0!");
            return;
        }
        if ( parseFloat($("#J_Deposit").val())>0) {

            var amstr = $("#J_Deposit").val();
            var leng = amstr.toString().split('.').length;
            if(amstr.toString().split('.')[1] && amstr.toString().split('.')[1].length >2 ){
                $(".error:eq(0)").text("请输入正确的金额，小数点后最多两位数!");
                $(".capital").text("");
                return;
            }
            var change = $("#J_Deposit").val();
            if($("#J_Deposit").val().toString().match(/^0+/g)){
                var change = $("#J_Deposit").val().toString().replace(/^0+/g,"");
            }
            if (leng == 1) {
                $("#J_Deposit").val($("#J_Deposit").val() + ".00");
            }
            $(".capital").text(Arabia_to_Chinese(change));
            return;
        }
            if(!$("#J_Deposit").val()){
                $(".error:eq(0)").text("输入的金额不能为空或0!");
            }
            $(".capital").text("");

      }
      $("#J_Deposit").bind('blur',showChineseAmount);
      $("#J_Deposit").bind('change',showChineseAmount);
      $("#J_Deposit").bind("keyup", function() {
          var $this = $(this);
          var _this =  $this.val();
          if((/[^(\d|\.)]+/).test(_this)){
              _this = _this.replace(/[^(\d|\.)]+/, "");
          }else if((/(\.\d)[\.\d]+/).test(_this)){
              _this = _this.replace((/(\.(\d)+)[\.]+/),"$1")
          }else if((/\.(\.)+/.test(_this))){
              _this = _this.replace(/\.(\.)+/,'$1');
          }
          $this.val(_this);
      });
      $("#txtPassword").bind('blur',function(){
          $(".error:eq(1)").text("");
      });
      $("#txtcode").bind('blur',function(){
          $(".error:eq(2)").text("");
      });

    });
    function ac(){
      var money = $("#J_Deposit").val();
      var password = $("#txtPassword").val();
      var textcode = $("#txtcode").val();
      if(!money ||money == 0 ) {
          $('.error:eq(0)').text("输入的金额不能为空或0!");
      }
      if(!password) {
          $('.error:eq(1)').text("请输入支付密码!");
      }
      if(!textcode){
          $('.error:eq(2)').text("请输入短信验证码");
      }
      if($('.error').text() == ""){
          console.log('open modal');
          confirmModal();
      }
    }

    var modal,alertModal;
    function confirmModal(){
        var bank = $('#bank').val();
        var money = $('#J_Deposit').val();
        var smscode = $("#txtcode").val();
        var paypwd = $("#txtPassword").val();
        
        $("#cmoney").text(money);
        modal = new jBox('Confirm',{
            // id : 'confirm',
            title : '确认提款',
            // content: "确认提款到*****, 金额: 00000 ",
            content: $("#confirm-modal"),
            // width: 500,
            // height: 120,
            // animation : 'pulse'
            overlay : true,
            closeOnEsc : false,
            closeOnClick : false,
            closeButton: 'title',
            confirmButton : '确认',
            cancelButton : '取消',
            confirm : function(){
                $.ajax({
                    url : carryUrl,
                    type: 'post',
                    data: {bank:bank,money:money,_token:token,smscode:smscode,paypwd:paypwd},
                    dataType: 'json',
                    success:function(data){
                        if( data.code == 0 ){
                            alertModal = new jBox('Modal',{
                                title: "提现成功",
                                content: $("#alert-success"),
                                overlay: true,
                                closeButton: 'title',
                                onCloseComplete: function(){
                                    window.location.href = carryLog;
                                }
                            });
                            alertModal.open();
                        }else if( data.code == 1 ){
                            alertModal = new jBox('Modal',{
                                title: "验证码错误",
                                content: $("#alert-sms-error"),
                                overlay: true,
                                closeButton: 'title',
                            });
                            alertModal.open();
                        }else if( data.code == 2 ){
                            alertModal = new jBox('Modal',{
                                title: "支付密码错误",
                                content: $("#alert-pwd-error"),
                                overlay: true,
                                closeButton: 'title',
                            });
                            alertModal.open();
                        }else if( data.code ==3 ){
                            alertModal = new jBox('Modal',{
                                title: "余额不足",
                                content: $("#alert-money-error"),
                                overlay: true,
                                closeButton: 'title',
                            });
                            alertModal.open();
                        }
                    },
                    error:function(){
                        alertModal = new jBox('Modal',{
                            title: "网络错误",
                            content: $("#alert-network-error"),
                            overlay: true,
                            closeButton: 'title',
                        });
                        alertModal.open();
                    }
                });
                modal.close();
            }
        });
        modal.open();
    }
