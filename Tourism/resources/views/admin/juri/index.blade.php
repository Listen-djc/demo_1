@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部分组权限
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
                <a href="{{url('admin/juri/create')}}"><i class="fa fa-plus"></i>添加分组权限</a>
                <a href="{{url('admin/juri/')}}"><i class="fa fa-recycle"></i>全部分组权限</a>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">ID</th>
                        <th class="tc">权限描述</th>
                        <th class="tc">权限分组</th>
                        <th class="tc">权限URL</th>
                        <th class="tc" width="8%">状态</th>
                        <th class="tc" width="8%">操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">{{$v->ju_id}}</td>
                            <td class="tc" >{{$v->ju_name}}</td>
                            <td class="tc">{{$v->au_name}}</td>
                            <td class="tc">{{$v->ju_url}}</td>
                            <td class="tc"  style="text-align:center;">
                                @if($v->ju_status==1)
                                    <a href="javascript:;" onclick="onStatus('{{$v->ju_id}}',0)" style="width: 100%">正常</a>
                                @else
                                    <a href="javascript:;" onclick="onStatus('{{$v->ju_id}}',1)" style="width: 100%">停用</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{url('admin/juri/'.$v->ju_id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="delCate('{{$v->ju_id}}')">删除</a>
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

        function onStatus(ju_id,ju_status) {
            //询问框
            var stt = '';
            if(ju_status==1){
                stt='启用';
            }else{
                stt='停用';
            }
            layer.confirm('你确定要'+stt+'这个分组权限吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
            $.post("{{url('admin/juri/onstatus')}}",{'_token':'{{csrf_token()}}','ju_id':ju_id,'ju_status':ju_status,'stt':stt},function (data) {
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


        function delCate(ju_id) {
            //询问框
            layer.confirm('你确定要删除这个分组权限吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/juri')}}/"+ju_id,{'_token':'{{csrf_token()}}','_method':'delete'},function (data) {
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