<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['web']],function(){
    //访问时使用get方法，提交的时候使用post
    Route::any('login','LoginController@login');
    Route::get('code','LoginController@code');
    //上传文件
    Route::any('upload','CommonController@upload');
});

//后台管理路由
Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>['web','admin.login']],function(){
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('loginout','IndexController@loginout');
    Route::any('pass','IndexController@pass');

    //景区管理 //资源路由
    Route::resource('sceinc','SceincController');
    Route::post('sceinc/onimportant','SceincController@onImportant');
    Route::post('sceinc/onstatus','SceincController@onStatus');

    //景区路线管理 //资源路由
    Route::resource('sceincmap','SceincMapController');
    Route::post('sceincmap/onstatus','SceincMapController@onStatus');

    //文章管理
    Route::resource('article','ArticleController');
    Route::post('article/onstatus','ArticleController@onStatus');

    //公告管理
    Route::resource('notice','NoticeController');
    Route::post('notice/onstatus','NoticeController@onStatus');

    //游客评论管理
    Route::resource('trav','TravController');
    Route::post('trav/onstatus','TravController@onStatus');

    //管理员回复评论管理
    Route::resource('replay','ReplayController');
    Route::post('replay/onstatus','ReplayController@onStatus');


    //超级管理员专属权限
    //管理员管理 //资源路由
    Route::resource('adminuser','AdminuserController');
    Route::post('adminuser/onstatus','AdminuserController@onStatus');

    //权限分组管理 //资源路由
    Route::resource('auth','AuthController');
    Route::post('auth/changeOrder','AuthController@changeOrder');

    //权限分配管理 //资源路由
    Route::resource('juri','JurisdictionController');
    Route::post('juri/onstatus','JurisdictionController@onStatus');

    //用户管理 //资源路由
    Route::resource('user','UserController');
    Route::post('user/onstatus','UserController@onStatus');

    //友情链接
    Route::resource('friendlinks','FriendLinksController');
    Route::post('friendlinks/changeOrder','FriendLinksController@changeOrder');

    //自定义导航
    Route::resource('navs','NavsController');
    Route::post('navs/changeOrder','NavsController@changeOrder');

    //网站配置
    Route::resource('config','ConfigController');
    Route::post('config/changeOrder','ConfigController@changeOrder');
    Route::post('config/changeContent','ConfigController@changeContent');
    Route::get('putfile','ConfigController@putFile');

    //日志管理
    Route::resource('log','LogController');
    Route::any('log/destroyAll','LogController@destroyAll');
});

//前台路由
Route::group(['namespace'=>'Home','middleware'=>['web']],function(){
    Route::get('/','IndexController@index');

    //文章查看
    Route::get('/article','ArticleController@index');
    Route::get('/article/{art_id}','ArticleController@show');

    //景区查看
    Route::get('/sceinc','SceincController@index');
    Route::get('/sceinc/{sc_id}','SceincController@show');
    
    //线路查看
    Route::get('/route','SceincMapController@index');
    
    //登陆
    Route::any('/login','LoginController@login');
    Route::get('code','LoginController@code');
    //注册
    Route::any('/register','LoginController@register');
});

//前台登陆用户操作
Route::group(['namespace'=>'Home','middleware'=>['web','home.login']],function (){
    //显示用户信息，修改信息
    Route::resource('user','UserController');
    //评论景区
    Route::resource('trav','TravController');
    //修改密码
    Route::any('/pass','LoginController@pass');
    //退出
    Route::get('/loginout','LoginController@loginout');

});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
