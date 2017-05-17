<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController
{
    //get.admin/navs    全部自定义导航列表
    public function index()
    {
        $data = Navs::orderBy('nav_id','asc')->paginate(10);
        return view('admin.navs.index',compact('data'));
    }

    //get.admin   添加自定义导航
    public function create()
    {
        return view('admin.navs.add');
    }

    //post.admin/navs   添加自定义导航提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'nav_name'=>'required',
                'nav_url'=>'required',
            ];
            $message =[
                'nav_name.required'=>'自定义导航名称不得为空！',
                'nav_url.required'=>'自定义导航内容不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $re = Navs::create($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/navs');
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

    //get.admin/navs/{navs}/edit 编辑自定义导航
    public function edit($nav_id)
    {
        $data = Navs::find($nav_id);
        return view('admin.navs.edit',compact('data'));
    }
    //put.admin/navs/{navs} 更新自定义导航
    public function update($nav_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'nav_name'=>'required',
                'nav_url'=>'required',
            ];
            $message =[
                'nav_name.required'=>'自定义导航名称不得为空！',
                'nav_url.required'=>'自定义导航内容不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $re = Navs::where('nav_id',$nav_id)->update($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/navs');
                }else{
                    return back()->with('errors','出现一个错误！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return back()->with('errors','出现一个input错误！');
        }

    }

    //get.admin /navs/{navs}  显示单个自定义导航信息
    public function show()
    {

    }

    //delete.admin/navs/{navs} 删除单个自定义导航
    public function destroy($nav_id)
    {
        $re = Navs::where('nav_id',$nav_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'自定义导航删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'自定义导航删除失败，请稍候重试！'
            ];
        }
        return $data;
    }

    public function changeOrder()
    {
        $input = Input::all();
        $nav = Navs::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $re = $nav->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'自定义导航排序更新成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'自定义导航排序更新失败！'
            ];
        }
        return $data;
    }
}
