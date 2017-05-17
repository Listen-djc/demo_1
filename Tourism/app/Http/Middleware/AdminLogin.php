<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Model\Juri;

class AdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session('user')){
            return redirect('admin/login');
        }
        //权限判断
        if($_SERVER["SERVER_PORT"] != "80"){
            $pageURL = $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        //获取路由
        $pageURL = str_replace($_SERVER['HTTP_HOST'].'/','',$pageURL);

        $pageURL = preg_replace('/\/\d/', '', $pageURL);
        $pageURL = rtrim($pageURL,'/');
        //正则替换   --  将提交数据中携带的id等数据替换成为空
        //echo $pageURL;
        $status = Juri::where(['ju_url'=>$pageURL,'ju_status'=>'1'])->lists('ju_id');
        if(empty($status[0])){
            return $next($request);
        }else{
            $res =Juri::where(['ju_url'=>$pageURL,'ju_status'=>'1','au_id'=>session('user')['au_id']])->first();
            if($res==NULL){
                return redirect('admin/index')->with('errors','你没有权限访问');
            }else{
                return $next($request);
            }
        }

    }
}
