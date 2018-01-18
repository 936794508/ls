<?php

namespace App\Http\Controllers\Home\Appoint;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    //
    public function login(){
        return view('home.appoint.login.login');
    }

    //验证
    public function loginCheck(Request $request){
        $data = $request->all();
        $userInfo = DB::table('user')->where('user_mobile', $data['mobile'])->first();
        if($userInfo){
            return ['code' => 200, 'info' => '登录成功！'];
        }else{
            return ['code' => 1, 'info' => '没有查询到您的信息！'];
        }
    }
}
