<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Replay;
use App\Http\Model\Trav;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;

class ReplayController extends CommonController
{
    //get.admin/replay    全部管理员回复列表
    public function index()
    {
        //分页效果
        $data = Replay::Join('trav','replay.tr_id','=','trav.tr_id')
            ->Join('admin_user','replay.ad_id','=','admin_user.ad_id')
            ->orderby('re_time','desc')->paginate(10);
        return view('admin.replay.index',compact('data'));
    }

    //get.admin   添加管理员回复
    public function create()
    {
        $tid = $_GET['tr_id'];
        $data = Trav::find($tid);
        return view('admin.replay.add',compact('data'));
    }
    //post.admin/replay   添加管理员回复提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules =[
                're_content'=>'required',
            ];
            $message =[
                're_content.required'=>'管理员回复内容不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $input['re_time'] = time();
                $input['ad_id'] = session('user')['ad_id'];
                $re = Replay::create($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/replay');
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


    //get.admin/replay/{article}/edit 编辑管理员回复
    public function edit($re_id)
    {
        $data = Replay::find($re_id);
        return view('admin.replay.edit',compact('data'));
    }
    //put.admin/replay/{article} 更新管理员回复
    public function update($re_id)
    {
        if($input = Input::except('_token','_method')){
            $rules =[
                're_content'=>'required',
            ];
            $message =[
                're_content.required'=>'管理员回复内容不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $input['re_time'] = time();
                $input['ad_id'] = session('user')['ad_id'];
                $re = Replay::where('re_id',$re_id)->update($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/replay');
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

    //get.admin /replay/{article}  显示单个管理员回复信息
    public function show($tr_id)
    {
        //分页效果
        $data = Replay::Join('trav','replay.tr_id','=','trav.tr_id')
            ->Join('admin_user','replay.ad_id','=','admin_user.ad_id')
            ->where('replay.tr_id',$tr_id)->get();
        return view('admin.replay.show',compact('data'));
    }

    //delete.admin/replay/{article} 删除单个管理员回复
    public function destroy($re_id)
    {
        $re = Replay::where('re_id',$re_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'管理员回复删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'管理员回复删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/replay/onstatus 启用/关闭 单篇管理员回复
    public function onStatus(){
        $input = Input::all();
        $user = Replay::find($input['re_id']);
        $user->re_status = $input['re_status'];
        $re = $user->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'管理员回复'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'管理员回复状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}

