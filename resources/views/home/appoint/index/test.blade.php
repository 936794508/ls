<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"   content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
    <title>用户测试用例</title>
    <link rel="stylesheet" href="//g.alicdn.com/de/prismplayer/2.2.0/skins/default/aliplayer-min.css" />
    <script type="text/javascript" src="//g.alicdn.com/de/prismplayer/2.2.0/aliplayer-min.js"></script>
</head>
<body>
<div  class="prism-player" id="J_prismPlayer" style="position: absolute"></div>
<script>
    var player = new Aliplayer({
        id: 'J_prismPlayer',
        width: '50%',
        autoplay: false,
        //支持播放地址播放,此播放优先级最高
        source : 'http://player.youku.com/player.php/Type/Folder/Fid/18117290/Ob/1/sid/XNDQ0MDQzMTgw/v.swf',
        //播放方式二：推荐
        /*vid : '784ba49349354c3c90f6b90fd99c56c7',
        playauth : '',
        cover: 'http://liveroom-img.oss-cn-qingdao.aliyuncs.com/logo.png'*/
    });
</script>
</body>
</html>