<?php

namespace App\Http\Controllers\Home\Ylxcx;

use App\Ylxcx\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * 获取用户信息
     * @
     * */
    public function userInfo(Request $request){
        $data = $request->all();
        $userModel = new User();
        $info = $userModel->getUserInfoByToken($data['token']);
        //token是否不存在或错误
        if($info != false){
            return apiReturn($info);
        }else{
            return apiReturn($info, '404', 'token错误或者不存在');
        }
    }

    /**
     * 保存用户信息
     * @
     * */
    public function saveUserInfo(Request $request){
        $data = $request->all();
        $userModel = new User();
        $id = $userModel->getUserIdBytoken($data['token']);
        //TODO 填充完整的数据
        $data = [
            'nickname' => 'liushuai',
        ];
        $res = DB::table('users')
            ->where(['id' => $id])
            ->update($data);
        if($res){
            return apiReturn(false);
        }else{
            return apiReturn(false, '-1', 'save failed');
        }
    }

    /**
     * test
     * @
     * */
    public function test(Request $request){
        function foo(){
            $var = "sd";
        }
        $aa = foo();
        var_export($aa);
    }
}

