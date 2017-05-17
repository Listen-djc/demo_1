@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部配置项
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
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/config/')}}"><i class="fa fa-recycle"></i>全部配置项</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changeContent')}}" method="post">
                    {{csrf_field()}}
                    <table class="list_tab">
                        <tr>
                            <th class="tc" width="5%">排序</th>
                            <th class="tc" width="5%">ID</th>
                            <th class="tc" width="10%" >名称</th>
                            <th class="tc" width="15%">标题</th>
                            <th class="tc">内容</th>
                            <th class="tc" width="8%">操作</th>
                        </tr>
                        @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" onchange="changeOrder(this,'{{$v->conf_id}}')" value="{{$v->conf_order}}">
                            </td>
                            <td class="tc">{{$v->conf_id}}</td>
                            <td class="tc" >
                                <a href="#">{{$v->conf_name}}</a>
                            </td>
                            <td align="center">{{$v->conf_title}}</td>
                            <td align="center">
                                <input type="hidden" name="conf_id[]" value="{{$v->conf_id}}">
                                {!! $v->_html !!}
                            </td>
                            <td>
                                <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="delCate('{{$v->conf_id}}')">删除</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <div class="btn_group">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                    </div>
                </form>
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
    function changeOrder(obj,conf_id) {
        var conf_order = $(obj).val();
       $.post("{{url('admin/config/changeOrder')}}",{'_token':'{{csrf_token()}}','conf_id':conf_id,'conf_order':conf_order},function (data) {
           if(data.status==0){
               layer.alert(data.msg, {icon: 6});
           }else{
               layer.alert(data.msg, {icon: 5});
           }
       });
    }
    function delCate(conf_id) {
        //询问框
        layer.confirm('你确定要删除这个配置项吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post("{{url('admin/config')}}/"+conf_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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