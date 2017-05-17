<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Model\User;

use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Collection;

class UserController extends CommonController{
    //get.admin/user    全部游客用户列表
    public function index()
    {
        $data = User::orderBy('us_last_time','desc')->paginate(10);
        return view('admin.user.index',compact('data'));
    }

    //get.admin   添加游客用户
    public function create()
    {
        return view('admin.user.add');
    }

    //post.admin/config   添加游客用户提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'us_name'=>'required|between:3,16',
                'password'=>'required|between:6,20|confirmed',
                'us_phone'=>'required|between:6,15',
            ];
            $message =[
                'us_name.required'=>'游客用户姓名不得为空！',
                'us_name.between'=>'用户姓名必须在3-16位之间！',
                'password.required'=>'游客用户密码不得为空！',
                'password.between'=>'密码必须在6-20位之间！',
                'password.confirmed'=>'密码和确认密码必须一致！',
                'us_phone.required'=>'用户电话不得为空！',
                'us_phone.between'=>'用户电话必须在6-15位之间！'
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //判断用户名是否有相同
                $user = User::where('us_name',$input['us_name'])->first();
                if($user){
                    return back()->with('errors','游客用户不可重名！');
                }

                $html = [
                    'us_name'=>$input['us_name'],
                    'us_password'=>md5($input['password']),
                    'us_phone'=>$input['us_phone'],
                    'us_sex'=>$input['us_sex'],
                    'us_email'=>$input['us_email'],
                    'us_last_time'=>time(),
                    'us_status'=>$input['us_status'],
                ];

                $re = User::create($html);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/user');
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

    //get.admin/user/{user}/edit 编辑游客用户
    public function edit($us_id)
    {
        $user = User::find($us_id);
        return view('admin.user.edit',compact('user'));
    }

    //put.admin/user/{user} 更新游客用户
    public function update($us_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'us_name'=>'required|between:3,16',
                'password'=>'required|between:6,20|confirmed',
                'us_phone'=>'required|between:6,15',
            ];
            $message =[
                'us_name.required'=>'游客用户姓名不得为空！',
                'us_name.between'=>'用户姓名必须在3-16位之间！',
                'password.required'=>'游客用户密码不得为空！',
                'password.between'=>'密码必须在6-20位之间！',
                'password.confirmed'=>'密码和确认密码必须一致！',
                'us_phone.required'=>'用户电话不得为空！',
                'us_phone.between'=>'用户电话必须在6-15位之间！'
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //判断用户名是否有相同
                $user = User::where('us_name',$input['us_name'])->whereNotIn ('us_id',[$us_id])->first();
                if($user){
                    return back()->with('errors','游客用户不可重名！');
                }

                $html = [
                    'us_name'=>$input['us_name'],
                    'us_password'=>md5($input['password']),
                    'us_phone'=>$input['us_phone'],
                    'us_sex'=>$input['us_sex'],
                    'us_email'=>$input['us_email'],
                    'us_status'=>$input['us_status'],
                ];

                $re = User::where('us_id',$us_id)->update($html);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/user');
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

    //get.admin /user/{user}  显示单个游客用户信息
    public function show()
    {

    }

    //delete.admin/user/{user} 删除单个游客用户
    public function destroy($us_id){
        $re = User::where('us_id',$us_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'游客用户删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'游客用户删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/user/onstatus 启用/关闭 单个游客用户
    public function onStatus(){
        $input = Input::all();
        $user = User::find($input['us_id']);
        $user->us_status = $input['us_status'];
        $re = $user->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'游客用户'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'游客用户状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}
