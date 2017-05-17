<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Log;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LogController extends CommonController
{
    //get.admin/log    全部日志列表
    public function index()
    {
        $data = Log::Join('admin_user','admin_user.ad_id','=','log.ad_id')->orderBy('lg_time','desc')->paginate(10);
        return view('admin.log.index',compact('data'));
    }
    
    //get.admin   添加日志
    public function create()
    {
    }
    //post.admin/log   添加日志提交
    public function store()
    {
    }
    //get.admin/log/{log}/edit 编辑日志
    public function edit($link_id)
    {
    }
    //put.admin/log/{log} 更新日志
    public function update($link_id)
    {
    }
    //get.admin /log/{log}  显示单个日志信息
    public function show()
    {
    }

    //delete.admin/log/{log} 删除单个日志
    public function destroy($lg_id)
    {
        $re = Log::where('lg_id',$lg_id)->delete();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'日志删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'日志删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //delete.admin/log/{log} 删除全部日志
    public function destroyAll()
    {
        $re = Log::truncate();
        if($re){
            $data = [
                'status'=>0,
                'msg'=>'全部日志清理成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'全部日志清理失败，请稍候重试！'
            ];
        }
        return $data;
    }
}
