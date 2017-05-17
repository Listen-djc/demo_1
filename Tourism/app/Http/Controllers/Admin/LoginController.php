<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Http\Model\Admin_user;

require_once (app_path() . '/Http/Controllers/Org/code/Code.class.php');

class LoginController extends CommonController{
    //显示登陆页
    public function login(){
        if(!empty(session('user'))){
            echo "<script>alert('登陆状态不可再次登陆');location.href='".url('/admin/index')."';</script>";
        }
        if($input = Input::all()){
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('msg','验证码错误！');
            }
            $user = Admin_user::where(['ad_name'=>$input['user_name'],'ad_password'=>md5($input['user_passwd'])])->first();
            if($user){
                if($user->ad_status!=1){
                    return back()->with('msg', '用户已被停用，请与管理员咨询！');
                }
                $user->ad_last_time = date('Y-m-d H:i:s',time());
                $user->ad_last_ip = $_SERVER['REMOTE_ADDR'];
                $user->update();
                session(['user'=>$user]);
                return redirect('admin/index');
            }else{
                return back()->with('msg', '用户名或密码错误！');
            }
        }else{
            return view('admin.login');
        }
    }
    //生成验证码
    public function code(){
        $code = new \Code;
        $code->make();
    }
    public function getcode(){
        $code = new \Code;
        echo $code->get();
    }
}
