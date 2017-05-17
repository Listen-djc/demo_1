@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分组权限管理
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
                <a href="{{url('admin/juri/create')}}"><i class="fa fa-plus"></i>添加分组权限</a>
                <a href="{{url('admin/juri/')}}"><i class="fa fa-recycle"></i>全部分组权限</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/juri/'.$juri->ju_id)}}" method="post">
            {{-- PUT方法提交 --}}
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>权限描述：</th>
                    <td>
                        <input type="text" class="lg" name="ju_name" value="{{$juri->ju_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>权限描述必须填写,40字以内</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>权限URL：</th>
                    <td>
                        <input type="text"  class="lg" name="ju_url" value="{{$juri->ju_url}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>权限URL必须填写</span>
                    </td>
                </tr>

                <tr>
                    <th>状态：</th>
                    <td>
                        <select name="ju_status">
                            <option value="1"
                                    @if($juri->ju_status==1)
                                    selected="selected"
                                    @endif
                            >正常使用</option>
                            <option value="0"
                                    @if($juri->ju_status==0)
                                    selected="selected"
                                    @endif
                            >停止使用</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>权限所属分组：</th>
                    <td>
                        <select name="au_id">
                            @foreach($auth as $d)
                                <option value="{{$d->au_id}}"
                                @if($d->au_id==$juri->au_id)
                                    selected="selected"
                                @endif    >{{$d->au_name}}</option>
                            @endforeach
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
