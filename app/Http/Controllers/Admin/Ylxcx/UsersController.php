<?php

namespace App\Http\Controllers\Admin\Ylxcx;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    //用户列表
    public function index(){
        $usersList = DB::table('users')
            ->select('users.*', 'role.role_name')
            ->leftJoin('role', 'users.role_id', '=', 'role.Id')
            ->orderBy('users.Id', 'desc')
            ->paginate(8);
        $count = DB::table('users')->count();
        return view('admin.ylxcx.users.list', ['usersList' => $usersList, 'count'=>$count]);
    }

    //获取用户列表接口
    public function userInfo(Request $request){
        $data = $request->all();
        $skip = isset($data['page'])?($data['page']-1) * ($data['limit']):0;
        $take = isset($data['limit'])?$data['limit']:10;
        $usersList = DB::table('users')
            ->select('users.*', 'role.role_name')
            ->leftJoin('role', 'users.role_id', '=', 'role.Id')
            ->orderBy('users.Id', 'desc')
            ->skip($skip)
            ->take($take)
            ->get();

        $count = DB::table('users')
            ->select('users.*', 'role.role_name')
            ->leftJoin('role', 'users.role_id', '=', 'role.Id')
            ->count();
        $arr = [
            'code'  => 0,
            'msg'   => 'ok',
            'count' => $count,
            'data'  => $usersList
        ];
        return response(json_encode($arr))
            ->header('Content-type', 'application/json');
    }

    //编辑用户
    public function edit($id){
        $userInfo = DB::table('users')->where('Id', $id)->first();
        $roleList = DB::table('role')->orderBy('Id', 'desc')->get();
        return view('admin.ylxcx.users.add', ['userInfo' => $userInfo, 'usersLevel' => $roleList]);
    }

    //保存
    public function save(Request $request){
        $id = $request->input('id');
        $userInfo = DB::table('users')->where('Id', $id)->first();
        if($userInfo->role_id == 4){
            return error('/admin/user', '超级管理员权限不可修改！');
        }
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['role_id'] = $request->input('role_id');
        $bool = DB::table('users')->where('Id', $id)->update($data);
        if($bool){
            return Redirect::to('admin/user');
        }else{
            return error('/admin/user', '修改失败！');
        }
    }

    //修改密码
    public function editPassword(){
        return view('admin.ylxcx.users.editPassword');
    }

    //保存密码
    public function savePassword(Request $request){
        $data = $request->all();
        $adminId = Session::get('admin.id');
        $userInfo = DB::table('users')->where('Id', $adminId)->first();
        if(md5($data['old_password']) == $userInfo->password){
            $bool = DB::table('users')->where('Id', $adminId)->update(['password' => md5($data['new_password'])]);
            if($bool !== false){
                return success('/admin/user/editPassword', '修改成功！');
            }
            return error('/admin/user/editPassword', '修改失败！');
        }
        return error('/admin/user/editPassword', '旧密码错误！');
    }

    //权限管理
    public function auth(){
        $authList = DB::table('role')->get();
        $moduleList = DB::table('module')->get();
        return view('admin.ylxcx.users.auth', ['authList' => $authList, 'moduleList' => $moduleList]);
    }

    //保存权限
    public function saveAuth(Request $request){
        $data = $request->all();
        unset($data['_token']);
        foreach($data as $key=>$value){
            if(is_array($value)){
                DB::table('role')->where('Id', $key)
                    ->update([
                        'module_ids' => implode(',', array_keys($value, 'on')) . ','
                    ]);
            }
        }
        return Redirect::to('admin/auth');
    }
}
