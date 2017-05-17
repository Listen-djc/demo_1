<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Notice;
use App\Http\Model\Sceinc;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;

class NoticeController extends CommonController
{
    //get.admin/notice    全部公告列表
    public function index()
    {
        if(session('user')['au_id']==1){
            //分页效果
            $data = Notice::Join('sceinc','notice.sc_id','=','sceinc.sc_id')->orderby('nt_time','desc')->paginate(10);
        }else{
            //分页效果
            $data = Notice::Join('sceinc','notice.sc_id','=','sceinc.sc_id')->where('ad_id',session('user')['ad_id'])->orderby('nt_time','desc')->paginate(10);
        }

        return view('admin.notice.index',compact('data'));
    }

    //get.admin   添加公告
    public function create()
    {
        if(session('user')['au_id']==1){
            $data = Sceinc::orderBy('sc_view','desc')->get();
        }else{
            $data = Sceinc::where('ad_id',session('user')['ad_id'])->orderBy('sc_view','desc')->get();
        }
        if(!count($data)){
            return back()->with('errors','抱歉，你现在无法添加公告！');
        }
        return view('admin.notice.add',compact('data'));
    }
    //post.admin/notice   添加公告提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'nt_title'=>'required',
                'nt_content'=>'required',
            ];
            $message =[
                'nt_title.required'=>'公告名称不得为空！',
                'nt_content.required'=>'公告内容不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $input['nt_time'] = time();
                $re = Notice::create($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/notice');
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


    //get.admin/notice/{notice}/edit 编辑公告
    public function edit($nt_id)
    {

        //敏感操作需要权限判断
        if(session('user')['au_id']!=1){
            $re = Notice::Join('sceinc','sceinc.sc_id','=','notice.sc_id')
                ->where('nt_id',$nt_id)->get();
            if($re->ad_id!=session('user')['ad_id']){
                return back()->with('errors','你没有权限进行此操作！');
            }
        }

        $data = Notice::find($nt_id);
        $sceinc = Sceinc::orderBy('sc_view','desc')->get();
        return view('admin.notice.edit',compact('data','sceinc'));
    }
    //put.admin/notice/{notice} 更新公告
    public function update($nt_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'nt_title'=>'required',
                'nt_content'=>'required',
            ];
            $message =[
                'nt_title.required'=>'公告名称不得为空！',
                'nt_content.required'=>'公告内容不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //敏感操作需要权限判断
                if(session('user')['au_id']!=1){
                    $re = Notice::Join('sceinc','sceinc.sc_id','=','notice.sc_id')
                        ->find($nt_id);
                    if($re->ad_id!=session('user')['ad_id']){
                        return back()->with('errors','你没有权限进行此操作！');
                    }
                }

                $input['nt_time'] = time();
                $re = Notice::where('nt_id',$nt_id)->update($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/notice');
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

    //get.admin /notice/{notice}  显示单个公告信息
    public function show($nt_id)
    {
    }

    //delete.admin/notice/{notice} 删除单个公告
    public function destroy($nt_id)
    {

        //敏感操作需要权限判断
        if(session('user')['au_id']!=1){
            $re = Notice::Join('sceinc','sceinc.sc_id','=','notice.sc_id')
                ->find($nt_id);
            if($re->ad_id!=session('user')['ad_id']){
                return back()->with('errors','你没有权限进行此操作！');
            }
        }

        $re = Notice::where('nt_id',$nt_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'公告删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'公告删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/notice/onstatus 启用/关闭 单篇公告
    public function onStatus(){
        $input = Input::all();

        //敏感操作需要权限判断
        if(session('user')['au_id']!=1){
            $re = Notice::Join('sceinc','sceinc.sc_id','=','notice.sc_id')
                ->find($input['nt_id']);
            if($re->ad_id!=session('user')['ad_id']){
                return back()->with('errors','你没有权限进行此操作！');
            }
        }

        $user = Notice::find($input['nt_id']);
        $user->nt_status = $input['nt_status'];
        $re = $user->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'公告'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'公告状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}

