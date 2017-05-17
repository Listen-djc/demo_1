<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Model\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Collection;

require_once (app_path() . '/Http/Controllers/Org/code/Code.class.php');

class LoginController extends CommonController
{
    //显示登陆页
    public function login(){
        if($input = Input::all()){
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('errors','验证码错误！');
            }
            $user = User::where(['us_name'=>$input['user_name'],'us_password'=>md5($input['user_passwd'])])->first();
            if($user){
                if($user->us_status!=1){
                    return back()->with('errors', '用户已被停用，请与管理员咨询！');
                }
                $user->us_last_time = time();
                $user->us_last_ip = $_SERVER['REMOTE_ADDR'];
                $user->update();
                session(['home_user'=>$user]);
                return redirect('/');
            }else{
                return back()->with('errors', '用户名或密码错误！');
            }
        }else{
            return view('home.login');
        }
    }
    //注册页面
    public function register(){
        $register = 1;
        if($input = Input::except('_token')){
            $code = new \Code;
            $_code = $code->get();
            if(strtoupper($input['code'])!=$_code){
                return back()->with('errors','验证码错误！');
            }
            $rules = [
                'name'=>'required|between:3,16',
                'password'=>'required|between:6,20|confirmed',
                'phone'=>'required|between:6,15',
            ];
            $message =[
                'name.required'=>'游客用户姓名不得为空！',
                'name.between'=>'用户姓名必须在3-16位之间！',
                'password.required'=>'游客用户密码不得为空！',
                'password.between'=>'密码必须在6-20位之间！',
                'password.confirmed'=>'密码和确认密码必须一致！',
                'phone.required'=>'用户电话不得为空！',
                'phone.between'=>'用户电话必须在6-15位之间！'
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()) {
                //判断用户名是否有相同
                $user = User::where('us_name', $input['name'])->first();
                if ($user) {
                    return back()->with('errors', '游客用户不可重名！');
                }

                $html = [
                    'us_name'=>$input['name'],
                    'us_password'=>md5($input['password']),
                    'us_phone'=>$input['phone'],
                    'us_sex'=>$input['sex'],
                    'us_email'=>$input['email'],
                    'us_last_time' => time(),
                ];

                $re = User::create($html);
                if ($re) {
                    //$errors = '用户注册成功！';
                    //return view('home.login',compact('errors'));
                    return redirect('/login')->with('errors','注册成功！');
                } else {
                    return back()->with('errors', '数据填充失败，请稍后再试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('home.login',compact('register'));
        }
    }

    //生成验证码
    public function code(){
        $code = new \Code;
        $code->make();
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
                $user = User::where('us_id',session('home_user')['us_id'])->first();
                if(md5($input['password_o'])==$user->us_password){
                    $user->us_password = md5($input['password']);
                    $user->update();
                    return back()->withErrors('密码修改成功！');
                }else{
                    return back()->withErrors('原密码错误！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('home.pass');
        }
    }
    public function loginout(){
        session(['home_user'=>null]);
        return redirect('/login')->with('errors','退出成功！');
    }
}
