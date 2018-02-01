<?php

namespace App\Ylxcx;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleModel extends Model
{
    //
    /**
     * 文章列表页@不管class_id全部取出到一个数组中
     * @classId 文章分类，默认为0，即不取任何数据
     * @classType  文章类型，为2时只取新闻类型的文章
     * @page  页码
     * @take  取出多少条数据
     * */
    public function show($request, $classId, $classType=1){
        $data = $request->all();
        $data['classId'] = $classId;
        $data['classType'] = $classType;
        $skip = isset($data['page'])?($data['page']-1) * ($data['limit']):0;
        $take = isset($data['limit'])?$data['limit']:10;
        $articleList = DB::table('article')
            ->select('article.*', 'article_class.class_name')
            ->leftJoin('article_class', 'article_class.Id', '=', 'article.class_id')
            ->where(function($query) use($data) {
                if ($data['classId']) {
                    $query->where('article.class_id', '=', $data['classId']);
                }
            })
            ->where(function($query) use($data) {
                if ($data['classType']) {
                    $query->where('article_class.class_type', '=', $data['classType']);
                }
            })
            ->skip($skip)
            ->take($take)
            ->paginate();
        return apiReturn($articleList);
    }

    /**
     * 文章列表页@根据class_id全部取出到多个数组中
     * @classId 文章分类，默认为0，即不取任何数据
     * @classType  文章类型，为2时只取新闻类型的文章
     * @page  页码
     * @limit  取出多少条数据
     * */
    public function showByClassId($request, $classId, $classType=1){
        $data = $request->all();
        $data['classId'] = $classId;
        $data['classType'] = $classType;
        $skip = isset($data['page'])?($data['page']-1) * ($data['limit']):0;
        $take = isset($data['limit'])?$data['limit']:10;
        $articleList = DB::table('article')
            ->select('article.*', 'article_class.class_name')
            ->leftJoin('article_class', 'article_class.Id', '=', 'article.class_id')
            ->where(function($query) use($data) {
                if ($data['classId']) {
                    $query->where('article.class_id', '=', $data['classId']);
                }
            })
            ->where(function($query) use($data) {
                if ($data['classType']) {
                    $query->where('article_class.class_type', '=', $data['classType']);
                }
            })
            ->skip($skip)
            ->take($take)
            ->get();
        $articleList = json_decode(json_encode($articleList), true);
        foreach($articleList as $v){
            $step1Arr[$v['class_name']][] = $v;
        }
        $i = 0;
        foreach($step1Arr as $k=>$v2){
            $step2Arr[$i]['class_name'] = $k;
            $step2Arr[$i]['item'] = $v2;
            $i++;
        }
        //dd($step2Arr);
        return apiReturn($step2Arr);
    }

    /**
     * 内容详情页
     * @id Int 文章id
     * */
    public function detail($id){
        if(!$id){
            return apiReturn(false, '10001', '缺少必要参数');
        }
        $articleInfo = DB::table('article')
            ->select('article.*', 'article_class.class_name')
            ->leftJoin('article_class', 'article_class.Id', '=', 'article.class_id')
            ->where('article.Id', $id)
            ->first();
        return apiReturn($articleInfo);
    }


    /**
     * 文章列表页@取出classType下面所有文章
     * @classId 文章分类，默认为0，即不取任何数据
     * @classType  文章类型，为2时只取新闻类型的文章
     * @page  页码
     * @take  取出多少条数据
     * */
    public function showByclassType($request){
        $data = $request->all();

        //下面三个参数都是可选参数
        $data['classId'] = isset($data['classId'])?$data['classId']:false;
        $data['classType'] = isset($data['classType'])?$data['classType']:false;
        $data['limit'] = isset($data['limit'])?$data['limit']:5;

        //搜索数据库
        $articleList = DB::table('article')
            ->select('article.*', 'article_class.class_name')
            ->leftJoin('article_class', 'article_class.Id', '=', 'article.class_id')
            ->where(function($query) use($data) {
                if ($data['classId']) {
                    $query->where('article.class_id', '=', $data['classId']);
                }
            })
            ->where(function($query) use($data) {
                if ($data['classType']) {
                    $query->where('article_class.class_type', '=', $data['classType']);
                }
            })
            ->paginate($data['limit']);

        //追加分页传参
        $articleList->appends(array(
            'classType' => $data['classType'],
            'classId' => $data['classId'],
            'limit' => $data['limit'],
        ));
        return $articleList;
    }
}
