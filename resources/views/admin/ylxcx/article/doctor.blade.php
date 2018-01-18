@extends("admin.ylxcx.common.base")
@section("index")
    <div class="x-body">
        <form class="layui-form">
          <div class="layui-form-item">
              <label for="title" class="layui-form-label">
                  <span class="x-red">*</span>标题
              </label>
              <div class="layui-input-inline">
                  <input type="hidden" name="Id" value="{{ $Info->Id }}">
                  <input type="text" id="title" name="title" required="" lay-verify="required"
                  autocomplete="off" class="layui-input" value="{{ $Info->title }}">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="author" class="layui-form-label">
                  <span class="x-red">*</span>作者
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="author" name="author" required="" lay-verify="required"
                  autocomplete="off" class="layui-input" value="{{ $Info->author }}">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="abstract" class="layui-form-label">
                  <span class="x-red">*</span>简介
              </label>
              <div class="layui-input-inline">
                  <input type="text" id="abstract" name="abstract" required="" lay-verify="required"
                  autocomplete="off" class="layui-input" value="{{ $Info->abstract }}">
              </div>
          </div>
          <div class="layui-form-item">
              <label for="image" class="layui-form-label">
                  <span class="x-red">*</span>缩略图
              </label>
              <div class="layui-input-inline">
                  <input type="file" id="image" name="image"
                         autocomplete="off" class="layui-input">
              </div>
          </div>

          {{--<div class="layui-form-item">
              <label for="username" class="layui-form-label">
                  <span class="x-red">*</span>配送物流
              </label>
              <div class="layui-input-inline">
                  <select id="shipping" name="shipping" class="valid">
                    <option value="shentong">申通物流</option>
                    <option value="shunfeng">顺丰物流</option>
                  </select>
              </div>
          </div>--}}
          <div class="layui-form-item layui-form-text">
              <label for="content" class="layui-form-label">
                  内容
              </label>
              <div class="layui-input-block">
                  <!-- 加载编辑器的容器 -->
                  <script id="container" name="content" type="text/plain">{{ $Info->content }}</script>
              </div>
          </div>0
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  增加
              </button>
          </div>
      </form>
    </div>
    <script>

        function compile(){
            var text = document.getElementById("content").value;
            var converter = new showdown.Converter();
            var html = converter.makeHtml(text);
            document.getElementById("result").innerHTML = html;
        }


        layui.use(['form','layer'], function(){
            $ = layui.jquery;
          var form = layui.form
          ,layer = layui.layer;

          //自定义验证规则
          form.verify({
            nikename: function(value){
              if(value.length < 5){
                return '昵称至少得5个字符啊';
              }
            }
          });

          //监听提交
          form.on('submit(add)', function(data){
            console.log(data);
            //发异步，把数据提交给php
            layer.alert("增加成功", {icon: 6},function () {
                // 获得frame索引
                var index = parent.layer.getFrameIndex(window.name);
                //关闭当前frame
                parent.layer.close(index);
            });
            return false;
          });
          
          
        });
    </script>

    <!-- 配置文件 -->
    <script type="text/javascript" src="{{URL::asset('/js/ueditor/ueditor.config.js')}}"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="{{URL::asset('/js/ueditor/ueditor.all.js')}}"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>
    <script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
      })();</script>
@endsection