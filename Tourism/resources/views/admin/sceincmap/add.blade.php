@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加景区路线
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
                <a href="{{url('admin/sceincmap/create')}}"><i class="fa fa-plus"></i>添加景区路线</a>
                <a href="{{url('admin/sceincmap/')}}"><i class="fa fa-recycle"></i>全部景区路线</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url('admin/sceincmap')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>景区路线名称：</th>
                    <td>
                        <input type="text" name="ro_name">
                        <span><i class="fa fa-exclamation-circle yellow"></i>景区路线名称必须填写</span>
                    </td>
                </tr>

                <tr>
                    <th><i class="require"></i>景区路线价格（成人）：</th>
                    <td>
                        <input type="text" class="sm" name="ro_price">
                    </td>
                </tr>

                <tr>
                    <th><i class="require"></i>优惠后价格</th>
                    <td>
                        <input type="text" class="sm" name="ro_pre_price">
                    </td>
                </tr>

                <tr>
                    <th><i class="require"></i>行程天数：</th>
                    <td>
                        <input type="text" class="sm" name="ro_time">天
                    </td>
                </tr>

                <tr>
                    <th><i class="require"></i>优惠开始时间：</th>
                    <td>
                        <input type="date" name="ro_pre_time"  value="2017-03-01"/>
                    </td>
                </tr>
                <tr>
                    <th>状态：</th>
                    <td>
                        <select name="ro_status">
                            <option value="1">正常使用</option>
                            <option value="0">停止使用</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>路线景点：</th>
                    <td style="font-size: 14px;">
                        @foreach($sceinc as $s)
                            <input type="checkbox" name="rm_type[]" value="{{$s->sc_id}}">{{$s->sc_name}}
                        @endforeach
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
