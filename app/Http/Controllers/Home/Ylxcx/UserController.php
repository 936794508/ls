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


    /**
     * DP算法@生成数塔
     * @floors 输入层数floors，自动随机生成数塔，单个数值在[1-99]之间
     *
     * */
    private function bulidTower($floors){
        $data = [];
        for($n=1; $n<=$floors; $n++){
            for($i=1; $i<=$n; $i++){
                $data[$n-1][] = rand(1, 99);
            }
        }
        return $data;
    }


    /**
     * DP算法@计算数塔
     * 计算数塔最大和路径
     * TODO 边界问题，比如29选择19和43，没有限定边界的话29会选择19和一个不存在的数
     * */
    public function printWays(Request $request){
        $floors = 5;
        //$tower = $this->bulidTower($floors);
        //dump($tower);
        //具体实现：自底向上计算，先计算出第floors行和第floors-1行的最优解
        $tower = [
            [25],
            [17,97],
            [37,71,55],
            [71,3,69,29],
            [84,26,15,43,19],
        ];
        $tempSum = [];
        for($n=$floors; $n>=1; $n--){
            echo "当前行数：{$n}；选择了-》";
            for($i=1; $i<=$n-1; $i++){
                //当前行下面连个可选路径中的最大数
                //$tempMax = max($tower[$n-1][$i-1], $tower[$n-1][$i]);
                if($tower[$n-1][$i-1] > $tower[$n-1][$i]){
                    $tempMax = $tower[$n-1][$i-1];
                    $path[$n-1][$i-1] = $i-1;
                }else{
                    $tempMax = $tower[$n-1][$i];
                    $path[$n-1][$i-1] = $i;
                }
                //当前行与下面路径的最大和，方便下一次计算
                $tempSum[$n-2][$i-1] = $tower[$n-2][$i-1] + $tempMax;
                echo "{$tempMax}、";
                $tempData[$n-1][$i-1] = $tempMax;
                //取最大值和其和
            }
            echo '<br>';
        }
        dd($tempData);

        /*$j = $path[1][0];
        dd($path);
        for($i = 1; $i <= $floors - 1; $i++){
            echo "第" . $i . "层数值：" . $tower[$i][$j];
            $j = $path[$i][$j];
        }*/
    }
}
