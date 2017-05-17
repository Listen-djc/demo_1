<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Model\Admin_user;
use App\Http\Model\Sceinc;
use App\Http\Model\Sceinc_pic;

use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Collection;

class SceincController extends CommonController{
    //get.admin/sceinc    全部景区列表
    public function index()
    {
        if(session('user')['au_id']==1){
            $data = Sceinc::Join('sceinc_pic','sceinc.sp_id','=','sceinc_pic.sp_id')->
            leftJoin('admin_user','sceinc.ad_id','=','admin_user.ad_id')->
            orderBy('sc_view','desc')->paginate(5);
        }else{
            $data = Sceinc::Join('sceinc_pic','sceinc.sp_id','=','sceinc_pic.sp_id')->
            Join('admin_user','sceinc.ad_id','=','admin_user.ad_id')->
            where('sceinc.ad_id',session('user')['ad_id'])->orderBy('sc_view','desc')->paginate(5);
        }

        return view('admin.sceinc.index',compact('data'));
    }

    //get.admin   添加景区
    public function create()
    {
        $admin = Admin_user::where(['au_id'=>2,'ad_status'=>1])->get();
        return view('admin.sceinc.add',compact('admin'));
    }

    //post.admin/sceinc   添加景区提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'sc_name'=>'required',
                'sc_keyword'=>'required|between:6,20',
                'sc_introduce'=>'required',
            ];
            $message =[
                'sc_name.required'=>'景区名称不得为空！',
                'sc_keyword.required'=>'景区关键词不得为空！',
                'sc_keyword.between'=>'景区关键词必须在3-16位之间！',
                'sc_introduce.required'=>'景区介绍不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                $input_pic = [
                    'sp_picture'=>$input['sp_picture'],
                    'sp_time'=>time(),
                ];

                //保存图片
                $pic = Sceinc_pic::create($input_pic);
                if(!$pic){
                    return back()->with('errors','数据填充失败，请稍后再试！');
                }

                $html = [
                    'sc_name'=>$input['sc_name'],
                    'sc_keyword'=>$input['sc_keyword'],
                    'sc_introduce'=>$input['sc_introduce'],
                    'sc_price'=>$input['sc_price'],
                    'sc_pre_price'=>$input['sc_pre_price'],
                    'sc_cre_time'=>time(),
                    'sc_time'=>time(),
                    'sc_status'=>$input['sc_status'],
                    'sp_id'=>$pic->sp_id,
                    'ad_id'=>$input['ad_id'],
                ];

                $re = Sceinc::create($html);
                if($re){

                    $picc = Sceinc_pic::find($pic->sp_id);
                    $picc->sc_id = $re->sc_id;
                    $picc->update();
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/sceinc');
                }else{
                    return back()->with('errors','数据填充失败，请稍后再试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return back()->with('errors','请不要重复提交！');
        }
    }

    //get.admin/sceinc/{sceinc}/edit 编辑景区
    public function edit($sc_id)
    {

        //敏感操作需要权限判断
        if(session('user')['au_id']!=1){
            $re = Sceinc::find($sc_id);
            if($re->ad_id!=session('user')['ad_id']){
                return back()->with('errors','你没有权限进行此操作！');
            }
        }

        $sceinc = Sceinc::Join('sceinc_pic','sceinc.sp_id','=','sceinc_pic.sp_id')->find($sc_id);
        $admin = Admin_user::where(['au_id'=>2,'ad_status'=>1])->get();
        return view('admin.sceinc.edit',compact('sceinc','admin'));
    }

    //put.admin/sceinc/{sceinc} 更新景区
    public function update($sc_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'sc_name'=>'required',
                'sc_keyword'=>'required|between:6,20',
                'sc_introduce'=>'required',
            ];
            $message =[
                'sc_name.required'=>'景区名称不得为空！',
                'sc_keyword.required'=>'景区关键词不得为空！',
                'sc_keyword.between'=>'景区关键词必须在3-16位之间！',
                'sc_introduce.required'=>'景区介绍不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //敏感操作需要权限判断

                if(session('user')['au_id']!=1){
                    $re = Sceinc::find($sc_id);
                    if($re->ad_id!=session('user')['ad_id']){
                        return back()->with('errors','你没有权限进行此操作！');
                    }
                }

                $input_pic = [
                    'sp_picture'=>$input['sp_picture'],
                    'sp_time'=>time(),
                ];

                //修改
                $pic = Sceinc_pic::find($input['sp_id']);
                $pic->update($input_pic);

                $html = [
                    'sc_name'=>$input['sc_name'],
                    'sc_keyword'=>$input['sc_keyword'],
                    'sc_introduce'=>$input['sc_introduce'],
                    'sc_price'=>$input['sc_price'],
                    'sc_pre_price'=>$input['sc_pre_price'],
                    'sc_time'=>time(),
                    'sc_status'=>$input['sc_status'],
                    'sp_id'=>$input['sp_id'],
                    'ad_id'=>$input['ad_id'],
                ];

                $re = Sceinc::find($sc_id)->update($html);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/sceinc');
                }else{
                    return back()->with('errors','请不要重复提交！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return back()->with('errors','出现一个input错误！');
        }

    }

    //get.admin /sceinc/{sceinc}  显示单个景区信息
    public function show()
    {

    }

    //delete.admin/sceinc/{sceinc} 删除单个景区
    public function destroy($sc_id){

        //敏感操作需要权限判断
        if(session('user')['au_id']!=1){
            $re = Sceinc::find($sc_id);
            if($re->ad_id!=session('user')['ad_id']){
                return back()->with('errors','你没有权限进行此操作！');
            }
        }

        $re = Sceinc::where('sc_id',$sc_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'景区删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'景区删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/sceinc/onstatus 启用/关闭 单个景区
    public function onStatus(){
        $input = Input::all();

        //敏感操作需要权限判断
        if(session('user')['au_id']!=1){
            $re = Sceinc::find($input['sc_id']);
            if($re->ad_id!=session('user')['ad_id']){
                return back()->with('errors','你没有权限进行此操作！');
            }
        }

        $sceinc = Sceinc::find($input['sc_id']);
        $sceinc->sc_status = $input['sc_status'];
        $re = $sceinc->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'景区'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'景区状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}

