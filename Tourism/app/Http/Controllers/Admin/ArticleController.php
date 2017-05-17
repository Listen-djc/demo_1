<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Sceinc;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //get.admin/article    全部文章列表
    public function index()
    {
        //分页效果
        $data = Article::Join('sceinc','article.sc_id','=','sceinc.sc_id')->orderby('art_time','desc')->paginate(10);
        return view('admin.article.index',compact('data'));
    }

    //get.admin   添加文章
    public function create()
    {
        $data = Sceinc::orderBy('sc_view','desc')->get();
        return view('admin.article.add',compact('data'));
    }
    //post.admin/article   添加文章提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'art_title'=>'required',
                'art_content'=>'required',
                'art_tag'=>'required',
                'art_description'=>'required',
                'art_editor'=>'required',
            ];
            $message =[
                'art_title.required'=>'文章名称不得为空！',
                'art_content.required'=>'文章内容不得为空！',
                'art_tag'=>'文章关键词不得为空！',
                'art_description'=>'文章描述不得为空！',
                'art_editor'=>'文章作者不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $input['art_time'] = time();
                $re = Article::create($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/article');
                }else{
                    return back()->with('errors','数据填充失败，请稍后再试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return back()->with('errors','出现一个错误！');
        }
    }


    //get.admin/article/{article}/edit 编辑文章
    public function edit($art_id)
    {
        $data = Article::find($art_id);
        $sceinc = Sceinc::orderBy('sc_view','desc')->get();
        return view('admin.article.edit',compact('data','sceinc'));
    }
    //put.admin/article/{article} 更新文章
    public function update($art_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'art_title'=>'required',
                'art_content'=>'required',
                'art_tag'=>'required',
                'art_description'=>'required',
                'art_editor'=>'required',
            ];
            $message =[
                'art_title.required'=>'文章名称不得为空！',
                'art_content.required'=>'文章内容不得为空！',
                'art_tag'=>'文章关键词不得为空！',
                'art_description'=>'文章描述不得为空！',
                'art_editor'=>'文章作者不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $input['art_time'] = time();
                $re = Article::where('art_id',$art_id)->update($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/article');
                }else{
                    return back()->with('errors','出现一个错误！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return back()->with('errors','出现一个错误！');
        }

    }

    //get.admin /article/{article}  显示单个文章信息
    public function show($art_id)
    {
        $data = Article::find($art_id);
        return view('admin.article.show',compact('data'));
    }

    //delete.admin/article/{article} 删除单个文章
    public function destroy($art_id)
    {
        $re = Article::where('art_id',$art_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'文章删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'文章删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/article/onstatus 启用/关闭 单篇文章
    public function onStatus(){
        $input = Input::all();
        $user = Article::find($input['art_id']);
        $user->art_status = $input['art_status'];
        $re = $user->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'文章'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'文章状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}

