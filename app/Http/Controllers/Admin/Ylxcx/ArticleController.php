<?php

namespace App\Http\Controllers\Admin\Ylxcx;

use App\Ylxcx\ArticleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        return view('admin.ylxcx.article.hospital', ['hospital'=>$article['data']]);
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
            'doctorList'=>$doctorList['data'],
            'count' => $count,
        ]);
    }

    /**
     * 医生个人介绍
     * @Id 介绍文章Id
     * */
    public function doctorInfo(Request $request){
        $model = new ArticleModel();
        return $model->detail($request->input(['Id']));
    }

    /**
     * 新闻列表
     * @page 页码
     * @limit 取出条数
     * */
    public function newsList(Request $request){
        $model = new ArticleModel();
        return $model->show($request, false, $this->newsClassType);
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
}
