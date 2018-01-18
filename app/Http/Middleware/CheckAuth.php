<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
mu     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $adminId = Session::get('admin.id');
        if($adminId){
            //已登录，继续判断权限
            $id = $request->route('id');
            $roleId = Session::get('admin.roleId');
            $routeName = $request->path();
            $routeName = trim($routeName, $id);

            //去掉都拥有的权限
            if($routeName == 'admin/index' || $roleId == 4){
                return $next($request);
            }

            //查找roleId所拥有的路由访问权限
            $roleInfo = DB::table('role')->where('Id', $roleId)->first();
            $moduleIds = explode(',', trim($roleInfo->module_ids, ','));
            $moduleList = DB::table('module')->whereIn('Id', $moduleIds)->get();

            //遍历权限，查看该用户是否有对应的路由访问权限
            foreach ($moduleList as $value){
                $route_name = explode(',', $value->route_name);
                if(in_array($routeName, $route_name)){
                    return $next($request);
                }
            }
            //没有权限
            die('无权访问！');
        }else{
            echo '<script>window.top.location.href="/admin"</script>';
            #return redirect('admin');
        }
    }
}
