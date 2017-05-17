<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Model\Auth;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;

class AuthController extends CommonController{
    //get.admin/auth    全部权限列表
    public function index()
    {
        //表连接 权限权限id对应的名称
        $data = Auth::orderBy('au_order','asc')->paginate(10);
        return view('admin.auth.index',compact('data'));
    }

    //get.admin   添加配置项
    public function create()
    {
        return view('admin.auth.add');
    }

    //post.admin/config   添加配置项提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'au_name'=>'required',
                'au_describe'=>'required|between:6,40',
            ];
            $message =[
                'au_name.required'=>'权限组名不得为空！',
                'au_describe.required'=>'权限描述不得为空！',
                'au_describe.between'=>'权限描述在6-20位之间！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //判断用户名是否有相同
                $user =Auth::where('au_name',$input['au_name'])->first();
                if($user){
                    return back()->with('errors','权限组名不可重名！');
                }
                $re = Auth::create($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/auth');
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

    //get.admin/auth/{auth}/edit 编辑权限
    public function edit($au_id)
    {
        $user = Auth::find($au_id);
        return view('admin.auth.edit',compact('user'));
    }

    //put.admin/auth/{auth} 更新权限
    public function update($au_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'au_name'=>'required',
                'au_describe'=>'required|between:6,40',
            ];
            $message =[
                'au_name.required'=>'权限组名不得为空！',
                'au_describe.required'=>'权限描述不得为空！',
                'au_describe.between'=>'权限描述在6-20位之间！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                //判断用户名是否有相同
                $user =Auth::where('au_name',$input['au_name'])->whereNotIn('au_id',[$au_id])->first();
                if($user){
                    return back()->with('errors','权限组名不可重名！');
                }
                
                $re = Auth::where('au_id',$au_id)->update($input);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('admin_user');
                    return redirect('admin/auth');
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

    //get.admin /auth/{auth}  显示单个权限信息
    public function show()
    {

    }

    //delete.admin/auth/{auth} 删除单个权限
    public function destroy($au_id){
        $re = Auth::where('au_id',$au_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'权限删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'权限删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    
    public function changeOrder(){
        $input = Input::all();
        $auth = Auth::find($input['au_id']);
        $auth->au_order = $input['au_order'];
        $re = $auth->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'权限分组排序更新成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'权限分组排序更新失败！'
            ];
        }
        return $data;
    }
}
