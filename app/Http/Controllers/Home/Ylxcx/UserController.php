<?php

namespace App\Http\Controllers\Home\Ylxcx;

use App\Ylxcx\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 获取用户信息
     * @
     * */
    public function userInfo($id){
        $userModel = new User();
        $info= $userModel->getUserInfo($id);
        dd($info);
    }

}
