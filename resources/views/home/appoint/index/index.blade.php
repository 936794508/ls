<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <title>预约</title>
    <link rel="stylesheet" href="{{URL::asset('weui/lib/weui.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('weui/css/jquery-weui.css')}}">
    <link rel="stylesheet" href="{{URL::asset('weui/demos/css/demos.css')}}">
</head>
<body ontouchstart>
<a class="weui_grid js_grid" href="/appoint/toPhysical">
    <div class="weui_grid_icon">
        <img src="{{URL::asset('weui/demos/images/icon_nav_icons.png')}}" alt="">
    </div>
    <p class="weui_grid_label"> 体检预约 </p>
</a>

<a class="weui_grid js_grid" href="/appoint/physicalList">
    <div class="weui_grid_icon">
        <img src="{{URL::asset('weui/demos/images/icon_nav_article.png')}}" alt="">
    </div>
    <p class="weui_grid_label"> 体检查询 </p>
</a>

<a class="weui_grid js_grid" href="/appoint/kf">
    <div class="weui_grid_icon">
        <img src="{{URL::asset('images/appoint/ui/phone.png')}}" alt="">
    </div>
    <p class="weui_grid_label"> 联系客服 </p>
</a>

<script src="{{URL::asset('weui/lib/jquery-2.1.4.js')}}"></script>
<script src="{{URL::asset('weui/lib/fastclick.js')}}"></script>
<script src="{{URL::asset('weui/js/jquery-weui.js')}}"></script>
<script>
</script>
</body>
</html>