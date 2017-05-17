<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //get.admin/config    全部配置项列表
    public function index()
    {
        $data = Config::orderBy('conf_id','asc')->paginate(10);
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea type="text"  class="lg" name="conf_content[]">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    //1|开启，0|关闭
                    $arr = explode('，',$v->field_value);
                    $str = '';
                    foreach ($arr as $m => $n){
                        //1|开启
                        $r = explode('|',$n);
                        $c = $v->conf_content == $r[0]?'checked="checked"':'';
                        $str.='<input type="radio" name="conf_content[]"'.$c.' value="'.$r[0].'">'.$r[1].'&nbsp;&nbsp;&nbsp;';
                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.config.index',compact('data'));
    }

    //get.admin   添加配置项
    public function create()
    {
        return view('admin.config.add');
    }

    //post.admin/config   添加配置项提交
    public function store()
    {
        if($input = Input::except('_token')){
            $rules = [
                'conf_name'=>'required',
                'conf_title'=>'required',
            ];
            $message =[
                'conf_name.required'=>'配置项名称不得为空！',
                'conf_title.required'=>'配置项标题不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $re = Config::create($input);
                if($re){
                    return redirect('admin/config');
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

    //get.admin/config/{config}/edit 编辑配置项
    public function edit($conf_id)
    {
        $data = Config::find($conf_id);
        return view('admin.config.edit',compact('data'));
    }
    //put.admin/config/{config} 更新配置项
    public function update($conf_id)
    {
        if($input = Input::except('_token','_method')){
            $rules = [
                'conf_name'=>'required',
                'conf_title'=>'required',
            ];
            $message =[
                'conf_name.required'=>'配置项名称不得为空！',
                'conf_title.required'=>'配置项标题不得为空！',
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $re = Config::where('conf_id',$conf_id)->update($input);
                if($re){
                    $this->putFile();
                    return redirect('admin/config');
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

    //get.admin /config/{config}  显示单个配置项信息
    public function show()
    {

    }

    //delete.admin/config/{config} 删除单个配置项
    public function destroy($conf_id)
    {
        $re = Config::where('conf_id',$conf_id)->delete();
        if($re){
            $this->putFile();
            $data = [
                'status'=>0,
                'msg'=>'配置项删除成功！'
            ];
        }else{
            $data = [
                'status'=>0,
                'msg'=>'配置项删除失败，请稍候重试！'
            ];
        }
        return $data;
    }

    public function changeContent(){
        $input = Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            $re = Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置项修改成功！');
    }

    public function changeOrder()
    {
        $input = Input::all();
        $conf = Config::find($input['conf_id']);
        $conf->conf_order = $input['conf_order'];
        $re = $conf->update();
        if($re){
            //添加到数据库，日志记录
            $common = new CommonController();
            $common->setlog('admin_user');
            $data = [
                'status'=>0,
                'msg'=>'配置项排序更新成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'配置项排序更新失败！'
            ];
        }
        return $data;
    }
    public function putFile(){
        $config = Config::pluck('conf_content','conf_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }
}
