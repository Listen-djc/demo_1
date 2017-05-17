<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Trav;
use App\Http\Model\Trav_pic;
use App\Http\Model\Replay;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;

class TravController extends CommonController
{
    //get.admin/trav    全部游客评论列表
    public function index()
    {
        //分页效果
        $data = Trav::Join('sceinc','trav.sc_id','=','sceinc.sc_id')
            ->Join('user','trav.us_id','=','user.us_id')
            ->orderby('tr_time','desc')->paginate(5);
        $pic = Trav_pic::orderBy('tp_id','desc')->get();
        $replay = Replay::orderBy('re_time','desc')->get();
        return view('admin.trav.index',compact('data','pic','replay'));
    }

    //get.admin   添加游客评论
    public function create()
    {
    }
    //post.admin/trav   添加游客评论提交
    public function store()
    {
    }

    //get.admin/trav/{article}/edit 编辑游客评论
    public function edit($tr_id)
    {
    }
    //put.admin/trav/{article} 更新游客评论
    public function update($tr_id)
    {
    }

    //get.admin /trav/{article}  显示单个游客评论信息
    public function show($tr_id)
    {
        //分页效果
        $data = Trav::Join('sceinc','trav.sc_id','=','sceinc.sc_id')
            ->Join('user','trav.us_id','=','user.us_id')
            ->find($tr_id);
        $pic = Trav_pic::orderBy('tp_id','desc')->get();
        $replay = Replay::orderBy('re_time','desc')->get();
        return view('admin.trav.show',compact('data','pic','replay'));
    }

    //delete.admin/trav/{article} 删除单个游客评论
    public function destroy($tr_id)
    {
        $re = Trav::where('tr_id',$tr_id)->delete();
        if($re){
            $pic = Trav_pic::where('tr_id',$tr_id)->delete();
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'游客评论删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'游客评论删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/trav/onstatus 启用/关闭 单篇游客评论
    public function onStatus(){
        $input = Input::all();
        $user = Trav::find($input['tr_id']);
        $user->tr_status = $input['tr_status'];
        $re = $user->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'游客评论'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'游客评论状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}

