@extends('layouts.home')
@section('info')
    <title>Pass</title>
@endsection
@section('content')
<style> 
  .crumb_warp{width: 600px; margin: 0 auto;}
  h3{ font-size: 18px; text-align: center; }
  .add_tab{ margin-bottom: 50px;rgi }
  .add_tab tr{ line-height: 45px; }
  .add_tab tr th{ padding-left: 120px; }
   .add_tab .ipt{ width: 170px; height: 22px; background:#eee; }
</style>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title" style="text-align: center;">
            <h3>修改密码</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @foreach($errors->all() as $error)
                        <p style="color: red">{{$error}}</p>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form method="post" action="">

            {{csrf_field()}}

            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>原密码：</th>
                    <td>
                        <input type="password" name="password_o" class="ipt"> <i class="require"></i>请输入原始密码
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>新密码：</th>
                    <td>
                        <input type="password" name="password" class="ipt"> <i class="require"></i>新密码6-20位
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>确认密码：</th>
                    <td>
                        <input type="password" name="password_confirmation" class="ipt"> <i class="require"></i>再次输入密码
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    </div>
@endsection