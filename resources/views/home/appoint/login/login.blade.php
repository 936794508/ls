<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>登录</title>
    <link rel="stylesheet" href="{{URL::asset('weui/lib/weui.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('weui/css/jquery-weui.css')}}">
    <link rel="stylesheet" href="{{URL::asset('weui/demos/css/demos.css')}}">
</head>
<body ontouchstart>
<h1 class="demos-title">登录</h1>
<div class="weui_cells weui_cells_form">
    <div class="weui_cell weui_vcode">
        <div class="weui_cell_hd">
            <label class="weui_label">手机号</label>
        </div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" id="mobile" name="mobile" placeholder="请输入手机号">
        </div>
        <div class="weui_cell_ft">
            <a class="weui_btn weui_btn_default" href="javascript:;">发送验证码</a>
        </div>
    </div>
    <div class="weui_cell">
        <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
        <div class="weui_cell_bd weui_cell_primary">
            <input class="weui_input" type="text" id="verify" name="verify" placeholder="请输入验证码">
        </div>
    </div>
    <div class="weui_cell"></div>
    <div class="weui_cells_tips" align="center">如未查询到请联系客服</div>

    <br/>
    <div class="weui_btn_area">
        <input type="submit" value="登录" class="weui_btn weui_btn_primary" id="showTooltips">
    </div>

</div>
<script src="{{URL::asset('weui/lib/jquery-2.1.4.js')}}"></script>
<script src="{{URL::asset('weui/lib/fastclick.js')}}"></script>
<script src="{{URL::asset('weui/js/jquery-weui.js')}}"></script>
<script>
    function sendVerify(){
        var mobile = $('#mobile').val();
        var mobilePattern = /^1[34578]\d{9}$/;
        if(!mobilePattern.test(mobile)) {
            $.toptip('请输入正确的手机号');
            return false;
        }
        $.get("/index.php/Home/Sms/send1/mobile/"+mobile,function(data){
            if(data == '0' || data == 0){
                $.toptip('验证码发送成功', 'success');
            }else{
                $.toptip('验证码发送失败', 'error');
            }
        }, "text");//这里返回的类型有：json,html,xml,text
        Countdown();
    }
    $("a").click(function(){
        verify();
    });
    function verify(){
        /*$.prompt({
            text: "<img src='/index.php/home/sms/verify/"+Math.random()+"'>",
            title: "输入验证码",
            onOK: function(text) {
                $.get('/index.php/home/sms/getverify/verify/'+text,function(data){
                    if(data == 'ok'){
                        sendVerify();
                    }else{
                        $.toptip('输入错误', 'error');
                    }
                },'text');
            },
            onCancel: function() {
                console.log("取消了");
            },
        });*/
        sendVerify();
    }
    var timer = 60;
    function Countdown() {
        if (timer >= 1) {
            $("a").html('重新发送('+timer+'s)');
            $("a").unbind();
            $("a").addClass('weui_btn_disabled');
            timer -= 1;
            setTimeout(function() {
                Countdown();
            }, 1000);

        }else {
            $("a").removeClass('weui_btn_disabled');
            $("a").html('发送验证码');
            $("a").click(function(){
                timer = 60;
                verify();
            });
        }
    }
    function check(){
        var mobile = $('#mobile').val();
        var verify = $('#verify').val();
        var mobilePattern = /^1[34578]\d{9}$/;
        var identityPattern = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
        var verifyPattern = /(^\d{6}$)/;
        if(!mobilePattern.test(mobile)) {
            $.toptip('请输入正确的手机号');
            return false;
        }  else if(!verifyPattern.test(verify)){
            $.toptip('请输入正确的验证码');
            return false;
        }else{
            return true;
        }
    }
    $(":input[type='submit']").click(function(){
        if(check()){
            $.post("/appoint/login_check", {
                mobile:$('#mobile').val(),
                verify:$('#verify').val(),
                _token:'{{ csrf_token() }}'
            }, function(data){
                if(data.code== 200){
                    window.location.href='/appoint';
                }else if(data.code==1){
                    $.alert(data.info);
                }
            }, "json");//这里返回的类型有：json,html,xml,text
        }
    });
    /*$("#showTooltips").click(function() {
        var mobile = $('#mobile').val();
        var identity = $('#identity').val();
        if(!tel || !/1[3|4|5|7|8]\d{9}/.test(mobile)) $.toptip('请输入手机号');
        else if(!code || !/\d{6}/.test(identity)) $.toptip('请输入身份证号');
        else $.toptip('提交成功', 'success');
    });*/
</script>
</body>
</html>