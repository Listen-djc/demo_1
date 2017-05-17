<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Model\Admin_user;
use App\Http\Model\Auth;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Collection;

class AdminuserController extends CommonController{

    //get.admin/admin    全部管理员列表
    public function index()
    {
        //表连接 管理员权限id对应的名称
        $data = Admin_user::Join('auth','admin_user.au_id','=','auth.au_id')->orderBy('ad_id','asc')->paginate(10);
        return view('admin.adminuser.index',compact('data'));
    }

    //get.admin   添加管理员
    public function create()
    {
        $auth = Auth::orderBy('au_order','asc')->get();
        return view('admin.adminuser.add',compact('auth'));
    }

    //post.admin/config   添加管理员提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'ad_name'=>'required',
                'password'=>'required|between:6,20|confirmed',
            ];
            $message =[
                'ad_name.required'=>'管理员姓名不得为空！',
                'password.required'=>'管理员密码不得为空！',
                'password.between'=>'密码必须在6-20位之间！',
                'password.confirmed'=>'密码和确认密码必须一致！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //判断用户名是否有相同
                $user = Admin_user::where('ad_name',$input['ad_name'])->first();
                if($user){
                    return back()->with('errors','管理员不可重名！');
                }

                $html = [
                    'ad_name'=>$input['ad_name'],
                    'ad_password'=>md5($input['password']),
                    'ad_phone'=>$input['ad_phone'],
                    'ad_status'=>$input['ad_status'],
                    'au_id'=>$input['au_id'],
                ];

                $re = Admin_user::create($html);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');

                    return redirect('admin/adminuser');
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

    //get.admin/adminuser/{adminuser}/edit 编辑管理员
    public function edit($ad_id)
    {
        $user = Admin_user::find($ad_id);
        $auth = Auth::orderBy('au_order','asc')->get();
        return view('admin.adminuser.edit',compact('user','auth'));
    }

    //put.admin/adminuser/{adminuser} 更新管理员
    public function update($ad_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'ad_name'=>'required',
                'password'=>'required|between:6,20|confirmed',
            ];
            $message =[
                'ad_name.required'=>'管理员姓名不得为空！',
                'password.required'=>'管理员密码不得为空！',
                'password.between'=>'密码必须在6-20位之间！',
                'password.confirmed'=>'密码和确认密码必须一致！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //判断用户名是否有相同
                $user = Admin_user::where('ad_name',$input['ad_name'])->whereNotIn ('ad_id',[$ad_id])->first();
                if($user){
                    return back()->with('errors','管理员不可重名！');
                }

                $html = [
                    'ad_name'=>$input['ad_name'],
                    'ad_password'=>md5($input['password']),
                    'ad_phone'=>$input['ad_phone'],
                    'ad_status'=>$input['ad_status'],
                    'au_id'=>$input['au_id'],
                ];

                $re = Admin_user::where('ad_id',$ad_id)->update($html);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/adminuser');
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

    //get.admin /adminuser/{adminuser}  显示单个管理员信息
    public function show()
    {

    }

    //delete.admin/adminuser/{adminuser} 删除单个管理员
    public function destroy($ad_id){
        $re = Admin_user::where('ad_id',$ad_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'管理员删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'管理员删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/adminuser/onstatus 启用/关闭 单个管理员
    public function onStatus(){
        $input = Input::all();
        if($input['ad_id']==1){
            $data = [
                'status'=>0,
                'msg'=>'超级管理员不可被关闭，请稍候重试！'
            ];
            return $data;
        }
        $user = Admin_user::find($input['ad_id']);
        $user->ad_status = $input['ad_status'];
        $re = $user->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'管理员'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'管理员状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}
