<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Model\User;

use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Collection;

class UserController extends CommonController{
    //get./user    用户
    public function index()
    {
        $user = User::find(session('home_user')['us_id']);
        return view('home.user.index',compact('user'));
    }

    //put./user/{user} 更新用户
    public function update($us_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'us_name'=>'required|between:3,16',
                'us_phone'=>'required|between:6,15',
            ];
            $message =[
                'us_name.required'=>'游客用户姓名不得为空！',
                'us_name.between'=>'用户姓名必须在3-16位之间！',
                'us_phone.required'=>'用户电话不得为空！',
                'us_phone.between'=>'用户电话必须在6-15位之间！'
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //判断用户名是否有相同
                $user = User::where('us_name',$input['us_name'])->whereNotIn ('us_id',[session('home_user')['us_id']])->first();
                if($user){
                    return back()->with('errors','游客用户不可重名！');
                }

                $html = [
                    'us_name'=>$input['us_name'],
                    'us_phone'=>$input['us_phone'],
                    'us_sex'=>$input['us_sex'],
                    'us_email'=>$input['us_email'],
                ];

                $re = User::where('us_id',session('home_user')['us_id'])->update($html);
                if($re){
                    return redirect('/user')->with('errors','修改成功！');
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
}
