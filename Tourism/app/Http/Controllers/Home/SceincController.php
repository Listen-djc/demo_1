<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Model\Sceinc;
use App\Http\Model\Article;
use App\Http\Model\Trav;
use App\Http\Model\Notice;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SceincController extends CommonController
{
    public function index(){
        $sceinc = Sceinc::Join('sceinc_pic','sceinc.sp_id','=','sceinc_pic.sp_id')->where('sc_status','1')->orderBy('sc_view','desc')->paginate(4);
        return view('home.sceinc.index',compact('sceinc'));
    }
    public function show($sc_id){
        $sceinc = Sceinc::Join('sceinc_pic','sceinc.sp_id','=','sceinc_pic.sp_id')->where(['sc_status'=>'1','sceinc.sc_id'=>$sc_id])->first();
        if(empty($sceinc)){
            redirect('/');
        }
        //热度的自增
        Sceinc::where('sc_id',$sc_id)->increment('sc_view',1);

        $trav = Trav::Join('user','user.us_id','=','trav.us_id')->
            leftJoin('replay','trav.tr_id','=','replay.tr_id')->
            select('trav.*','replay.*','user.us_name','trav.tr_id as trav_id')->
            where(['tr_status'=>'1','sc_id'=>$sc_id])->orderBy('tr_time','desc')->get();
        $trav_pic = Trav::Join('trav_pic','trav_pic.tr_id','=','trav.tr_id')->
            select('trav_pic.*','trav_pic.tr_id as trav_id')->
            where(['tr_status'=>'1','sc_id'=>$sc_id])->orderBy('trav_pic.tr_id','desc')->get();
        //最新公告
        $notice = Notice::where(['nt_status'=>'1','sc_id'=>$sc_id])->first();
        return view('home.sceinc.show',compact('sceinc','trav','trav_pic','notice'));
    }
}
