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
<div class="weui_tab">

    <div class="weui_tab_bd">

        <!--项目介绍-->
        <div class="weui_panel weui_panel_access">
            <div class="weui_panel_bd">
                <div class="weui_cell weui_cell_select">
                    <div class="weui_cell">
                        <div class="weui_cell_hd">
                            <label class="weui_label">性别</label>
                        </div>
                    </div>
                    <div class="weui_cell_bd weui_cell_primary">
                        <select class="weui_select" name="sex" id="sex">
                            <option value="1">男</option>
                            <option value="2">女</option>
                        </select>
                    </div>
                </div>
                <div class="weui_media_box weui_media_text">
                    <h4 class="weui_media_title">套餐价格</h4>
                    <p class="weui_media_desc">元</p>
                </div>
                <div class="weui_media_box weui_media_text">
                    <h4 class="weui_media_title">套餐项目</h4>
                    <p class="weui_media_desc"></p>
                </div>
            </div>
        </div>
        <br/>
        <br/>
        <div class="demos-content-padded">
            <a class="weui_btn weui_btn_primary" href="javascript:;">下一步</a>
        </div>

    </div>
</div>

<script src="{{URL::asset('weui/lib/jquery-2.1.4.js')}}"></script>
<script src="{{URL::asset('weui/lib/fastclick.js')}}"></script>
<script src="{{URL::asset('weui/js/jquery-weui.js')}}"></script>
<script>
    $('.weui_btn_primary').click(function(){

    });
</script>
</body>
</html>