@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部权限表
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>自定义导航管理</h3>
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
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/auth/create')}}"><i class="fa fa-plus"></i>添加权限组</a>
                <a href="{{url('admin/auth/')}}"><i class="fa fa-recycle"></i>全部权限组</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%">排序</th>
                    <th class="tc" width="5%">ID</th>
                    <th class="tc" width="10%" >权限组名</th>
                    <th class="tc">权限描述</th>
                    <th class="tc" width="8%">操作</th>
                </tr>
                @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="changeOrder(this,'{{$v->au_id}}')" value="{{$v->au_order}}">
                        </td>
                        <td class="tc">{{$v->au_id}}</td>
                        <td class="tc" >{{$v->au_name}}</td>
                        <td align="center">{{$v->au_describe}}</td>
                        <td>
                            <a href="{{url('admin/auth/'.$v->au_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delCate('{{$v->au_id}}')">删除</a>
                        </td>
                    </tr>
                @endforeach
            </table>

            {{--  分页页面显示 --}}
            <div class="page_list">
                <ul>
                    {{$data->links()}}
                </ul>
            </div>

            <div class="page_conf">

            </div>
        </div>
    </div>
    <!--搜索结果页面 列表 结束-->

    <script type="text/javascript">

        //Ajax修改排序
        function changeOrder(obj,au_id) {
            var au_order = $(obj).val();
            $.post("{{url('admin/auth/changeOrder')}}",{'_token':'{{csrf_token()}}','au_id':au_id,'au_order':au_order},function (data) {
                if(data.status==0){
                    layer.alert(data.msg, {icon: 6});
                }else{
                    layer.alert(data.msg, {icon: 5});
                }
            });
        }

        function delCate(au_id) {
            //询问框
            layer.confirm('你确定要删除这个权限分组吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/auth')}}/"+au_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
                    location.href=location.href;//刷新当前页面
                    if(data.status==0){
                        layer.alert(data.msg, {icon: 6});
                    }else{
                        layer.alert(data.msg, {icon: 5});
                    }
                });
            }, function(){
            });
        }
    </script>
@endsection