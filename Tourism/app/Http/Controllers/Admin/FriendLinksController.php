<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Friend_links;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class FriendLinksController extends CommonController
{
    //get.admin/links    全部友情链接列表
    public function index()
    {
        $data = Friend_links::orderBy('link_id','asc')->paginate(10);
        return view('admin.friendlinks.index',compact('data'));
    }
    public function changeOrder()
    {
        $input = Input::all();
        $links = Friend_links::find($input['link_id']);
        $links->link_order = $input['link_order'];
        $re = $links->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'友情链接排序更新成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'友情链接排序更新失败！'
            ];
        }
        return $data;
    }

    //get.admin   添加友情链接
    public function create()
    {
        return view('admin.friendlinks.add');
    }

    //post.admin/links   添加友情链接提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'link_name'=>'required',
                'link_url'=>'required',
            ];
            $message =[
                'link_name.required'=>'友情链接名称不得为空！',
                'link_url.required'=>'友情链接内容不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $re = Friend_links::create($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/links');
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

    //get.admin/links/{links}/edit 编辑友情链接
    public function edit($link_id)
    {
        $data = Friend_links::find($link_id);
        return view('admin.friendlinks.edit',compact('data'));
    }
    //put.admin/links/{links} 更新友情链接
    public function update($link_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'link_name'=>'required',
                'link_url'=>'required',
            ];
            $message =[
                'link_name.required'=>'友情链接名称不得为空！',
                'link_url.required'=>'友情链接内容不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $re = Friend_links::where('link_id',$link_id)->update($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/links');
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

    //get.admin /links/{links}  显示单个友情链接信息
    public function show()
    {

    }

    //delete.admin/links/{links} 删除单个友情链接
    public function destroy($link_id)
    {
        $re = Friend_links::where('link_id',$link_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'友情链接删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'友情链接删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
}
