<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use App\Http\Model\Navs;
use App\Http\Model\Article;
use App\Http\Model\Friend_links;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;


//设置时区为北京
date_default_timezone_set('PRC');

class CommonController extends Controller
{
    public function __construct(){
        //自定义列表
        $navs = Navs::orderBy('nav_order','asc')->get();
        //热门文章 8篇
        $article_hot = Article::where('art_status','1')->orderBy('art_view','desc')->take(8)->get();
        //友情链接
        $friend_links = Friend_links::orderBy('link_order','asc')->take(4)->get();

        View::share('navs',$navs);
        View::share('article_hot',$article_hot);
        View::share('friend_links',$friend_links);
    }
}
