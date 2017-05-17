<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Model\Juri;
use App\Http\Model\Auth;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Collection;

class JurisdictionController extends CommonController{

    //get.admin/juri    全部权限分配表列表
    public function index()
    {
        //表连接 权限分配表权限分组id对应的名称
        $data = Juri::Join('auth','jurisdiction.au_id','=','auth.au_id')->orderBy('ju_id','asc')->paginate(10);
        return view('admin.juri.index',compact('data'));
    }

    //get.admin   添加权限分配表
    public function create()
    {
        $auth = Auth::orderBy('au_order','asc')->get();
        return view('admin.juri.add',compact('auth'));
    }

    //post.admin/config   添加权限分配表提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'ju_name'=>'required',
                'ju_url'=>'required',
            ];
            $message =[
                'ju_name.required'=>'权限描述不得为空！',
                'ju_url.required'=>'权限URL不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $html = [
                    'ju_name'=>$input['ju_name'],
                    'ju_url'=>$input['ju_url'],
                    'ju_status'=>$input['ju_status'],
                    'au_id'=>$input['au_id'],
                ];

                $re = Juri::create($html);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('Juri');

                    return redirect('admin/juri');
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

    //get.admin/juri/{juri}/edit 编辑权限分配表
    public function edit($ju_id)
    {
        $juri = Juri::find($ju_id);
        $auth = Auth::orderBy('au_order','asc')->get();
        return view('admin.juri.edit',compact('juri','auth'));
    }

    //put.admin/juri/{juri} 更新权限分配表
    public function update($ju_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'ju_name'=>'required',
                'ju_url'=>'required',
            ];
            $message =[
                'ju_name.required'=>'权限描述不得为空！',
                'ju_url.required'=>'权限URL不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $html = [
                    'ju_name'=>$input['ju_name'],
                    'ju_url'=>$input['ju_url'],
                    'ju_status'=>$input['ju_status'],
                    'au_id'=>$input['au_id'],
                ];

                $re = Juri::where('ju_id',$ju_id)->update($html);
                if($re){
                    //添加到数据库，日志记录
                    $common = new CommonController();
                    $common->setlog('Juri');
                    return redirect('admin/juri');
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

    //get.admin /juri/{juri}  显示单个权限分配表信息
    public function show()
    {

    }

    //delete.admin/juri/{juri} 删除单个权限分配表
    public function destroy($ju_id){
        $re = Juri::where('ju_id',$ju_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('Juri');
            $data = [
                'status'=>0,
                'msg'=>'权限分配表删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'权限分配表删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/juri/onstatus 启用/关闭 单个权限分配表
    public function onStatus(){
        $input = Input::all();
        $juri = Juri::find($input['ju_id']);
        $juri->ju_status = $input['ju_status'];
        $re = $juri->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('Juri');
            $data = [
                'status'=>0,
                'msg'=>'权限分配表'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'权限分配表状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}
