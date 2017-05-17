<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Sceinc;
use App\Http\Model\Trav;
use App\Http\Model\Trav_pic;
use App\Http\Model\Replay;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\Validator;

class TravController extends CommonController
{
    //get.home/trav    全部游客评论列表
    public function index()
    {
        //分页效果
        $data = Trav::Join('sceinc','trav.sc_id','=','sceinc.sc_id')
            ->Join('user','trav.us_id','=','user.us_id')
            ->leftJoin('replay','trav.tr_id','=','replay.tr_id')
            ->select('trav.*','replay.*','sceinc.sc_name','trav.tr_id as trav_id')
            ->where(['trav.us_id'=>session('home_user')['us_id'],'tr_status'=>'1'])
            ->orderby('tr_time','desc')->paginate(2);
        $pic = Trav_pic::orderBy('tp_id','desc')->get();
        return view('home.trav.index',compact('data','pic'));
    }

    //get.home   添加游客评论
    public function create()
    {
        $data = Sceinc::find($_GET['sc_id']);
        return view('home.trav.add',compact('data'));
    }
    //post.home/trav   添加游客评论提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'tr_content'=>'required',
            ];
            $message =[
                'tr_content.required'=>'评论内容不得为空！',
            ];

            $validator = Validator::make($input,$rules,$message);
            if($validator->passes()){
                $html=[
                    'us_id'=>session('home_user')['us_id'],
                    'tr_content'=>$input['tr_content'],
                    'sc_id'=>$input['sc_id'],
                    'tr_time'=>time(),
                ];
                $re = Trav::create($html);
                if($re){

                    foreach ($input['tp_picture'] as $k=>$v){
                        $input_pic = [
                            'tr_id'=>$re->tr_id,
                            'tp_picture'=>$v,
                        ];
                        //保存图片
                        $pic = Trav_pic::create($input_pic);
                        if(!$pic){
                            return back()->with('errors','数据填充失败，请稍后再试！');
                        }
                    }

                    return redirect('/trav');
                }else{
                    return back()->with('errors','数据填充失败，请稍后再试！');
                }
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return back()->with('errors','出现一个错误！');
        }
    }

    //get.home/trav/{trav}/edit 编辑游客评论
    public function edit($tr_id)
    {
    }
    //put.home/trav/{trav} 更新游客评论
    public function update($tr_id)
    {
    }

    //get.admin /trav/{trav}  显示单个游客评论信息
    public function show($tr_id)
    {
    }

    //delete.home/trav/{trav} 删除单个游客评论
    public function destroy($tr_id)
    {
        $re = Trav::where('tr_id',$tr_id)->delete();
        if($re){
            $pic = Trav_pic::where('tr_id',$tr_id)->delete();
            $data = [
                'status'=>0,
                'msg'=>'评论删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'评论删除失败，请稍候重试！'
            ];
        }
        return $data;
    }
}

