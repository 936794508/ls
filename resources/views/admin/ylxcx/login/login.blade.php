<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理登录</title>
    <link href="{{URL::asset('/css/ls_style.css')}}" rel="stylesheet">
</head>
<body>
<div id="win10-login">
    <div style="height: 10%;min-height: 120px"></div>
    <div id="win10-login-box">
        <div class="win10-login-box-square">
            <img src="{{URL::asset('/images/avatar.jpg')}}" class="content"/>
        </div>
        <p style="font-size: 24px;color: white;text-align: center">管理员</p>
        <form target="_self" method="post" action="/admin/login/check" onsubmit="return login();">
            {{ csrf_field() }}
            <!--用户名-->
            <input type="text" placeholder="请输入登录名" class="login-username" name="username">
            <!--密码-->
            <input type="password" placeholder="请输入密码" class="login-password" name="password">
            <!--登陆按钮-->
            <input type="submit" value="登录" id="btn-login" class="login-submit"/>
        </form>
    </div>
</div>

<script type="text/javascript" src="{{URL::asset('/js/jquery-2.2.4.min.js')}}"></script>
<script type="text/javascript" src="{{URL::asset('/layer/layer.js')}}"></script>
<script>
    @if($status == 'error')
        layer.alert('登录失败', {icon: 5});
    @endif
    function login(){
        if($('.login-username').val()== '' || $('.login-password').val() == ''){
            layer.alert('请填写完整', {icon: 5});
            return false;
        }
        return true;
    }
</script>
</body>
</html>