<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Model\Log;

DB::connection()->enableQueryLog(); // 开启查询日志
//设置时区为北京
date_default_timezone_set('PRC');

class CommonController extends Controller
{

    //文件上传
    public function upload(){
        $files = Input::file('Filedata');

        if(isset($_POST['session'])){
            session_id($_POST['session']);
        }

        if($files->isValid()){
            //$realPath = $files->getRealPath();  //获取临时文件绝对路径

            $entension = $files->getClientOriginalExtension();  //获取上传文件的后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $files->move(base_path().'/public/upload/admin',$newName);
            $filesPath = 'upload/admin/'.$newName;
            return $filesPath;
        }else{
            $filesPath ='出现一个错误！';
            return $filesPath;
        }
    }

    /*
    public function getsql(){
        DB::listen(function ($sql){
            //echo $sql->sql.'</br>';
            //var_dump($sql->bindings);
            foreach ($sql->bindings as $i => $binding) {
                if ($binding instanceof \DateTime) {
                    $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    if (is_string($binding)) {
                        $sql->bindings[$i] = "'$binding'";
                    }
                }
            }

            // Insert bindings into query
            $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
            $query = vsprintf($query, $sql->bindings);
        });
    }
    */
    //生成日志
    public function setlog($table){
        DB::table($table);
        $queries = DB::getQueryLog(); // 获取查询日志
        //print_r($queries); // 即可查看执行的sql，传入的参数等等
        $query = '';
        foreach ($queries as $j => $sql){

            foreach ($sql['bindings'] as $i => $binding) {
                if ($binding instanceof \DateTime) {
                    $sql['bindings'][$i] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    if (is_string($binding)) {
                        $sql['bindings'][$i] = "'$binding'";
                    }
                }
            }
            // Insert bindings into query
            $query1 = str_replace(array('%', '?'), array('%%', '%s'), $sql['query']);

            $query1 = vsprintf($query1, $sql['bindings']);
            $query = $query.$query1.'<br/>';
        }
        
        //写入数据库
        $input = [
            'ad_id'=>session('user')['ad_id'],
            'lg_content'=>$query,
            'lg_time'=>time(),
            'lg_ip'=>$_SERVER['REMOTE_ADDR'],
        ];
        $log = Log::create($input);
    }
}
