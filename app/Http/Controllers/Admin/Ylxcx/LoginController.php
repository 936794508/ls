<?php

namespace App\Http\Controllers\Admin\Ylxcx;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //
    public function login(Request $request){
        $status = $request->all();
        return view('admin.ylxcx.login.login', ['status' => $status]);

    }

    //
    public function error(){
        return view('admin.ylxcx.login.login', ['status' => 'error']);

    }

    //
    public function logout(){
        Session::forget('admin');
        return Redirect::to('admin/index');
    }

    //
    public function check(Request $request){
        $username = $request->all();
        //DB::connection()->enableQueryLog();
        $userInfo = DB::table('users')
            ->where([
                ['user_mobile', '=', $username['username']],
                ['password', '=' , MD5($username['password'])],
            ])
            ->first();
        if($userInfo){
            Session::put('admin.id', $userInfo->id);
            Session::put('admin.name', $userInfo->nickname);
            Session::put('admin.roleId', $userInfo->role_id);
            Session::save();
            return Redirect::to('admin/index');
        }else{
            return Redirect::to('admin/login_error');
        }
        //print_r(DB::getQueryLog());
    }
}
