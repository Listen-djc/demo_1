<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Model\Sceinc;
use App\Http\Model\Article;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArticleController extends CommonController
{
    //显示全部文章
    public function index(){
        $article = Article::where('art_status','1')->orderBy('art_view','desc')->paginate(4);
        return view('home.article.index',compact('article'));
    }
    //显示单个文章
    public function show($art_id){
        $article = Article::Join('sceinc','sceinc.sc_id','=','article.sc_id')->where(['art_status'=>'1','art_id'=>$art_id])->first();
        if(empty($article)){
            return redirect('/');
        }
        //查看次数的自增
        Article::where('art_id',$art_id)->increment('art_view',1);

        $article['pre'] = Article::where('art_id','<',$art_id)->where('art_status','1')->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->where('art_status','1')->orderBy('art_id','asc')->first();

        $data = Article::where(['sc_id'=>$article->sc_id,'art_status'=>'1'])->orderBy('art_time','desc')->take(6)->get();


        return view('home.article.show',compact('article','data'));
    }
}
