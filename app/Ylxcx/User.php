<?php

namespace App\Ylxcx;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //

    protected $table = "users";
    public $timestamps = false;

    public function getUserInfo($id){
        return User::all();
    }
}
