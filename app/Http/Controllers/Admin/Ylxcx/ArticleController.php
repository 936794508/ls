<?php

namespace App\Http\Controllers\Admin\Ylxcx;

use App\Ylxcx\ArticleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * 说明：
     * 医院介绍固定为id为1的文章
     * 文章分类为class_type为2的分类，其余为其他类型
     * */
    private $hospitalId = 1; //医院介绍的文章ID
    private $doctorListClassId = 2; //医生列表分类ID
    private $exampleClassId = 8; //医生列表分类ID

    private $newsClassType = 2; //新闻文章类型
    private $navigatorClassType = 3; //院内导航文章类型

    /**
     * 医院介绍
     * */
    public function hospital(){
        $model = new ArticleModel();
        $article = $model->detail($this->hospitalId);
        return view('admin.ylxcx.article.hospital', ['Info'=>$article['data']]);
    }

    /**
     * 医生列表
     * @page 页码
     * @limit 取出条数
     * */
    public function doctorList(Request $request){
        $model = new ArticleModel();
        $doctorList = $model->show($request, $this->doctorListClassId);
        $count = DB::table('article')->where('class_id', $this->doctorListClassId)->count();
        return view('admin.ylxcx.article.doctorList', [
            'List'=>$doctorList['data'],
            'count' => $count,
        ]);
    }

    /**
     * 医生个人介绍
     * @Id 介绍文章Id
     * */
    public function doctorInfo($id){
        $model = new ArticleModel();
        $doctorInfo =  $model->detail($id);
        return view('admin.ylxcx.article.doctor', [
            'Info'=>$doctorInfo['data'],
        ]);
    }

    /**
     * 新闻列表
     * @page 页码
     * @limit 取出条数
     * */
    public function newsList(Request $request){
        $model = new ArticleModel();
        $List = $model->show($request, false, $this->newsClassType);
        return view('admin.ylxcx.article.doctor', [
            'List'=>$List['data'],
        ]);
    }

    /**
     * 新闻详情
     * @Id 文章Id
     * */
    public function newsInfo(Request $request){
        $model = new ArticleModel();
        return $model->detail($request->input(['Id']));
    }

    /**
     * 院内导航
     * @page 页码
     * @limit 取出条数
     * */
    public function navigator(Request $request){
        $model = new ArticleModel();
        return $model->showByClassId($request, false, $this->navigatorClassType);
    }

    /**
     * 案例
     * @page 页码
     * @limit 取出条数
     * */
    public function example(Request $request){
        $model = new ArticleModel();
        return $model->show($request, $this->exampleClassId);
    }

    /**
     * 查看任意文章列表
     * @classType  文章类型
     * @classId  文章类别可选
     * @limit 取出条数默认10条
     * */
    public function articleList(Request $request){
        $model = new ArticleModel();
        $List =  $model->showByclassType($request);
        return view('admin.ylxcx.article.doctorList', [
            'List'=> $List,
        ]);
    }

    /**
     * 查看任意文章详情
     * @Id 文章Id
     * */
    public function articleInfo(Request $request){
        $input = $request->all();

        //验证传参
        $validate = Validator::make($input, [
            'Id' => 'required'
        ]);
        if($validate->fails()){
            return apiReturn(false, '100001', '请检查参数');
        }

        //获取模型返回的数据
        $model = new ArticleModel();
        $doctorInfo =  $model->detail($input['Id']);
        return view('admin.ylxcx.article.doctor', [
            'Info'=>$doctorInfo['data'],
        ]);
    }

    /**
     * 新建文章@需要带参数classId
     * @classId 文章类别
     *
     * */
    public function createAritcle(Request $request){
        //主要用于展示添加文章的界面，同时给定classId的选项
        $input = $request->all();
        return view('admin.ylxcx.article.doctor');
    }

    /**
     * 测试-闭包
     *
     * */
    public function test(Request $request){
        $str = 'abcccdd';
        echo str_replace('bc', 'cd', $str);
        $num = 0;
        $i = 2;
        $one = function() use($num) {echo $num;};
        $two = function() use(&$num) {echo $num;};
        $num++;

        $one();
        $two();
    }
}
