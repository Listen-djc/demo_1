@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 编辑权限分组
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
                <a href="{{url('admin/auth/create')}}"><i class="fa fa-plus"></i>添加权限分组</a>
                <a href="{{url('admin/auth/')}}"><i class="fa fa-recycle"></i>全部权限分组</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/auth/'.$user->au_id)}}" method="post">
            {{-- PUT方法提交 --}}
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>权限组名：</th>
                    <td>
                        <input type="text" name="au_name" value="{{$user->au_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>权限组名必须填写</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>权限组名描述：</th>
                    <td>
                        <textarea id="" cols="30" rows="10" name="au_describe">{{$user->au_describe}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>权限组排序：</th>
                    <td>
                        <input type="text" class="sm" name="au_order" value="{{$user->au_order}}">
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
