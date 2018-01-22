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
        return apiReturn($info);
    }

    /**
     * 保存用户信息
     * @
     * */
    public function saveUserInfo(Request $request){
        $data = $request->all();
        $userModel = new User();
        $id = $userModel->getUserIdBytoken($data['token']);
        $data = [
            'nickname' => 'liushuai',
        ];
        $res = DB::table('users')
            ->where(['id' => $id])
            ->update($data);
        if($res){
            return apiReturn(false);
        }else{
            return apiReturn(false, $code = '-1', $info = 'save failed');
        }
    }
}

