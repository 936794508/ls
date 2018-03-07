<?php

namespace App\Http\Controllers\Admin\Ylxcx;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function Index(){
        return view('admin.ylxcx.common.index');
    }

    public function Welcome(){
        //统计部分
        $phpCfg = ini_get_all();
        dd($phpCfg);

        //服务器信息部分
        $severInfo = [
            ['name'=> 'php版本号', 'value'=> PHP_VERSION],
            ['name'=> 'zend版本号', 'value'=> zend_version()],
            ['name'=> '服务器系统', 'value'=> PHP_OS],
            ['name'=> '最大可上传附件限制', 'value'=> get_cfg_var ("upload_max_filesize")?get_cfg_var ("upload_max_filesize"):"不允许上传附件"],

            ['name'=> '最大内存限制', 'value'=> get_cfg_var ("memory_limit")?get_cfg_var("memory_limit"):"无"],
            ['name'=> '服务器时间', 'value'=> date("Y-m-d G:i:s")],
            ['name'=> '服务器域名', 'value'=> $_SERVER['HTTP_HOST']],
            ['name'=> '服务器端口', 'value'=> $_SERVER["SERVER_PORT"]],
        ];
        //dd($severInfo);
        return view('admin.ylxcx.index.Welcome', ['serverInfo'=> $severInfo]);
    }
}
