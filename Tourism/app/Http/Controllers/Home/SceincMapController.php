<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Model\Sceinc;
use App\Http\Model\Article;
use App\Http\Model\Sceinc_map;
use App\Http\Model\Sceinc_road_map;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SceincMapController extends CommonController
{
    public function index(){
        $data = Sceinc_map::where('ro_status','1')->orderBy('ro_view','desc')->paginate(3);
        $sceinc_road = Sceinc_road_map::Join('sceinc','road_map.sc_id','=','sceinc.sc_id')->Join('sceinc_pic','sceinc.sp_id','=','sceinc_pic.sp_id')->
        orderBy('rm_type','asc')->get();
        return view('home.sceincmap.index',compact('data','sceinc_road'));
    }
}
