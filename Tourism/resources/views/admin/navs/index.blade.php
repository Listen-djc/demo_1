@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部自定义导航
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>自定义导航管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加自定义导航</a>
                    <a href="{{url('admin/navs/')}}"><i class="fa fa-recycle"></i>全部自定义导航</a>
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
                        <th class="tc" width="10%" >链接名称</th>
                        <th class="tc" width="15%">链接别名</th>
                        <th class="tc">链接地址</th>
                        <th class="tc" width="8%">操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="changeOrder(this,'{{$v->nav_id}}')" value="{{$v->nav_order}}">
                        </td>
                        <td class="tc">{{$v->nav_id}}</td>
                        <td class="tc" >
                            <a href="{{$v->nav_url}}">{{$v->nav_name}}</a>
                        </td>
                        <td align="center">{{$v->nav_alias}}</td>
                        <td align="center">{{$v->nav_url}}</td>
                        <td>
                            <a href="{{url('admin/navs/'.$v->nav_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delCate('{{$v->nav_id}}')">删除</a>
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

<div class="page_nav">

</div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

<script type="text/javascript">
    //Ajax修改排序
    function changeOrder(obj,nav_id) {
        var nav_order = $(obj).val();
       $.post("{{url('admin/navs/changeOrder')}}",{'_token':'{{csrf_token()}}','nav_id':nav_id,'nav_order':nav_order},function (data) {
           if(data.status==0){
               layer.alert(data.msg, {icon: 6});
           }else{
               layer.alert(data.msg, {icon: 5});
           }
       });
    }
    function delCate(nav_id) {
        //询问框
        layer.confirm('你确定要删除这个自定义导航吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/navs')}}/"+nav_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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