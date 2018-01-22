<?php

namespace App\Http\Controllers\Home\Ylxcx;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    const APPID = 'wx9ceb210c3758accc';
    const APPSECRET = '79c245ba46054e7dfa95478fe8d4a9bf';

    /**
     * 微信登录
     * @param object $request code、encryptedData、iv用于获取openid和session_key
     * @return  string json字符串
     * */
    public function wx(Request $request){
        include_once  app_path('/Http/Controllers/Home/PHP/wxBizDataCrypt.php');
        $code  =  $request->get('code');
        $encryptedData  =  $request->get('encryptedData');
        $iv  =  $request->get('iv');

        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.self::APPID.'&secret='.self::APPSECRET.'&js_code='.$code .'&grant_type=authorization_code';

        $json = curl_request($url);

        $json = json_decode($json);

        //{"session_key":"eI8xw+oTpF6Il0N0ItvfSA==","openid":"oes8F0UoNU5M9GT5ft8lW6Npkg50"}

        if(!isset($json->errcode) && isset($json->session_key)){
            $sessionKey = $json->session_key;
            $userifo = new \WXBizDataCrypt(self::APPID, $sessionKey);

            $errCode = $userifo->decryptData($encryptedData, $iv, $data );
            file_put_contents('wxLoginInfo.txt', json_encode($data));
            if ($errCode == 0) {
                //$data = '﻿﻿{"openId":"oes8F0UoNU5M9GT5ft8lW6Npkg50","nickName":"刘帅","gender":1,"language":"zh_CN","city":"Tongzhou","province":"Beijing","country":"China","avatarUrl":"https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKBoMA48Awebk27S3gbef5db9qnIe2Y8tqt54k3m7SKKNl9rwxRgMoXiaMO97QaiaNzspWz5yQ6HaYA/0","watermark":{"timestamp":1513300870,"appid":"wx9ceb210c3758accc"}}';

                $wxData = json_decode($data);
                $userInfo = DB::table('user')->where('openid', $wxData->openId)->first();

                //数据库中有此用户
                if($userInfo){
                    $token = $this->makeToken($userInfo->Id);
                    $userInfo->token = $token;
                }else{
                    $data = array(
                        'nickname'      => $wxData->nickName,
                        'headimgurl'    => $wxData->avatarUrl,
                        'sex'           => $wxData->gender,
                        'country'       => $wxData->country,
                        'province'      => $wxData->province,
                        'city'          => $wxData->city,
                        'add_time'      => time(),
                    );
                    $userId = DB::table('user')->insertGetId($data);
                    $token = $this->makeToken($userId);
                }
                return apiReturn(array('token'=>$token));
            } else {
                return false;
            }
        }else{
            return apiReturn();
        }
    }


    /**
     * 验证token
     * */
    public function checkToken(){
        return $this->makeToken(1);
    }


    /**
     * 获取token
     * @return string $token
     * */
    public function getUserByToken(Request $request){
        $token = $request->input('token');
        if(!$token){
            return 'no token input';
        }
        $redis = app('redis.connection');
        $userId = $redis->get($token);
        if(!$userId){
            return 'no user or the token is expired';
        }
        $time = $redis->ttl($token);
        echo '有效期' . $time . 's 用户Id：';
        return $userId;
    }


    /**
     * 生成唯一token
     * @param $userId boolean/int 用户Id
     * @return string $token
     * */
    protected function makeToken($userId = false){
        if(!$userId){
            return false;
        }
        $token = str_random(40);
        $redis = app('redis.connection');
        $redis->setex($token, 7200, $userId); //设置有效时间
        return $token;
    }

}
