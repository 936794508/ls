<?php

namespace App\Ylxcx;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class User extends Model
{
    //

    protected $table = "users";
    public $timestamps = false;


    /**
     * 通过id查找用户信息
     * */
    public function getUserInfoById($id){
        return User::all();
    }

    /**
     * 通过token查找用户信息
     * */
    public function getUserInfoByToken($token){
        $id = $this->getUserIdBytoken($token);
        if($id == false){
            return false;
        }
        return User::where('id', $id)->first();
    }

    /**
     * 通过token查找id
     * */
    public function getUserIdBytoken($token){
        $redis = app('redis.connection');
        $userId = $redis->get($token);
        return $userId?:false;
    }
}
