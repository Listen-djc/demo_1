@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 修改游客用户
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors)>0)
                <div class="mark">
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
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/user/create')}}"><i class="fa fa-plus"></i>添加游客用户</a>
                <a href="{{url('admin/user/')}}"><i class="fa fa-recycle"></i>全部游客用户</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/user/'.$user->us_id)}}" method="post">
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
                    <th><i class="require">*</i>用户密码：</th>
                    <td>
                        <input type="password" name="password">
                        <span><i class="fa fa-exclamation-circle yellow"></i>密码必须填写(6-20)</span>
                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>确认密码：</th>
                    <td>
                        <input type="password" name="password_confirmation">
                        <span><i class="fa fa-exclamation-circle yellow"></i>确认密码必须与密码一致</span>
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
                    <th>状态：</th>
                    <td>
                        <select name="us_status">
                            <option value="1"
                                    @if($user->us_status==1)
                                    selected="selected"
                                    @endif
                            >正常使用</option>
                            <option value="0"
                                    @if($user->us_status==0)
                                    selected="selected"
                                    @endif
                            >停止使用</option>
                        </select>
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

@endsection
