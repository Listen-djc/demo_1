<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Model\Sceinc;
use App\Http\Model\Article;
use App\Http\Model\Notice;
use App\Http\Model\Sceinc_map;
use App\Http\Model\Sceinc_road_map;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    public function index(){
        $sceinc_pic = Sceinc::Join('sceinc_pic','sceinc.sp_id','=','sceinc_pic.sp_id')
            ->where('sc_status','1')->orderBy('sc_view','desc')->get();
        //最新文章 2篇
        $article_new = Article::where('art_status','1')->orderBy('art_time','desc')->take(2)->get();
        //最新公告 2篇
        $notice_new = Notice::where('nt_status','1')->orderBy('nt_time','desc')->take(2)->get();
        //最佳路线
        $route_new = Sceinc_map::where('ro_status','1')->orderBy('ro_view','desc')->take(2)->get();
        $sceinc_road = Sceinc_road_map::Join('sceinc','road_map.sc_id','=','sceinc.sc_id')->orderBy('rm_type','asc')->get();
        return view('home.index',compact('sceinc_pic','article_new','notice_new','route_new','sceinc_road'));
    }


}
