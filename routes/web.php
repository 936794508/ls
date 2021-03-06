<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Home命名空间下
Route::group(['namespace' => 'Home\Appoint'], function () {
    //登录
    Route::get('appoint/login',  'LoginController@login');
    Route::post('appoint/login_check',  'LoginController@loginCheck');

    //体检
    Route::get('appoint',  'AppointController@index');
    Route::get('appoint/toPhysical',  'AppointController@create');
    Route::post('appoint/savePhysicalData',  'AppointController@store');
});

Route::group(['namespace' => 'Home\Ylxcx'], function(){
    //医院介绍
    Route::get('ylxcx/hospital', 'ArticleController@hospital');

    //医生列表
    Route::get('ylxcx/doctorList', 'ArticleController@doctorList');

    //医生介绍
    Route::get('ylxcx/doctorInfo', 'ArticleController@doctorInfo');

    //新闻列表
    Route::get('ylxcx/newsList', 'ArticleController@newsList');

    //新闻详情
    Route::get('ylxcx/newsInfo', 'ArticleController@newsInfo');

    //院内详情
    Route::get('ylxcx/navigator', 'ArticleController@navigator');

    //案例
    Route::get('ylxcx/example', 'ArticleController@example');


    /**
     * 显示任意分类文章列表
     * */
    Route::get('ylxcx/article', 'ArticleController@articleList');

    /**
     * 显示任意文章详情
     * */
    Route::get('ylxcx/articleInfo', 'ArticleController@articleInfo');


    /**
     * 以下通过token定位用户id
     * */

    //获取用户信息
    Route::get('ylxcx/userInfo', 'UserController@userInfo');

    //保存用户信息
    Route::any('ylxcx/saveUserInfo', 'UserController@saveUserInfo');

    //test
    Route::any('ylxcx/dp', 'UserController@printWays');


    //根据token查询
    Route::get('ylxcx/getUser', 'LoginController@getUserByToken');

    Route::get('ylxcx/makeToken', 'LoginController@makeToken');
    //检查token
    Route::get('ylxcx/checkToken', 'LoginController@checkToken');

    //获取微信登录二维码
    Route::get('ylxcx/getQRCode', 'WxSendController@getQRCode');

    Route::get('ylxcx/wx_login', 'LoginController@wx');
});

Route::group(['middleware' => ['web','CheckAuth'], 'namespace' => 'Admin\Ylxcx'], function(){
    //首页
    Route::get('admin/index', 'IndexController@index');
    Route::get('admin/welcome', 'IndexController@welcome');
    Route::get('admin/welcome.html', 'IndexController@welcome');
    Route::get('admin/count', 'IndexController@count');

    //用户管理
    Route::get('admin/user', 'UsersController@index');
    Route::get('admin/user/{id}', 'UsersController@edit')->where('id', '[0-9]+');
    Route::post('admin/user/save', 'UsersController@save');
    Route::get('admin/user/editPassword', 'UsersController@editPassword');
    Route::post('admin/user/savePassword', 'UsersController@savePassword');

    /**
     * 文章管理
     * */
    //文章列表
    Route::any('admin/articleList', 'ArticleController@articleList');
    //文章详情
    Route::any('admin/articleInfo', 'ArticleController@articleInfo');
    Route::any('admin/createAritcle', 'ArticleController@createAritcle');
    Route::any('admin/test', 'ArticleController@test');
    Route::any('admin/getprime', 'ArticleController@getprime');

    Route::get('admin/hospital', 'ArticleController@hospital');
    Route::get('admin/doctorList', 'ArticleController@doctorList');
    Route::get('admin/doctorInfo/{id}', 'ArticleController@doctorInfo')->where('id', '[0-9]+');
    Route::post('admin/upload', 'ArticleController@doctorList');

    //权限管理
    Route::get('admin/auth', 'UsersController@auth');
    Route::post('admin/saveAuth', 'UsersController@saveAuth');
});


Route::group(['middleware' => ['web'], 'namespace' => 'Admin\Ylxcx'], function(){

    //登录
    Route::get('admin', 'LoginController@login');
    Route::get('admin/login_error', 'LoginController@error');
    Route::post('admin/login/check', 'LoginController@check');
    Route::get('admin/logout', 'LoginController@logout');
    Route::get('admin/userInfo', 'UsersController@userInfo');
});