@extends('layouts.home')
@section('info')
    <title>User</title>
@endsection
@section('content')
<style type="text/css">
    h3{ font-size: 18px; text-align: center; }
    .crumb_warp{  width: 600px; height: auto; margin: 0 auto; }
    .result_wrap{ margin-bottom: 50px;}
    .result_title{}
    .add_tab tr{ line-height: 35px; }
     .add_tab tr th{ padding-left: 150px; }

</style>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">

        <!--结果集标题与导航组件 开始-->
        <div class="result_wrap">
            <div class="result_title" style="text-align: center;">
                <h3>用户信息</h3>
                @if(count($errors)>0)
                    <div class="mark" style="color: red">
                        @if(is_object($errors))
                            @foreach($errors->all() as $v)
                                <p>{{$v}}</p>
                            @endforeach
                        @else
                            <p>{{$errors}}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <!--结果集标题与导航组件 结束-->

        <div class="result_wrap">
            <form action="{{url('/user/'.$user->us_id)}}" method="post">
                {{-- PUT方法提交 --}}
                <input type="hidden" name="_method" value="put">
                {{csrf_field()}}
                <table class="add_tab">
                    <tbody>
                    <tr>

                        <th><i class="require">*</i>用户姓名：</th>
                        <td>
                            <input type="text" name="us_name" value="{{$user->us_name}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>用户姓名必须填写</span>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>用户电话：</th>
                        <td>
                            <input type="text" name="us_phone" value="{{$user->us_phone}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>用户电话必须填写</span>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require"></i>用户性别：</th>
                        <td>
                            <input type="text" class="sm" name="us_sex" value="{{$user->us_sex}}">
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require"></i>用户Email：</th>
                        <td>
                            <input type="text" class="lg" name="us_email" value="{{$user->us_email}}">
                        </td>
                    </tr>

                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="修改提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection