<?php

namespace App\Http\Controllers\Home\Ylxcx;

use App\Ylxcx\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $input = $request->all();

        //验证类
        $validate = Validator::make($input, [
            'token' => 'required|string',
            'user_name' => 'required|string',
            'user_bingshi' => 'required|string',
            'user_iden' => 'required|string',
            'user_mobile' => 'required|string',
            'sex' => 'required|string',
        ]);
        if($validate->fails()){
            return apiReturn(false, '100001', '请检查参数');
        }
        $userModel = new User();
        $id = $userModel->getUserIdBytoken($input['token']);
        if($id){
            //TODO 填充完整的数据
            $data = [
                'nickname'      => $input['user_name'],
                'sex'           => $input['sex'],
                'user_bingshi'  => $input['user_bingshi'],
                'user_identity' => $input['user_iden'],
                'user_mobile'   => $input['user_mobile'],
            ];
            $res = DB::table('users')
                ->where(['id' => $id])
                ->update($data);
            if($res){
                return apiReturn(false);
            }else{
                return apiReturn(false, '-1', 'save failed');
            }
        }else{
            return apiReturn(false, '1000404', 'token错误');
        }
    }
}
