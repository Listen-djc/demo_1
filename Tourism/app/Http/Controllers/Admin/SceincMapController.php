<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Model\Sceinc_map;
use App\Http\Model\Sceinc_road_map;
use App\Http\Model\Sceinc;

use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Collection;

class SceincMapController extends CommonController{
    //get.admin/sceincmap    全部景区路线列表
    public function index()
    {
        $data = Sceinc_map::orderBy('ro_view','desc')->paginate(3);
        $sceinc_road = Sceinc_road_map::Join('sceinc','road_map.sc_id','=','sceinc.sc_id')->orderBy('rm_type','asc')->get();
        return view('admin.sceincmap.index',compact('data','sceinc_road'));
    }

    //get.admin   添加景区路线
    public function create()
    {
        $sceinc = Sceinc::orderBy('sc_view','desc')->get();
        return view('admin.sceincmap.add',compact('sceinc'));
    }

    //post.admin/sceincmap   添加景区路线提交
    public function store()
    {
        if($input = Input::except('_token')){
            $input['ro_pre_time'] = strtotime($input['ro_pre_time']);
            var_dump($input);
            $rules = [
                'ro_name'=>'required',
                'ro_price'=>'required',
                'ro_time'=>'required',
            ];
            $message =[
                'ro_name.required'=>'景区路线名称不得为空！',
                'ro_price.required'=>'景区路线价格！',
                'ro_time.required'=>'行程需要时间不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){

                $html = [
                    'ro_name'=>$input['ro_name'],
                    'ro_price'=>$input['ro_price'],
                    'ro_pre_price'=>$input['ro_pre_price'],
                    'ro_time'=>$input['ro_time'],
                    'ro_pre_time'=>$input['ro_pre_time'],
                    'ro_status'=>$input['ro_status'],
                ];

                $re = Sceinc_map::create($html);
                if($re){
                    //保存景点到路线表
                    $i = 0;
                    foreach ($input['rm_type'] as $v){
                        $i++;
                        $input_map = [
                            'ro_id'=>$re->ro_id,
                            'sc_id'=>$v,
                            'rm_type'=>$i,
                        ];
                        //保存景点到路线表
                        $map = Sceinc_road_map::create($input_map);
                        if(!$map){
                            return back()->with('errors','数据填充失败，请稍后再试！');
                        }
                        //添加到数据库，日志记录
                        $common = new CommonController();
                        $common->setlog('admin_user');
                    }

                    return redirect('admin/sceincmap');
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

    //get.admin/sceincmap/{sceinc}/edit 编辑景区路线
    public function edit($ro_id)
    {
        $data = Sceinc_map::find($ro_id);
        $data_map = Sceinc_road_map::Join('sceinc','road_map.sc_id','=','sceinc.sc_id')->where('ro_id',$ro_id)->get();
        $sceinc = Sceinc::orderBy('sc_view','desc')->get();
        return view('admin.sceincmap.edit',compact('data','data_map','sceinc'));
    }

    //put.admin/sceincmap/{sceinc} 更新景区路线
    public function update($ro_id)
    {
        if($input = Input::except('_token','_method')){
            $input['ro_pre_time'] = strtotime($input['ro_pre_time']);
            $rules = [
                'ro_name'=>'required',
                'ro_price'=>'required',
                'ro_time'=>'required',
            ];
            $message =[
                'ro_name.required'=>'景区路线名称不得为空！',
                'ro_price.required'=>'景区路线价格！',
                'ro_time.required'=>'行程需要时间不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $html = [
                    'ro_name'=>$input['ro_name'],
                    'ro_price'=>$input['ro_price'],
                    'ro_pre_price'=>$input['ro_pre_price'],
                    'ro_time'=>$input['ro_time'],
                    'ro_pre_time'=>$input['ro_pre_time'],
                    'ro_status'=>$input['ro_status'],
                ];
                $re = Sceinc_map::find($ro_id)->update($html);
                if($re){
                    Sceinc_road_map::where('ro_id',$ro_id)->delete();
                    //保存景点到路线表
                    $i = 0;
                    foreach ($input['rm_type'] as $v){
                        $i++;
                        $input_map = [
                            'ro_id'=>$ro_id,
                            'sc_id'=>$v,
                            'rm_type'=>$i,
                        ];
                        //保存景点到路线表
                        $map = Sceinc_road_map::create($input_map);
                        if(!$map){
                            return back()->with('errors','数据填充失败，请稍后再试！');
                        }
                        //添加到数据库，日志记录
                        $common = new CommonController();
                        $common->setlog('admin_user');
                    }
                    return redirect('admin/sceincmap');
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

    //get.admin /sceincmap/{sceinc}  显示单个景区路线信息
    public function show()
    {

    }

    //delete.admin/sceincmap/{sceinc} 删除单个景区路线
    public function destroy($ro_id){
        $re = Sceinc_map::where('ro_id',$ro_id)->delete();
        Sceinc_road_map::where('ro_id',$ro_id)->delete();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'景区路线删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'景区路线删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
    //post.admin/sceincmap/onstatus 启用/关闭 单个景区路线
    public function onStatus(){
        $input = Input::all();
        $sceinc_map = Sceinc_map::find($input['ro_id']);
        $sceinc_map->ro_status = $input['ro_status'];
        $re = $sceinc_map->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'景区路线'.$input['stt'].'成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'景区路线状态设置失败，请稍候重试！'
            ];
        }
        return $data;
    }
}

