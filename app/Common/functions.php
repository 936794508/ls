<?php
function curl_request($url,$https=true,$method='get',$data=null){
    //1.初始化url
    $ch = curl_init($url);
    //2.设置相关的参数
    //字符串不直接输出,进行一个变量的存储
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //判断是否为https请求
    if($https === true){
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    //判断是否为post请求
    if($method == 'post'){
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    //3.发送请求
    $str = curl_exec($ch);
    //4.关闭连接
    curl_close($ch);
    //返回请求到的结果
    return $str;
}

//跳转
function success($url, $msg = '操作成功！', $waitSecond=2){
    return view('jump', ['info' => ['status'=>'success','msg'=>$msg,'url'=>$url], 'waitSecond'=>$waitSecond]);
}

function error($url, $msg = '操作失败！', $waitSecond=2){
    return view('jump', ['info' => ['status'=>'error','msg'=>$msg,'url'=>$url], 'waitSecond'=>$waitSecond]);
}

/**
 * 返回接口数据
 * @param $array array 需要返回的数据
 * @param $code string  错误码
 * @param $info string 错误信息
 * @return string json字符串
 * */
function apiReturn($array = array(), $code = '200', $info ='success'){
    $arr['data'] = $array;
    if(!$arr['data']){
        $arr['data'] = array();
        if($code === '200'){
            $code = "500";
        }
    }
    $arr['status'] = array(
        'code' => $code,
        'info' => $info,
    );
    ob_clean();
    return $arr;
}