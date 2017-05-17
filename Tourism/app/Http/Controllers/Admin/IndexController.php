<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin_user;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController{
    public function index(){
        return view('admin.index');
    }
    public function info(){
        return view('admin.info');
    }
    //退出
    public function loginout(){
        session(['user'=>null]);
        return redirect('admin/login');
    }
    //修改密码
    public function pass(){
        if($input = Input::all()){

            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];

            $message =[
                'password.required'=>'新密码不得为空！',
                'password.between'=>'新密码必须在6-20位之间！',
                'password.confirmed'=>'新密码和确认密码必须一致！',
            ];

            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $user = Admin_user::where('ad_id',session('user')['ad_id'])->first();
                if(md5($input['password_o'])==$user->ad_password){
                    $user->ad_password = md5($input['password']);
                    $user->update();
                    return back()->withErrors('密码修改成功！');
                }else{
                    return back()->withErrors('原密码错误！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }
    }
}
